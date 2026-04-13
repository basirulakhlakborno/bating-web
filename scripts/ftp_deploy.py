#!/usr/bin/env python3
"""
FTP / FTPS connector: list remote files or upload production Laravel + public/dist.

Config: copy ftp_deploy_config.example.ini -> ftp_deploy_config.ini (gitignored).
Password: FTP_DEPLOY_PASSWORD overrides [ftp] password in the ini file.

Examples:
  python scripts/ftp_deploy.py list
  python scripts/ftp_deploy.py list --path public
  python scripts/ftp_deploy.py list --recursive --max-depth 2
  python scripts/ftp_deploy.py upload --dry-run
  python scripts/ftp_deploy.py upload
  python scripts/ftp_deploy.py upload --progress-every 25
  python scripts/ftp_deploy.py upload --workers 30
"""

from __future__ import annotations

import argparse
import configparser
import os
import ssl
import sys
import threading
from concurrent.futures import ThreadPoolExecutor, as_completed
from ftplib import FTP, FTP_TLS, error_perm
from pathlib import Path


SCRIPT_DIR = Path(__file__).resolve().parent
REPO_ROOT = SCRIPT_DIR.parent
DEFAULT_CONFIG = SCRIPT_DIR / "ftp_deploy_config.ini"
EXAMPLE_CONFIG = SCRIPT_DIR / "ftp_deploy_config.example.ini"

DIR_MAPPINGS = ("app", "bootstrap", "config", "database", "public", "resources", "routes", "storage")
ROOT_FILES = ("artisan", "composer.json", "composer.lock")


class FtpConfig:
    def __init__(self, path: Path) -> None:
        cp = configparser.ConfigParser()
        if not path.is_file():
            raise SystemExit(
                f"Missing config: {path}\nCopy {EXAMPLE_CONFIG.name} to {path.name} and set password."
            )
        cp.read(path, encoding="utf-8")
        s = cp["ftp"]
        self.host = s.get("host", "localhost").strip()
        self.port = s.getint("port", fallback=21)
        self.username = s.get("username", "").strip()
        self.password = (os.environ.get("FTP_DEPLOY_PASSWORD") or s.get("password", "")).strip()
        self.remote_base = s.get("remote_base", "").strip().strip("/")
        self.use_tls = s.getboolean("use_tls", fallback=True)
        self.insecure_tls = s.getboolean("insecure_tls", fallback=False)

        if not self.password or self.password == "YOUR_FTP_PASSWORD_HERE":
            raise SystemExit(
                "Set [ftp] password in ftp_deploy_config.ini or export FTP_DEPLOY_PASSWORD."
            )


def connect_ftp(cfg: FtpConfig) -> FTP:
    if cfg.use_tls:
        ctx = ssl.create_default_context()
        if cfg.insecure_tls:
            ctx.check_hostname = False
            ctx.verify_mode = ssl.CERT_NONE
        ftp: FTP = FTP_TLS(context=ctx)
    else:
        ftp = FTP()
    ftp.connect(cfg.host, cfg.port, timeout=90)
    ftp.login(cfg.username, cfg.password)
    if cfg.use_tls:
        ftp.prot_p()
    ftp.set_pasv(True)
    return ftp


def remote_join(base: str, *parts: str) -> str:
    segs = [base] if base else []
    for p in parts:
        p = p.strip("/").replace("\\", "/")
        if p:
            segs.extend(x for x in p.split("/") if x)
    return "/" + "/".join(segs) if segs else "/"


def ftp_cwd(ftp: FTP, path: str) -> None:
    path = path.replace("\\", "/")
    if not path or path == "/":
        try:
            ftp.cwd("/")
        except error_perm:
            pass
        return
    if not path.startswith("/"):
        path = "/" + path
    ftp.cwd(path)


def mkdir_p(ftp: FTP, abs_dir: str) -> None:
    """Create absolute remote dir /a/b/c if missing."""
    abs_dir = abs_dir.replace("\\", "/").rstrip("/")
    if not abs_dir or abs_dir == "/":
        return
    if not abs_dir.startswith("/"):
        abs_dir = "/" + abs_dir
    parts = [p for p in abs_dir.split("/") if p]
    cur = ""
    for p in parts:
        cur = f"{cur}/{p}"
        try:
            ftp.mkd(cur)
        except error_perm:
            pass


def should_skip_local(full: Path, include_vendor: bool) -> bool:
    try:
        rel = full.relative_to(REPO_ROOT)
    except ValueError:
        return True
    parts_lower = [x.lower() for x in rel.parts]
    s = str(rel).replace("/", "\\").lower()
    if "vendor" in parts_lower:
        return not include_vendor
    if "node_modules" in parts_lower:
        return True
    if "frontend" in parts_lower:
        return True
    if "tests" in parts_lower:
        return True
    if ".git" in parts_lower:
        return True
    if ".idea" in parts_lower:
        return True
    if ".vscode" in parts_lower:
        return True
    if ".env" in rel.name.lower() and rel.name.lower().startswith(".env"):
        return True
    if s.endswith(".sqlite") or ".sqlite." in s:
        return True
    if "storage\\logs\\" in s or "storage/logs/" in str(rel):
        if rel.suffix.lower() == ".log":
            return True
    if "bootstrap\\cache\\" in s or "bootstrap/cache/" in str(rel):
        if rel.suffix.lower() == ".php":
            return True
    return False


def collect_upload_files(include_vendor: bool) -> list[tuple[Path, str]]:
    out: list[tuple[Path, str]] = []
    for name in DIR_MAPPINGS:
        d = REPO_ROOT / name
        if not d.is_dir():
            continue
        for f in d.rglob("*"):
            if not f.is_file():
                continue
            if should_skip_local(f, include_vendor):
                continue
            rel = f.relative_to(REPO_ROOT)
            remote = "/" + rel.as_posix()
            out.append((f, remote))
    for name in ROOT_FILES:
        f = REPO_ROOT / name
        if f.is_file() and not should_skip_local(f, include_vendor):
            out.append((f, "/" + name))
    out.sort(key=lambda x: x[1])
    return out


def dest_path(cfg: FtpConfig, remote_rel: str) -> str:
    remote_rel = remote_rel.replace("\\", "/")
    if not remote_rel.startswith("/"):
        remote_rel = "/" + remote_rel
    if cfg.remote_base:
        return remote_join(cfg.remote_base, remote_rel.strip("/"))
    return remote_rel


def cmd_list(cfg: FtpConfig, args: argparse.Namespace) -> None:
    ftp = connect_ftp(cfg)
    try:
        base = cfg.remote_base
        start = args.path.strip("/") if args.path else ""
        cwd_path = remote_join(base, start) if start or base else "/"
        try:
            ftp_cwd(ftp, cwd_path)
        except error_perm as e:
            print(f"Cannot cwd to {cwd_path}: {e}", file=sys.stderr)
            sys.exit(1)

        print(f"Listing: {cwd_path} (FTP {cfg.host})")
        max_depth = args.max_depth if args.recursive else 0

        def walk(rel: str, depth: int) -> None:
            try:
                entries = list(ftp.mlsd(rel or "."))
            except (error_perm, AttributeError):
                try:
                    names = ftp.nlst(rel or ".")
                    entries = [(n, {}) for n in names if n not in (".", "..")]
                except error_perm as e:
                    print(f"  (skip {rel}): {e}", file=sys.stderr)
                    return
            for name, facts in sorted(entries, key=lambda x: x[0].lower()):
                if name in (".", ".."):
                    continue
                ftype = (facts or {}).get("type", "")
                prefix = "  " * (depth + 1)
                if ftype == "dir" or ftype == "cdir" or ftype == "pdir":
                    print(f"{prefix}{name}/")
                    if args.recursive and depth < max_depth:
                        sub = f"{rel}/{name}" if rel else name
                        walk(sub, depth + 1)
                else:
                    size = (facts or {}).get("size", "")
                    extra = f" ({size} B)" if size else ""
                    print(f"{prefix}{name}{extra}")

        if args.recursive:
            walk("", 0)
        else:
            try:
                for name, facts in sorted(ftp.mlsd(), key=lambda x: x[0].lower()):
                    if name in (".", ".."):
                        continue
                    t = facts.get("type", "?")
                    sz = facts.get("size", "")
                    suf = f" [{sz} B]" if sz else ""
                    if t in ("dir", "cdir"):
                        print(f"  {name}/{suf}")
                    else:
                        print(f"  {name}{suf}")
            except (error_perm, AttributeError):
                for name in sorted(ftp.nlst()):
                    if name not in (".", ".."):
                        print(f"  {name}")
    finally:
        try:
            ftp.quit()
        except Exception:
            ftp.close()


def cmd_pwd(cfg: FtpConfig) -> None:
    ftp = connect_ftp(cfg)
    try:
        if cfg.remote_base:
            ftp_cwd(ftp, "/" + cfg.remote_base)
        print(ftp.pwd())
    finally:
        try:
            ftp.quit()
        except Exception:
            ftp.close()


def _upload_file_task(cfg: FtpConfig, local: Path, remote_rel: str) -> tuple[str, str | None]:
    """One file, one FTP connection (ftplib is not thread-safe). Returns (dest, error or None)."""
    dest = dest_path(cfg, remote_rel)
    parent = str(Path(dest).parent.as_posix())
    if parent in ("", "."):
        parent = "/"
    ftp: FTP | None = None
    try:
        ftp = connect_ftp(cfg)
        mkdir_p(ftp, parent)
        with local.open("rb") as fh:
            ftp.storbinary(f"STOR {dest}", fh)
        return (dest, None)
    except Exception as e:
        return (dest, str(e))
    finally:
        if ftp is not None:
            try:
                ftp.quit()
            except Exception:
                try:
                    ftp.close()
                except Exception:
                    pass


def cmd_upload(cfg: FtpConfig, args: argparse.Namespace) -> None:
    items = collect_upload_files(include_vendor=args.vendor)
    dist = REPO_ROOT / "public" / "dist"
    if not dist.is_dir():
        print("Warning: public/dist missing — run: cd frontend && npm ci && npm run build", file=sys.stderr)
    elif not (dist / ".vite" / "manifest.json").is_file():
        print("Warning: public/dist/.vite/manifest.json missing", file=sys.stderr)

    print(f"Files to upload: {len(items)}")
    if args.dry_run:
        for _, r in items[:80]:
            print(" ", dest_path(cfg, r))
        if len(items) > 80:
            print(f"  ... and {len(items) - 80} more")
        return

    every = max(1, int(args.progress_every))
    workers = max(1, min(int(args.workers), 40))
    total = len(items)
    print(f"Parallel workers: {workers} (each opens its own FTPS connection)", flush=True)

    done_lock = threading.Lock()
    done_count = 0
    errors: list[tuple[str, str]] = []

    def on_done(fut) -> None:
        nonlocal done_count
        dest, err = fut.result()
        with done_lock:
            done_count += 1
            rem = total - done_count
            if err:
                errors.append((dest, err))
            if every == 1 or done_count == 1 or done_count == total or done_count % every == 0:
                status = "ERR" if err else "ok"
                print(
                    f"[{done_count:>5}/{total}]  {rem:>5} left  |  {status:>3}  |  {dest}",
                    flush=True,
                )

    with ThreadPoolExecutor(max_workers=workers) as ex:
        futures = [
            ex.submit(_upload_file_task, cfg, local, remote_rel) for local, remote_rel in items
        ]
        for fut in as_completed(futures):
            on_done(fut)

    if errors:
        print(f"\n{len(errors)} error(s):", file=sys.stderr)
        for dest, msg in errors[:30]:
            print(f"  {dest}\n    {msg}", file=sys.stderr)
        if len(errors) > 30:
            print(f"  ... and {len(errors) - 30} more", file=sys.stderr)
        raise SystemExit(1)

    pub = f"/{cfg.remote_base}/public" if cfg.remote_base else "public (next to app/ under FTP home)"
    print("\nDone. On server: composer install --no-dev --optimize-autoloader")
    print("Configure .env, php artisan key:generate, migrate; storage + bootstrap/cache writable.")
    print(f"Document root should point at: {pub}")


def main() -> None:
    parser = argparse.ArgumentParser(description="FTP deploy / list helper")
    parser.add_argument(
        "--config",
        type=Path,
        default=DEFAULT_CONFIG,
        help=f"INI config (default: {DEFAULT_CONFIG.name})",
    )
    sub = parser.add_subparsers(dest="command", required=True)

    p_list = sub.add_parser("list", help="List files on the server (under remote_base + --path)")
    p_list.add_argument("--path", default="", help="Subpath under remote_base (e.g. public)")
    p_list.add_argument("--recursive", "-r", action="store_true", help="Recurse into directories")
    p_list.add_argument("--max-depth", type=int, default=4, help="With --recursive, max depth")

    sub.add_parser("pwd", help="Print remote working directory after cd to remote_base")

    p_up = sub.add_parser("upload", help="Upload production Laravel tree + public/dist")
    p_up.add_argument("--dry-run", action="store_true", help="Only print remote paths")
    p_up.add_argument("--vendor", action="store_true", help="Include vendor/ (large)")
    p_up.add_argument(
        "--progress-every",
        type=int,
        default=1,
        metavar="N",
        help="Print progress every N completed files (default: 1). Completions may finish out of order.",
    )
    p_up.add_argument(
        "--workers",
        type=int,
        default=25,
        metavar="N",
        help="Parallel uploads (default: 25, max 40). Each worker uses its own FTP connection.",
    )

    args = parser.parse_args()
    cfg = FtpConfig(args.config)

    if args.command == "list":
        cmd_list(cfg, args)
    elif args.command == "pwd":
        cmd_pwd(cfg)
    elif args.command == "upload":
        cmd_upload(cfg, args)


if __name__ == "__main__":
    main()
