<?php
    session_start();

    function restart() {
        $_SESSION['board'] = [];
        $_SESSION['hand'] = [0 => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3],
            1 => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3]];
        $_SESSION['player'] = 0;

        include_once 'database.php';
        $db = database();
        $db->prepare('INSERT INTO games VALUES ()')->execute();
        $_SESSION['game_id'] = $db->insert_id;
    }

    restart();
    header('Location: index.php');

