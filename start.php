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
        $action = (bool)selectAction();
    }
    if ($action) {
        include __DIR__ . "/add_drafts.php";
    } else {
        include __DIR__ . "/remove_drafts.php";
    }

    function selectAction() {
        $actionType = readline('What action should be performed? Enter symbol to add(A) or remove(R) files>');
        if ($actionType === "A") {
            return true;
        }
        if ($actionType === "R") {
            return false;
        }
       return selectAction();
    }


