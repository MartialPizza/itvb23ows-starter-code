<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include_once 'util.php';

    if (!isset($_SESSION['board'])) {
        header('Location: restart.php');
        exit(0);
    }

    $board = $_SESSION['board'];
    $player = $_SESSION['player'];
    $hand = $_SESSION['hand'];

    $to = [];
    $to = possibleMoveTo($board, $to);

    function possibleMoveTo($board, $to) {
        foreach ($GLOBALS['OFFSETS'] as $pq) {
            foreach (array_keys($board) as $pos) {
                $pq2 = explode(',', $pos);
                $to[] = ($pq[0] + $pq2[0]).','.($pq[1] + $pq2[1]);
            }
        }
        $to = array_unique($to);
        if (!count($to)) {
            $to[] = '0,0';
        }
        return $to;
    }

    function board($board) {
        $min_p = 1000;
        $min_q = 1000;
        foreach ($board as $pos => $tile) {
            $pq = explode(',', $pos);
            if ($pq[0] < $min_p) {
                $min_p = $pq[0];
            }
            if ($pq[1] < $min_q) {
                $min_q = $pq[1];
            }
        }
        foreach (array_filter($board) as $pos => $tile) {
            $pq = explode(',', $pos);
            $h = count($tile);
            echo '<div class="tile player';
            echo $tile[$h-1][0];
            if ($h > 1) {
                echo ' stacked';
            }
            echo '" style="left: ';
            echo ($pq[0] - $min_p) * 4 + ($pq[1] - $min_q) * 2;
            echo 'em; top: ';
            echo ($pq[1] - $min_q) * 4;
            echo "em;\">($pq[0],$pq[1])<span>";
            echo $tile[$h-1][1];
            echo '</span></div>';
        }
    }

    function playerTiles($hand, $index, $player) {
        foreach ($hand[$index] as $tile => $tileOptions) {
            for ($i = 0; $i < $tileOptions; $i++) {
                echo '<div class="tile player'.$player.'"><span>'.$tile."</span></div> ";
            }
        }
    }

    function tileOptions($hand, $player) {
        foreach ($hand[$player] as $tile => $tileOptions) {
            if ($tileOptions > 0) {
                echo "<option value=\"$tile\">$tile</option>";
            }
        }
    }

    function playOptions($to, $board) {
        foreach ($to as $pos) {
            if (!isset($board[$pos])) {
                echo "<option value=\"$pos\">$pos</option>";
            }
        }
    }

    function moveFrom($board, $player) {
        foreach ($board as $pos => $tiles) {
            if (!empty($tiles) && $tiles[count($tiles) - 1][0] == $player) {
                echo "<option value=\"$pos\">$pos</option>";
            }
        }
    }

    function moveTo($to) {
        foreach ($to as $pos) {
            echo "<option value=\"$pos\">$pos</option>";
        }
    }

    function hasError() {
        if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];
        }
        unset($_SESSION['error']);
    }

    function showMoves() {
        include_once 'database.php';
        $db = database();
        $stmt = $db->prepare('SELECT * FROM moves WHERE game_id = '.$_SESSION['game_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_array()) {
            echo '<li>'.$row[2].' '.$row[3].' '.$row[4].'</li>';
        }
    }

