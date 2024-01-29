<?php
    session_start();

    include_once 'util.php';

    function play() {
        $piece = $_POST['piece'];
        $to = $_POST['to'];

        $player = $_SESSION['player'];
        $board = $_SESSION['board'];
        $hand = $_SESSION['hand'][$player];

        $errorMessage = null;

        if (!$hand[$piece]) {
            $errorMessage = "Player does not have tile";
        } elseif (isset($board[$to])) {
            $errorMessage = 'Board position is not empty';
        } elseif (count($board) && !hasNeighbour($to, $board)) {
            $errorMessage = "Board position has no neighbour";
        } elseif (array_sum($hand) < 11 && !neighboursAreSameColor($player, $to, $board)) {
            $errorMessage = "Board position has opposing neighbour";
        } elseif (array_sum($hand) <= 8 && $hand['Q']) {
            if ($piece != 'Q') {
                $errorMessage = 'Must play queen bee';
            }
        }

        if (!$errorMessage) {
            $_SESSION['board'][$to] = [[$_SESSION['player'], $piece]];
            $_SESSION['hand'][$player][$piece]--;
            $_SESSION['player'] = 1 - $_SESSION['player'];
            include_once 'database.php';
            $db = database();
            $query = 'insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?, "play", ?, ?, ?, ?)';
            $stmt = $db->prepare($query);
            $state = getState();
            $stmt->bind_param('issis', $_SESSION['game_id'], $piece, $to, $_SESSION['last_move'], $state);
            $stmt->execute();
            $_SESSION['last_move'] = $db->insert_id;
        } else {
            $_SESSION['error'] = $errorMessage;
        }
    }

    play();
    header('Location: index.php');

