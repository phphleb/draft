<?php

include_once  __DIR__ . "/Src/DirectoryChanger.php";
include_once __DIR__ . "/../updater/FileUploader.php";

use Phphleb\Draft\Src\DirectoryChanger;

$uploader = new \Phphleb\Updater\FileUploader(__DIR__ . DIRECTORY_SEPARATOR . "embedded_files");

$uploader->setDesign(['base']);

$uploader->setPluginNamespace(__DIR__, 'Drafts');

$uploader->setSpecialNames('drafts', 'Drafts');

$uploader->run();

$file = __DIR__ . '/services.php';
$newfile = DirectoryChanger::globalDir() . '/app/Optional/services.php';
if (!file_exists($newfile) && !copy($file, $newfile)) {
    echo 'Failed to copy file `services.php`';
}

$dir = __DIR__ . '/DraftInstances';
$newDir = DirectoryChanger::globalDir() . '/app/Optional/DraftInstances';
if(!is_dir($newDir)) {
    DirectoryChanger::recursiveCopy($dir, $newDir);
}


