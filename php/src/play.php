<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include_once 'util.php';

    function play($piece, $to, $player, $board, $hand, $errorMessage) {
        if (!$hand[$piece]) {
            $errorMessage = 'Player does not have tile';
        } elseif (isset($board[$to])) {
            $errorMessage = 'Board position is not empty';
        } elseif (count($board) && !hasNeighbour($to, $board)) {
            $errorMessage = 'Board position has no neighbour';
        } elseif (array_sum($hand) < 11 && !neighboursAreSameColor($player, $to, $board)) {
            $errorMessage = 'Board position has opposing neighbour';
        } elseif (array_sum($hand) <= 8 && $hand['Q']) {
            if ($piece != 'Q') {
                $errorMessage = 'Must play queen bee';
            }
        }
        if (!$errorMessage) {
            insertPlay($to, $piece, $player);
        } else {
            $_SESSION['error'] = $errorMessage;
        }
    }

    function insertPlay($to, $piece, $player) {
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
    }

    if (!debug_backtrace()) {
        $piece = $_POST['piece'] ?? null;
        $to = $_POST['to'] ?? null;

        $player = $_SESSION['player'] ?? null;
        $board = $_SESSION['board'] ?? null;
        $hand = $_SESSION['hand'][$player] ?? null;

        $errorMessage = null;

        play($piece, $to, $player, $board, $hand, $errorMessage);

        header('Location: index.php');
    }
