<?php

namespace App\Services;

use Exception;

class ImageService {
    /**
     * Upload, validate, convert to WebP, and save image securely.
     */
    public static function processAndSaveImage(array $file, int $storeId, string $subfolder = 'products'): string {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("File upload failed with error code: " . $file['error']);
        }

        $maxBytes = config('app.upload_max_size', 2097152); // 2MB
        if ($file['size'] > $maxBytes) {
            throw new Exception("File size exceeds maximum allowed limit of 2MB.");
        }

        // Verify Real MIME Type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowedMimes = config('security.allowed_image_mimes', ['image/jpeg', 'image/png', 'image/webp']);
        if (!in_array($mimeType, $allowedMimes)) {
            throw new Exception("Invalid image format. Allowed formats: JPEG, PNG, WebP.");
        }

        // Create target directory if missing
        $targetDir = __DIR__ . '/../../public/uploads/' . $subfolder . '/store_' . $storeId;
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Generate Safe Unique WebP Filename
        $filename = 'img_' . time() . '_' . bin2hex(random_bytes(4)) . '.webp';
        $destinationPath = $targetDir . '/' . $filename;
        $relativePublicUrl = '/uploads/' . $subfolder . '/store_' . $storeId . '/' . $filename;

        // Convert / Resize to WebP using GD library
        self::convertToWebP($file['tmp_name'], $destinationPath, $mimeType);

        return $relativePublicUrl;
    }

    /**
     * Convert source image file to compressed WebP.
     */
    private static function convertToWebP(string $sourcePath, string $destinationPath, string $mimeType): void {
        $image = null;
        switch ($mimeType) {
            case 'image/jpeg':
                $image = @imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = @imagecreatefrompng($sourcePath);
                if ($image) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
                break;
            case 'image/webp':
                $image = @imagecreatefromwebp($sourcePath);
                break;
        }

        if (!$image) {
            // Fallback move file if GD processing fails
            move_uploaded_file($sourcePath, $destinationPath);
            return;
        }

        // Save WebP with 80% compression quality
        imagewebp($image, $destinationPath, 80);
        imagedestroy($image);
    }
}
