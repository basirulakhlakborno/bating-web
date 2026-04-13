#!/usr/bin/env python3
"""
Run Laravel database seeders using XAMPP PHP (same resolution as scripts/run_tests.py).

Usage:
  python scripts/seed.py
  python scripts/seed.py -- --class=AdminSeeder
  python scripts/seed.py -- db:seed --class=AdminSeeder --force

Environment:
  PHP_EXE   Path to php.exe (overrides auto-detect)
  XAMPP_PHP Same as PHP_EXE (optional alias)
"""

from __future__ import annotations

import os
import shutil
import subprocess
import sys
from pathlib import Path


def repo_root() -> Path:
    return Path(__file__).resolve().parent.parent


def find_php() -> str:
    for key in ("PHP_EXE", "XAMPP_PHP"):
        p = os.environ.get(key, "").strip().strip('"')
        if p and Path(p).is_file():
            return p

    candidates = [
        Path("D:/xampp/php/php.exe"),
        Path("C:/xampp/php/php.exe"),
        repo_root().parent / "php" / "php.exe",
    ]
    for c in candidates:
        if c.is_file():
            return str(c)

    which = shutil.which("php")
    if which:
        return which

    print(
        "ERROR: No php.exe found. Set PHP_EXE to your XAMPP PHP, e.g.\n"
        "  set PHP_EXE=D:\\xampp\\php\\php.exe",
        file=sys.stderr,
    )
    sys.exit(127)


def main() -> int:
    root = repo_root()
    php = find_php()
    artisan = root / "artisan"
    if not artisan.is_file():
        print(f"ERROR: {artisan} not found.", file=sys.stderr)
        return 1

    args = sys.argv[1:]
    if args and args[0] == "--":
        args = args[1:]

    if not args:
        cmd = [php, str(artisan), "db:seed", "--force"]
    elif args[0] == "db:seed":
        cmd = [php, str(artisan), *args]
    else:
        cmd = [php, str(artisan), "db:seed", "--force", *args]

    print("+", " ".join(cmd), file=sys.stderr)
    r = subprocess.run(cmd, cwd=root)
    return int(r.returncode)


if __name__ == "__main__":
    raise SystemExit(main())
