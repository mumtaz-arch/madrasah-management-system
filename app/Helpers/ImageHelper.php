<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ImageHelper
{
    /**
     * Optimize and resize an uploaded image
     */
    public static function optimize(string $path, int $maxWidth = 1200, int $quality = 80): string
    {
        // Skip if intervention/image not installed
        if (!class_exists(ImageManager::class)) {
            return $path;
        }

        try {
            $fullPath = storage_path('app/public/' . $path);
            
            if (!file_exists($fullPath)) {
                return $path;
            }

            $image = ImageManager::gd()->read($fullPath);
            
            // Resize if larger than max width
            if ($image->width() > $maxWidth) {
                $image->scale(width: $maxWidth);
            }

            // Save with quality optimization
            $image->save($fullPath, quality: $quality);

            return $path;
        } catch (\Exception $e) {
            report($e);
            return $path;
        }
    }

    /**
     * Create a thumbnail from an image
     */
    public static function thumbnail(string $path, int $width = 300, int $height = 300): ?string
    {
        if (!class_exists(ImageManager::class)) {
            return null;
        }

        try {
            $fullPath = storage_path('app/public/' . $path);
            
            if (!file_exists($fullPath)) {
                return null;
            }

            $pathInfo = pathinfo($path);
            $thumbnailPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];
            $thumbnailFullPath = storage_path('app/public/' . $thumbnailPath);

            $image = ImageManager::gd()->read($fullPath);
            $image->cover($width, $height);
            $image->save($thumbnailFullPath, quality: 75);

            return $thumbnailPath;
        } catch (\Exception $e) {
            report($e);
            return null;
        }
    }

    /**
     * Convert image to WebP format for better performance
     */
    public static function toWebP(string $path, int $quality = 80): ?string
    {
        if (!class_exists(ImageManager::class)) {
            return null;
        }

        try {
            $fullPath = storage_path('app/public/' . $path);
            
            if (!file_exists($fullPath)) {
                return null;
            }

            $pathInfo = pathinfo($path);
            $webpPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';
            $webpFullPath = storage_path('app/public/' . $webpPath);

            $image = ImageManager::gd()->read($fullPath);
            $image->toWebp(quality: $quality)->save($webpFullPath);

            return $webpPath;
        } catch (\Exception $e) {
            report($e);
            return null;
        }
    }

    /**
     * Get image dimensions
     */
    public static function getDimensions(string $path): ?array
    {
        $fullPath = storage_path('app/public/' . $path);
        
        if (!file_exists($fullPath)) {
            return null;
        }

        $size = getimagesize($fullPath);
        if (!$size) {
            return null;
        }

        return [
            'width' => $size[0],
            'height' => $size[1],
        ];
    }
}
