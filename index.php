<?php

/**
 * Shim when Apache document root is the project folder (not public/).
 * Visit /css/... etc. via rewrite below; / loads this file (DirectoryIndex).
 */
require __DIR__.'/public/index.php';
