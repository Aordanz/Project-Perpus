<?php
$dir = __DIR__ . '/latarbelakang';
$files = scandir($dir);

// Re-index to be perfectly sequential
$count = 1;
foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    
    // If it's logousu, just move it back and rename to webp
    if (strpos($file, 'latarbelakang15') !== false) {
        // Move it back as logousu.avif or we can just copy logousu.png to public/logousu.webp
        // The original was in public/logousu.webp
    } else {
        $oldPath = $dir . '/' . $file;
        $newPath = $dir . '/temp_' . $count . '.avif';
        rename($oldPath, $newPath);
        $count++;
    }
}

// Rename temp back to final
$tempFiles = scandir($dir);
foreach ($tempFiles as $file) {
    if (strpos($file, 'temp_') === 0) {
        $finalName = str_replace('temp_', 'latarbelakang', $file);
        rename($dir . '/' . $file, $dir . '/' . $finalName);
    }
}

// recreate logousu.webp
$image = @imagecreatefrompng(__DIR__ . '/logousu.png');
if ($image) {
    imagewebp($image, __DIR__ . '/logousu.webp', 80);
    imagedestroy($image);
}

echo "Renaming done. Recreated logousu.webp.";
