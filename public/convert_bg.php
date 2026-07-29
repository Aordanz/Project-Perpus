<?php
$dir = __DIR__ . '/latarbelakang';
$files = scandir($dir);
$count = 1;

foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $path = $dir . '/' . $file;
    
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
        echo "Converting $file...\n";
        
        $image = null;
        if ($ext === 'jpg' || $ext === 'jpeg') {
            $image = @imagecreatefromjpeg($path);
        } elseif ($ext === 'png') {
            $image = @imagecreatefrompng($path);
        } elseif ($ext === 'webp') {
            $image = @imagecreatefromwebp($path);
        }
        
        if ($image) {
            $dest = $dir . '/latarbelakang' . $count . '.avif';
            // Compress as AVIF with quality 50
            imageavif($image, $dest, 50);
            imagedestroy($image);
            
            // Delete original
            unlink($path);
            echo "Saved $dest and deleted original.\n";
            
            $count++;
        } else {
            echo "Failed to load $file\n";
        }
    }
}
echo "Done. Total converted: " . ($count - 1) . "\n";
