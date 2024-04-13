<?php

namespace Rockschtar\WordPress\Settings\Utils;

class PathUtil
{
    public static function isPublicPath($path): bool
    {
        // Get the document root directory
        $documentRoot = $_SERVER['DOCUMENT_ROOT'];

        // Ensure the path is within the document root
        $realPath = realpath($path);
        if ($realPath && strpos($realPath, $documentRoot) === 0) {
            // Check if the file or directory exists and is readable
            return file_exists($realPath) && is_readable($realPath);
        }

        return false;
    }
}
