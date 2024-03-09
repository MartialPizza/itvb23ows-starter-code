<?php
    $GLOBALS['OFFSETS'] = [[0, 1], [0, -1], [1, 0], [-1, 0], [-1, 1], [1, -1]];

    function isNeighbour($a, $b) : bool {
        $a = explode(',', $a);
        $b = explode(',', $b);
        if (($a[0] == $b[0] && abs($a[1] - $b[1]) == 1) ||
            ($a[1] == $b[1] && abs($a[0] - $b[0]) == 1) ||
            ($a[0] . $a[1] == $b[0] . $b[1])) {
            return true;
        }
        return false;
    }

    function hasNeighBour($a, $board) : bool {
        foreach (array_keys($board) as $b) {
            if (isNeighbour($a, $b)) {
                return true;
            }
        }
        return false;
    }

    function neighboursAreSameColor($player, $a, $board) : bool {
        foreach ($board as $b => $st) {
            if (!$st) {
                continue;
            }
            $c = $st[count($st) - 1][0];
            if ($c != $player && isNeighbour($a, $b)) {
                return false;
            }
        }
        return true;
    }

    function len($tile) : int {
        return $tile ? count($tile) : 0;
    }

    function slide($board, $from, $to) : bool {
        if ((!hasNeighBour($to, $board)) || (!isNeighbour($from, $to))) {
            return false;
        }
        $b = explode(',', $to);
        $common = [];
        foreach ($GLOBALS['OFFSETS'] as $pq) {
            $p = $b[0] + $pq[0];
            $q = $b[1] + $pq[1];
            if (isNeighbour($from, $p.",".$q)) {
                $common[] = $p.",".$q;
            }
        }

        if (!isset($board[$common[0]]) || !isset($board[$common[1]]) || !isset($board[$from]) || !isset($board[$to])) {
            return false;
        }
        return min(count($board[$common[0]]), count($board[$common[1]])) <= max(count($board[$from]), count($board[$to]));
    }
