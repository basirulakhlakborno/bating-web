#!/usr/bin/env python3
"""
Download static assets from babu88.gold into local public/ (same path layout).

Usage:
  python scripts/download_babu88_assets.py /static/image/country/INR.svg
  python scripts/download_babu88_assets.py /static/svg/foo.svg /static/image/bar.png
  python scripts/download_babu88_assets.py --file paths.txt

paths.txt: one path per line (# comments and blank lines ignored).

Base URL: https://babu88.gold
Output root: <project>/public (use --mirror-root to also write <project>/static/... for XAMPP docroot).
"""

from __future__ import annotations

import argparse
import sys
import urllib.error
import urllib.request
from pathlib import Path

BASE_URL = "https://babu88.gold"
DEFAULT_TIMEOUT = 60
USER_AGENT = "Mozilla/5.0 (compatible; AssetMirror/1.0)"


def project_root() -> Path:
    return Path(__file__).resolve().parent.parent


def public_root() -> Path:
    return project_root() / "public"


def normalize_path(p: str) -> str:
    p = p.strip().replace("\\", "/")
    if not p.startswith("/"):
        p = "/" + p
    return p


def load_paths_from_file(path: Path) -> list[str]:
    lines = path.read_text(encoding="utf-8", errors="replace").splitlines()
    out: list[str] = []
    for line in lines:
        line = line.strip()
        if not line or line.startswith("#"):
            continue
        out.append(normalize_path(line))
    return out


def main() -> int:
    parser = argparse.ArgumentParser(
        description="Download paths from babu88.gold into public/"
    )
    parser.add_argument(
        "paths",
        nargs="*",
        help="Asset paths starting with /static/... or /favicon.ico etc.",
    )
    parser.add_argument(
        "--file",
        "-f",
        type=Path,
        help="Text file with one path per line.",
    )
    parser.add_argument(
        "--base",
        default=BASE_URL,
        help=f"Origin to download from (default: {BASE_URL})",
    )
    parser.add_argument(
        "--out",
        type=Path,
        default=None,
        help="Output root folder (default: <project>/public)",
    )
    parser.add_argument(
        "--timeout",
        type=int,
        default=DEFAULT_TIMEOUT,
        help=f"Request timeout in seconds (default: {DEFAULT_TIMEOUT})",
    )
    parser.add_argument(
        "--mirror-root",
        action="store_true",
        help="Also save under <project>/static/... (Apache often looks here when docroot is project folder).",
    )
    args = parser.parse_args()

    base = args.base.rstrip("/")
    dest_root = args.out.resolve() if args.out else public_root()

    paths: list[str] = [normalize_path(p) for p in args.paths]
    if args.file:
        if not args.file.is_file():
            print(f"Not a file: {args.file}", file=sys.stderr)
            return 1
        paths.extend(load_paths_from_file(args.file))

    if not paths:
        parser.print_help()
        print("\nExample:\n  python scripts/download_babu88_assets.py /static/image/country/INR.svg", file=sys.stderr)
        return 1

    ok = 0
    fail = 0
    for p in paths:
        url = base + p
        dest = dest_root / p.lstrip("/")
        dest.parent.mkdir(parents=True, exist_ok=True)
        req = urllib.request.Request(url, headers={"User-Agent": USER_AGENT})
        try:
            with urllib.request.urlopen(req, timeout=args.timeout) as resp:
                body = resp.read()
        except urllib.error.HTTPError as e:
            print(f"FAIL {p} -> HTTP {e.code} ({url})", file=sys.stderr)
            fail += 1
            continue
        except urllib.error.URLError as e:
            print(f"FAIL {p} -> {e.reason} ({url})", file=sys.stderr)
            fail += 1
            continue

        dest.write_bytes(body)
        print(f"OK {p} -> {dest} ({len(body)} bytes)")
        if args.mirror_root:
            root_dest = project_root() / p.lstrip("/")
            root_dest.parent.mkdir(parents=True, exist_ok=True)
            root_dest.write_bytes(body)
            print(f"   mirror -> {root_dest}")
        ok += 1

    print(f"\nDone: {ok} saved, {fail} failed -> {dest_root}")
    return 0 if fail == 0 else 2


if __name__ == "__main__":
    raise SystemExit(main())
