<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include_once 'database.php';

    function undo() {
        if (isset($_SESSION['last_move'])) {
            $db = database();
            $stmt = $db->prepare('SELECT * FROM moves WHERE id = '.$_SESSION['last_move']);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_array();
            if (!empty($result[5])) {
                $_SESSION['last_move'] = $result[5];
                setState($result[6]);
            } else {
                $_SESSION['error'] = 'Board is empty';
            }
        } else {
            $_SESSION['error'] = 'Board is empty';
        }
    }

    if (!debug_backtrace()) {
        undo();
        header('Location: index.php');
    }
