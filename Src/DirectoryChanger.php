<?php
/**
 * @author  Foma Tuturov <fomiash@yandex.ru>
 */

namespace Phphleb\Draft\Src;

class DirectoryChanger
{
    const ALERT_MESSAGE = '<?php
 /*
 |-----------------------------------------------------------|
 | //////////////////  ATTENTION  ////////////////////////// |
 |-----------------------------------------------------------|
 |                                                           |
 | This file is automatically generated.                     |
 | All changes made will be lost when updating the library.  |
 |                                                           |
 |                                                           |
 |-----------------------------------------------------------|
 | ///////////////////  ��������  ////////////////////////// |
 |-----------------------------------------------------------|
 |                                                           |
 | ���� ���� ������������ �������������                      |
 | ��� ��������� ��������� ����� �������� ��� ����������.    |
 |                                                           |
 |                                                           |
 |-----------------------------------------------------------|
 */
 ?>';

    // �opies files and non-empty directories
    public static function recursiveCopy($src, $dst) {
        if (file_exists($dst)) self::recursiveRemoveDirectory($dst);
        if (is_dir($src)) {
            mkdir($dst);
            $files = scandir($src);
            foreach ($files as $file)
                if ($file != "." && $file != "..") {
                    $target = str_replace('.php-upd', '.php', $file);
                    self::recursiveCopy("$src/$file", "$dst/$target");
                }
        }
        else if (file_exists($src)) copy($src, $dst);
    }

    // Removes files and non-empty directories
    public static  function recursiveRemoveDirectory($dir) {
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file) {
                if ($file != "." && $file != "..") self::recursiveRemoveDirectory("$dir/$file");
            }
            rmdir($dir);
        }
        else if (file_exists($dir)) unlink($dir);
    }

    public static function globalDir() {
        return defined('HLEB_GLOBAL_DIRECTORY') ? HLEB_GLOBAL_DIRECTORY : dirname(__DIR__, 4);
    }

}

