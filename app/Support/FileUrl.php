<?php

namespace App\Support;

class FileUrl
{
    /**
     * Convert a stored public-disk path into an absolute URL.
     *
     * Filament's FileUpload stores paths relative to the `public` disk
     * (e.g. "paket-thumbnails/abc.png"). Those paths are not usable by the
     * frontend as-is, so every resource that exposes a file must run the value
     * through here. Absolute URLs and seeded external URLs pass through
     * unchanged.
     */
    public static function from(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        // Already absolute (http, https, protocol-relative, data URI).
        if (preg_match('#^(https?:)?//#i', $path) || str_starts_with($path, "data:")) {
            return $path;
        }

        // Guard against double-prefixing paths that already include storage/.
        $relative = ltrim($path, "/");

        if (str_starts_with($relative, "storage/")) {
            return asset($relative);
        }

        return asset("storage/" . $relative);
    }
}
