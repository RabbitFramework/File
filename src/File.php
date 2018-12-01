<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 01/12/2018
 * Time: 10:40
 */

namespace Rabbit\File;

/**
 * Class File
 * @package Xirion\File
 */
class File
{

    /**
     * @param $basePath
     * @param $newPath
     * @return bool
     * @throws FileException
     */
    public static function clone(string $basePath, string $newPath) {
        if(self::exists($basePath)) {
            if(self::exists($newPath)) {
                return copy($basePath, $newPath);
            } else {
                throw new FileException("[Rabbit => File::clone()] The path \"{$newPath}\" (named \$newPath) doens't exists");
            }
        } else {
            throw new FileException("[Rabbit => File::clone()] The path \"{$basePath}\" (named \$basePath) doens't exists");
        }
    }

    /**
     * @param string $path
     * @param array|string $content
     *
     * @return bool|int
     */
    public static function putContent(string $path, $content) {
        return file_put_contents($path, $content);
    }

    /**
     * @param string $path
     * @return bool|int
     */
    public static function getCreationDate(string $path) {
        return filectime($path);
    }

    /**
     *
     */
    public static function isDirectory(string $path) {
        return is_dir($path);
    }

    /**
     * @param string $path
     * @return bool
     */
    public static function isFile(string $path) {
        return is_file($path);
    }

    /**
     * @param string $path
     * @return bool|string
     */
    public static function getContent(string $path) {
        if(self::exists($path) && self::isFile($path)) {
            return file_get_contents($path);
        }
    }

    /**
     * @param string $path
     * @return bool
     */
    public static function unlink(string $path) {
        if(self::exists($path)) {
            return unlink($path);
        }
    }

    /**
     * @param string $path
     * @return mixed
     */
    public static function getExtension(string $path) {
        return pathinfo($path, PATHINFO_EXTENSION);
    }

    /**
     * @param string $path
     * @return \Directory
     */
    public static function getParentDirectory(string $path) {
        return dir($path);
    }

    /**
     * @param string $path
     * @param string $newName
     * @return bool
     */
    public static function rename(string $path, string $newName) {
        if(self::exists($path)) {
            return rename($path, $newName);
        }
    }

    /**
     * @param string $path
     * @return bool
     */
    public static function exists(string $path) {
        return file_exists($path);
    }

}