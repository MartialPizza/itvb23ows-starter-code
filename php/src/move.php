<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include_once 'util.php';

    $from = $_POST['from'] ?? null;
    $to = $_POST['to'];

    $player = $_SESSION['player'];
    $board = $_SESSION['board'];
    $hand = $_SESSION['hand'][$player];

    function move($from, $to, $player, $board, $hand) {
        if (!isset($board[$from])) {
            $_SESSION['error'] = 'Board position is empty';
            return;
        }
        $lastTile = end($board[$from]);
        if ($lastTile[0] != $player) {
            $_SESSION['error'] = 'Tile is not owned by player';
            return;
        }
        if ($hand['Q']) {
            $_SESSION['error'] = 'Queen bee is not played';
            return;
        }
        $tile = array_pop($board[$from]);
        if (!hasNeighBour($to, $board) || !empty(splitHive($board))) {
            $_SESSION['error'] = 'Move would split hive';
            $board[$from][] = $tile;
            return;
        }
        if ($from == $to) {
            $_SESSION['error'] = 'Tile must move';
            $board[$from][] = $tile;
            return;
        }
        if (isset($board[$to]) && $tile[1] != 'B') {
            $_SESSION['error'] = 'Tile not empty';
            $board[$from][] = $tile;
            return;
        }
        if ($tile[1] == 'B') {
            if (!slide($board, $from, $to)) {
                $_SESSION['error'] = 'Tile must slide';
                $board[$from][] = $tile;
                return;
            }
        }
        if (isset($board[$to])) {
            array_push($board[$to], $tile);
        } else {
            $board[$to] = [$tile];
        }
        insertMove();
        $_SESSION['board'] = $board;
    }

    function splitHive($board) {
        $all = array_keys($board);
        $queue = [array_shift($all)];
        while ($queue) {
            $next = explode(',', array_shift($queue));
            foreach ($GLOBALS['OFFSETS'] as $pq) {
                list($p, $q) = $pq;
                $p += $next[0];
                $q += $next[1];
                if (in_array("$p,$q", $all)) {
                    $queue[] = "$p,$q";
                    $all = array_diff($all, ["$p,$q"]);
                }
            }
        }
        return $all;
    }

    function insertMove() {
        $_SESSION['player'] = 1 - $_SESSION['player'];
        include_once 'database.php';
        $db = database();
        $query = 'insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?, "move", ?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        $state = getState();
        $stmt->bind_param('issis', $_SESSION['game_id'], $from, $to, $_SESSION['last_move'], $state);
        $stmt->execute();
        $_SESSION['last_move'] = $db->insert_id;
    }

    if (!debug_backtrace()) {
        move($from, $to, $player, $board, $hand);
        header('Location: index.php');
    }
