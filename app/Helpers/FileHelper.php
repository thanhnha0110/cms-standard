<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileHelper
{
    const PATH = 'uploads';


    /**
     * Get name
     *
     * @param \Illuminate\Http\UploadedFile  $file
     * @return string|null
     */
    public function getName($file): ?string
    { 
        if (!is_file($file)) {
            return null;
        }

        return time() . '_' . $this->getAlt($file) . '.' . $file->extension();
    }


    /**
     * Get alt
     *
     * @param \Illuminate\Http\UploadedFile  $file
     * @return string|null
     */
    public function getAlt($file): ?string
    {
        $name = $file->getClientOriginalName();
        return is_file($file) ? Str::slug(pathinfo($name, PATHINFO_FILENAME)) : null;
    }


    /**
     * Get type size
     *
     * @param \Illuminate\Http\UploadedFile  $file
     * @return string|null
     */
    public function getMineType($file): ?string
    {
        return is_file($file) ? $file->getMimeType() : null;
    }


    /**
     * Get file size
     *
     * @param \Illuminate\Http\UploadedFile  $file
     * @return int
     */
    public function getSize($file)
    {
        return is_file($file) ? $file->getSize() : 0;
    }


    /**
     * Upload single file
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return array
     */
    public function uploadSingle($file): array
    {
        $pathFile = $this->upload($file);
        return [
            'name' => $this->getName($file),
            'alt' => $this->getAlt($file),
            'mine_type' => $this->getMineType($file),
            'size' => $this->getSize($file),
            'url' => $this->getUrl($pathFile),
        ];
    }

    /**
     * Upload file
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $disk
     * @return string|null
     */
    public function upload($file, $disk = 'public'): ?string
    {
        $fileName = $this->getName($file);
        $path = Storage::disk($disk)->putFileAs(self::PATH, $file, $fileName, $disk === 'public' ? 'public' : 's3');
        return $path;
    }

    /**
     * Get file URL
     *
     * @param string|null $path
     * @param string $disk
     * @return string|null
     */
    public function getUrl(?string $path, $disk = 'public'): ?string
    {
        if ($path) {
            $path = trim($path, '/');
            return Storage::disk($disk)->url($path);
        }
        return $path;
    }

    /**
     * Get base URL of storage
     *
     * @param string $disk
     * @return string
     */
    public function getBaseUrl($disk = 'public'): string
    {
        return trim(Storage::disk($disk)->url(null), '/');
    }

    /**
     * Delete file from S3 or public
     *
     * @param string|array $path
     * @return bool|null
     */
    public function delete($path): ?bool
    {
        if ($path) {
            $awsUrl = env('AWS_URL');
            
            if (is_array($path)) {
                foreach ($path as $singlePath) {
                    $this->delete($singlePath);
                }
                return true;
            }

            $path = trim($path, '/');
            if (Str::startsWith($path, $awsUrl)) {
                $path = str_replace($awsUrl, '', $path);
                return Storage::disk('s3')->delete($path);
            }

            // default delete from public
            return Storage::disk('public')->delete($path);
        }
        
        return false;
    }


    /**
     * @param int $bytes Number of bytes (eg. 25907)
     * @param int $precision [optional] Number of digits after the decimal point (eg. 1)
     * @return string Value converted with unit (eg. 25.3KB)
     */
    function formatBytes($bytes, $precision = 2)
    {
        $unit = ["B", "KB", "MB", "GB"];
        $exp = floor(log($bytes, 1024)) | 0;
        return round($bytes / (pow(1024, $exp)), $precision) . ' ' . $unit[$exp];
    }

}