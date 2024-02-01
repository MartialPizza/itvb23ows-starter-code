<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include_once 'database.php';

    function pass() {
        if (empty($_SESSION['board'])) {
            $_SESSION['error'] = 'Board is empty';
            return;
        }

        $db = database();
        $query = 'insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?, "pass", null, null, ?, ?)';
        $stmt = $db->prepare($query);
        $state = getState();
        $stmt->bind_param('iis', $_SESSION['game_id'], $_SESSION['last_move'], $state);
        $stmt->execute();
        $_SESSION['last_move'] = $db->insert_id;
        $_SESSION['player'] = 1 - $_SESSION['player'];
    }

    if (!debug_backtrace()) {
        pass();
        header('Location: index.php');
    }
