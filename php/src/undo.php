<?php
    session_start();

    include_once 'database.php';

    function undo() {
        $db = database();
        $stmt = $db->prepare('SELECT * FROM moves WHERE id = '.$_SESSION['last_move']);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_array();
        $_SESSION['last_move'] = $result[5];
        setState($result[6]);
    }

    undo();
    header('Location: index.php');

