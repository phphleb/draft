<?php
    /**
     * @author  Foma Tuturov <fomiash@yandex.ru>
     */

    $action = true;

    if (end($argv) === '--help') {
        die (
            "\n" . "DRAFT INSTANCE: Generator of classes from drafts for the HLEB framework." .
            "\n" . "--remove (delete module)" .
            "\n" . "--add    (add/update module)" . "\n"
        );
    }

    if (end($argv) === '--remove') {
        $action = false;
    } else if (end($argv) === '--add') {
        $action = true;
    } else {
        exit(PHP_EOL . 'For details, repeat the command with the `--help` flag.' . PHP_EOL);
    }

    include __DIR__ . ($action ? "/add_drafts.php" : "/remove_drafts.php");

