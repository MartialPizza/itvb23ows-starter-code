<?php
    session_start();

    include_once 'database.php';

    function pass() {
        $db = database();
        $query = 'insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?, "pass", null, null, ?, ?)';
        $stmt = $db->prepare($query);
        $stmt->bind_param('iis', $_SESSION['game_id'], $_SESSION['last_move'], getState());
        $stmt->execute();
        $_SESSION['last_move'] = $db->insert_id;
        $_SESSION['player'] = 1 - $_SESSION['player'];
    }

    pass();
    header('Location: index.php');
