<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include_once 'util.php';

    unset($_SESSION['error']);

    function move($from, $to, $player, $board, $hand) {
        if (!isValidMove($from, $to, $player, $board, $hand)) {
            return;
        }

        $tile = array_pop($board[$from]);

        $all = splitHive($board);

        if (!isValidMoveTile($all, $tile, $from, $to, $board)) {
            return;
        } elseif (!isValidMovePieces($tile, $from, $to, $board)) {
            return;
        }

        if (isset($_SESSION['error'])) {
            if (isset($board[$from])) {
                array_push($board[$from], $tile);
            } else {
                $board[$to] = [$tile];
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

    function isValidMove($from, $to, $player, $board, $hand) {
        if (!empty($board[$from])) {
            $lastTile = end($board[$from]);
            if ($lastTile[0] != $player) {
                $_SESSION['error'] = 'Tile is not owned by player';
                return false;
            }
        } elseif (!isset($board[$from])) {
            $_SESSION['error'] = 'Board position is empty';
            return false;
        } elseif ($hand['Q']) {
            $_SESSION['error'] = 'Queen bee is not played';
            return false;
        } elseif (!hasNeighBour($to, $board)) {
            $_SESSION['error'] = 'Move would split hive';
            return false;
        }
        return true;
    }

    function isValidMoveTile($all, $tile, $from, $to, $board) {
        if ($all) {
            $_SESSION['error'] = 'Move would split hive';
            return false;
        } else {
            if ($from == $to) {
                $_SESSION['error'] = 'Tile must move';
                return false;
            } elseif (isset($board[$to]) && $tile[1] != 'B') {
                $_SESSION['error'] = 'Tile is not empty';
                return false;
            } elseif ($tile[1] == 'Q' || $tile[1] == 'B') {
                if (!slide($board, $from, $to)) {
                    $_SESSION['error'] = 'Tile must slide';
                    return false;
                }
            }
        }
        return true;
    }

    function isValidMoveAnt($from, $to) {
        if (!isNeighbour($from, $to)) {
            $_SESSION['error'] = 'Ants can only move one tile per move';
            return false;
        }
        return true;
    }

    function isValidMoveSpider($from, $to, $board) {
        if (!isAlongEdgeHive($to, $board)) {
            $_SESSION['error'] = 'Spider must move along the edge of the hive';
            return false;
        } elseif (countSteps($from, $to) !== 3) {
            $_SESSION['error'] = 'Spider must move exactly three steps';
            return false;
        }
        return true;
    }

    function isAlongEdgeHive($to, $board) {
        $hiveEdges = getEdgesHive($board);

        return in_array($to, $hiveEdges);
    }

    function getEdgesHive($board) {
        $hiveEdges = [];

        if (!is_array($board)) {
            return [];
        }
        foreach ($board as $position => $tile) {
            $coords = explode(',', $position);
            $a = intval($coords[0]);
            $b = intval($coords[1]);
            if ($a === 0 || $a === 1 || $b === -1 || $b === 1) {
                $hiveEdges[] = $position;
            }
        }
        return $hiveEdges;
    }

    function countSteps($from, $to) {
        $from = explode(',', $from);
        $to= explode(',', $to);

        $a1 = intval($from[0]);
        $b1 = intval($from[1]);
        $a2 = intval($to[0]);
        $b2 = intval($to[1]);

        return max(abs($a2 - $a1), abs($b2 - $b1));
    }

    function isValidMoveGrassHopper($from, $to, $board) {
        if (jumpOverTiles($from, $to, $board)) {
            return true;
        } else {
            return false;
        }
    }

    function jumpOverTiles($from, $to, $board) {
        $from = explode(',', $from);
        $to = explode(',', $to);

        if (isset($board[implode(',', $to)])) {
            $_SESSION['error'] = 'Tile is not empty';
            return false;
        }

        if (!hasNeighbour(implode(',', $to), $board)) {
            $_SESSION['error'] = 'Grasshopper must have neighbour';
            return false;
        }

        $jumpedOverTile = false;

        $a = intval($to[0]) - intval($from[0]);
        $b = intval($to[1]) - intval($from[1]);

        $nextPosition = [
            intval($to[0]) + $a,
            intval($to[1]) + $b
        ];

        if (isset($board[implode(',', $nextPosition)])) {
            $jumpedOverTile = true;
        }
        if (!$jumpedOverTile) {
            $_SESSION['error'] = 'Grasshopper must jump over at least one tile';
            return false;
        }

        return true;
    }

    function isValidMovePieces($tile, $from, $to, $board) {
        if ($tile[1] == 'A') {
            if (!isValidMoveAnt($from, $to)) {
                return false;
            }
        } elseif ($tile[1] == 'S') {
            if (!isValidMoveSpider($from, $to, $board)) {
                return false;
            }
        } elseif ($tile[1] == 'G') {
            if (!isValidMoveGrassHopper($from, $to, $board)) {
                return false;
            }
        }
        return true;
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
        $from = $_POST['from'] ?? null;
        $to = $_POST['to'];

        $player = $_SESSION['player'];
        $board = $_SESSION['board'];
        $hand = $_SESSION['hand'][$player];

        move($from, $to, $player, $board, $hand);
        header('Location: index.php');
    }
