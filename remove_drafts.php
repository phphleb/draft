<?php

require __DIR__ . "/../updater/FileRemover.php";

$uploader = new \Phphleb\Updater\FileRemover(__DIR__ . DIRECTORY_SEPARATOR);

$uploader->setSpecialNames('drafts', 'Drafts');

$uploader->run();
