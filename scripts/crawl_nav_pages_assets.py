#!/usr/bin/env python3
"""
Fetch HTML for each route in config/nav_pages.php from babu88.gold, collect
image/static URLs from the response, then download them into public/ (same as
download_babu88_assets.py layout).
"""

from __future__ import annotations

import html as html_lib
import re
import subprocess
import sys
import tempfile
import urllib.error
import urllib.request
from pathlib import Path
from urllib.parse import urljoin, urlparse

BASE_URL = "https://babu88.gold"
USER_AGENT = (
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64) "
    "AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36"
)
TIMEOUT = 60

STATIC_HINT = re.compile(
    r"(?:https?://[^\s\"'<>)\]]+)?(/static/[^\s\"'<>)\]]+)", re.IGNORECASE
)
ATTR_SRC = re.compile(
    r"(?:src|data-src|data-lazy-src|href)=[\"']([^\"']+)[\"']", re.IGNORECASE
)
SRCSET = re.compile(r"srcset=[\"']([^\"']+)[\"']", re.IGNORECASE)
URL_IN_CSS = re.compile(r"url\(\s*([\"']?)([^)\"']+)\1\s*\)", re.IGNORECASE)


def project_root() -> Path:
    return Path(__file__).resolve().parent.parent


def load_nav_paths() -> list[str]:
    cfg = project_root() / "config" / "nav_pages.php"
    text = cfg.read_text(encoding="utf-8", errors="replace")
    keys = re.findall(r"'([^']+)'\s*=>\s*\[", text)
    return [k.strip("/") for k in keys if k]


def strip_fragment_query(path: str) -> str:
    return path.split("?", 1)[0].split("#", 1)[0]


def normalize_href(href: str, page_url: str) -> str | None:
    href = html_lib.unescape(href.strip())
    if not href or href.startswith(("data:", "javascript:", "#", "mailto:")):
        return None
    absolute = urljoin(page_url, href)
    u = urlparse(absolute)
    host = (u.netloc or "").lower()
    if host and "babu88." not in host:
        return None
    path = u.path or "/"
    path = strip_fragment_query(path)
    if not path.startswith("/"):
        path = "/" + path
    lower = path.lower()
    if "/static/" in path or path.startswith("/static"):
        return path
    if lower.endswith(
        (".png", ".jpg", ".jpeg", ".webp", ".gif", ".svg", ".ico", ".avif", ".bmp")
    ):
        return path
    return None


def extract_assets(html_text: str, page_url: str) -> set[str]:
    out: set[str] = set()
    for m in STATIC_HINT.finditer(html_text):
        p = normalize_href(m.group(1), page_url)
        if p:
            out.add(p)
    for m in ATTR_SRC.finditer(html_text):
        p = normalize_href(m.group(1), page_url)
        if p:
            out.add(p)
    for m in SRCSET.finditer(html_text):
        for part in m.group(1).split(","):
            piece = part.strip().split()[0] if part.strip() else ""
            p = normalize_href(piece, page_url)
            if p:
                out.add(p)
    for m in URL_IN_CSS.finditer(html_text):
        p = normalize_href(m.group(2), page_url)
        if p:
            out.add(p)
    return out


def fetch_page(url: str) -> str:
    req = urllib.request.Request(url, headers={"User-Agent": USER_AGENT})
    with urllib.request.urlopen(req, timeout=TIMEOUT) as resp:
        return resp.read().decode("utf-8", errors="replace")


def main() -> int:
    paths = load_nav_paths()
    if not paths:
        print("No paths found in config/nav_pages.php", file=sys.stderr)
        return 1

    root = project_root()
    downloader = root / "scripts" / "download_babu88_assets.py"
    if not downloader.is_file():
        print(f"Missing {downloader}", file=sys.stderr)
        return 1

    all_assets: set[str] = set()
    for segment in paths:
        page_url = f"{BASE_URL.rstrip('/')}/{segment}"
        print(f"PAGE {page_url}")
        try:
            body = fetch_page(page_url)
        except urllib.error.HTTPError as e:
            print(f"  HTTP {e.code}: {e.reason}", file=sys.stderr)
            continue
        except urllib.error.URLError as e:
            print(f"  {e.reason}", file=sys.stderr)
            continue
        found = extract_assets(body, page_url)
        print(f"  asset refs: {len(found)}")
        all_assets |= found

    if not all_assets:
        print("No assets discovered.")
        return 0

    lines = "\n".join(sorted(all_assets)) + "\n"
    with tempfile.NamedTemporaryFile(
        mode="w",
        suffix=".txt",
        delete=False,
        encoding="utf-8",
    ) as tmp:
        tmp.write(lines)
        tmp_path = tmp.name

    try:
        cmd = [sys.executable, str(downloader), "--file", tmp_path]
        print(f"\nDownloading {len(all_assets)} paths via download_babu88_assets.py …")
        return subprocess.call(cmd, cwd=str(root))
    finally:
        Path(tmp_path).unlink(missing_ok=True)


if __name__ == "__main__":
    raise SystemExit(main())
