<?php

$pagesDir = __DIR__ . '/src/pages';
$distDir  = __DIR__ . '/dist';

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

    // Page source files — never copy these into dist as assets
    $excludedFiles = ['meta.php', 'page.html'];

    foreach (scandir($src) as $file) {

        if ($file === '.' || $file === '..') continue;
        if (in_array($file, $excludedFiles, true)) continue;

        $sourcePath = $src . '/' . $file;
        $destPath   = $dst . '/' . $file;

        if (is_dir($sourcePath)) {

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
    $meta  = require $pagePath . '/meta.php';
    $title = $meta['title'] ?? '';

    // Load static page content
    $content = file_get_contents($pagePath . '/page.html');

    ob_start();
    require __DIR__ . '/src/templates/layout.php';
    $html = ob_get_clean();

    file_put_contents($outputDir . '/index.html', $html);

    copyAssets($pagePath, $outputDir);

    echo "Built: {$relativePath}\n";
}

// Copy assets dir
copyAssets(__DIR__ . '/src/assets', $distDir . '/assets');

echo "Build complete.\n";