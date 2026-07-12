<?php

// Dindent — disabled for now while testing basic functionality.
require __DIR__ . '/src/assets/dindent/Exception/DindentException.php';
require __DIR__ . '/src/assets/dindent/Exception/InvalidArgumentException.php';
require __DIR__ . '/src/assets/dindent/Exception/RuntimeException.php';
require __DIR__ . '/src/assets/dindent/Indenter.php';
use Gajus\Dindent\Indenter;

$pagesDir = __DIR__ . '/src/pages';
$distDir  = __DIR__ . '/dist';

// Function - Format/indent final HTML output using dindent
function formatHtml($html) {
    $indenter = new Indenter(['indentation_character' => '    ']);
    return $indenter->indent($html);
}

// Function - Delete directory (clean build)
function deleteDir($dir) {
    if (!is_dir($dir)) return;

    foreach (scandir($dir) as $file) {
        if ($file !== '.' && $file !== '..') {
            $path = $dir . '/' . $file;
            is_dir($path) ? deleteDir($path) : unlink($path);
        }
    }

    rmdir($dir);
}

// Function - Recursive asset copy (excluding PHP)
function copyAssets($src, $dst) {

    if (!is_dir($dst)) {
        mkdir($dst, 0777, true);
    }

    $excludedFiles = ['meta.php', 'page.html'];

    foreach (scandir($src) as $file) {

        if ($file === '.' || $file === '..') continue;
        if (in_array($file, $excludedFiles, true)) continue;

        $sourcePath = $src . '/' . $file;
        $destPath   = $dst . '/' . $file;

        if (is_dir($sourcePath)) {

            // Skip subdirectories that are themselves pages
            if (file_exists($sourcePath . '/meta.php')) {
                continue;
            }

            if (!is_dir($destPath)) {
                mkdir($destPath, 0777, true);
            }

            copyAssets($sourcePath, $destPath);

        } else {

            if (pathinfo($file, PATHINFO_EXTENSION) !== 'php') {
                copy($sourcePath, $destPath);
            }
        }
    }
}

// Function - Discover pages recursively
function discoverPages($dir) {
    $pages = [];

    foreach (scandir($dir) as $file) {
        if ($file === '.' || $file === '..') continue;

        $fullPath = $dir . '/' . $file;

        if (is_dir($fullPath)) {
            if (file_exists($fullPath . '/meta.php')) {
                $pages[] = $fullPath;
            }
            $pages = array_merge($pages, discoverPages($fullPath));
        }
    }

    return $pages;
}

// Fresh build
deleteDir($distDir);
mkdir($distDir, 0777, true);

$pages = discoverPages($pagesDir);

// Build pages
foreach ($pages as $pagePath) {

    $relativePath = str_replace($pagesDir, '', $pagePath);

    if ($relativePath === '/home') {
        $outputDir = $distDir;
    } else {
        $outputDir = $distDir . $relativePath;
    }

    if (!is_dir($outputDir)) {
        mkdir($outputDir, 0777, true);
    }

    // Load metadata
    $meta   = require $pagePath . '/meta.php';

    // Add meta variables here:
    $layout = $meta['layout'] ?? 'default';
    $title  = $meta['title'] ?? '';

    $layoutFile = __DIR__ . '/src/layouts/' . $layout . '.php';

    if (!file_exists($layoutFile)) {
        throw new Exception("Layout '{$layout}' not found for page: {$pagePath}");
    }

    // Load static page content
    $content = file_get_contents($pagePath . '/page.html');

    ob_start();
    require $layoutFile;
    $html = ob_get_clean();

    file_put_contents($outputDir . '/index.html', formatHtml($html));
    //file_put_contents($outputDir . '/index.html', $html);

    copyAssets($pagePath, $outputDir);

    echo "Built: {$relativePath}\n";
}

// Copy assets dir
copyAssets(__DIR__ . '/src/assets', $distDir . '/assets');

// Pasthrough static content from /src/static to /dist/static
$staticDir = __DIR__ . '/src/static';

if (is_dir($staticDir)) {
    foreach (scandir($staticDir) as $entry) {
        if ($entry === '.' || $entry === '..') continue;

        $srcPath = $staticDir . '/' . $entry;

        if (is_dir($srcPath)) {
            copyAssets($srcPath, $distDir . '/' . $entry);
            echo "Copied static: /{$entry}\n";
        }
    }
}

echo "Build complete.\n";