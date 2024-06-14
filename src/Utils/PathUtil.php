<?php

namespace Rockschtar\WordPress\Settings\Utils;

class PathUtil
{
    public static function isPublicPath($path): bool
    {
        $documentRoot = $_SERVER['DOCUMENT_ROOT'];

        $realPath = realpath($path);
        if ($realPath && str_starts_with($realPath, $documentRoot)) {
            return file_exists($realPath) && is_readable($realPath);
        }

        return false;
    }
}
