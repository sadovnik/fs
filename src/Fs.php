<?php

namespace Fs;

use Fs\Exceptions\IoException;
use Fs\Exceptions\PermissionDeniedException;

class Fs
{
    /**
     * @return string
     */
    public static function read($path) : string
    {
        if (!file_exists($path)) {
            throw new IoException("File not found: $path");
        }

        if (!is_file($path)) {
            throw new IoException("$path is not a file");
        }

        if (!is_readable($path)) {
            throw new PermissionDeniedException('Permission denied');
        }

        return file_get_contents($path);
    }

    /**
     * @return bool
     */
    public static function isDir($path) : bool
    {
        if (!file_exists($path)) {
            throw new IoException("File or directory not found: $path");
        }

        if (!is_readable($path)) {
            throw new PermissionDeniedException('Permission denied');
        }

        return is_dir($path);
    }

    /**
     * @param string $path
     * @param string $content
     *
     * @return callable result
     */
    public static function write($path, $content)
    {
        if (file_exists($path) && is_file($path) && !is_writable($path)) {
            return new PermissionDeniedException("$path is not writable");
        }

        $directory = dirname($path);

        if (!is_writable($directory)) {
            return new PermissionDeniedException("$directory is not writable");
        }

        file_put_contents($path, $content);
    }
}
