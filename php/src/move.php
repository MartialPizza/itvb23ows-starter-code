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
        } elseif ($board[$from][count($board[$from]) - 1][0] != $player) {
            $_SESSION['error'] = "Tile is not owned by player";
        } elseif ($hand['Q']) {
            $_SESSION['error'] = "Queen bee is not played";
        } else {
            $tile = array_pop($board[$from]);
            if (!hasNeighBour($to, $board) || !empty(splitHive($board))) {
                $_SESSION['error'] = "Move would split hive";
            } else {
                if ($from == $to) {
                    $_SESSION['error'] = 'Tile must move';
                } elseif (isset($board[$to]) && $tile[1] != "B") {
                    $_SESSION['error']  = 'Tile not empty';
                } elseif ($tile[1] == "Q" || $tile[1] == "B") {
                    if (!slide($board, $from, $to)) {
                        $_SESSION['error'] = 'Tile must slide';
                    }
                }
                }
            }
        if (isset($_SESSION['error'])) {
            if (isset($board[$from])) {
                array_push($board[$from], $tile);
            } else {
                $board[$from] = [$tile];
            }
        } else {
            if (isset($board[$to])) {
                array_push($board[$to], $tile);
            } else {
                $board[$to] = [$tile];
            }
            insertMove();
        }
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
        return empty($all);
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
