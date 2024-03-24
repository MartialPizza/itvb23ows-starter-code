<?php
    $GLOBALS['OFFSETS'] = [[0, 1], [0, -1], [1, 0], [-1, 0], [-1, 1], [1, -1]];

    function isNeighbour($a, $b): bool {
        $a = explode(',', $a);
        $b = explode(',', $b);
        if (($a[0] == $b[0] && abs($a[1] - $b[1]) == 1) ||
            ($a[1] == $b[1] && abs($a[0] - $b[0]) == 1) ||
            ($a[0] . $a[1] == $b[0] . $b[1])) {
            return true;
        }
        return false;
    }

    function hasNeighBour($a, $board): bool {
        foreach (array_keys($board) as $b) {
            if (isNeighbour($a, $b)) {
                return true;
            }
        }
        return false;
    }

    function neighboursAreSameColor($player, $a, $board): bool {
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

    function len($tile): int {
        return $tile ? count($tile) : 0;
    }

    function slide($board, $from, $to): bool {
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

    function isWinner($board): string {
        $message = '';
        $messageWinner = 'The winner is player ';
        $queens = findQueens($board);

        if (!empty($queens)) {
            $queenCount = count($queens);

            if ($queenCount === 2) {
                list($x1, $y1) = explode(', ', $queens[0]);
                list($x2, $y2) = explode(', ', $queens[1]);

                $queen1 = isQueenSurrounded($x1, $y1, $board);
                $queen2 = isQueenSurrounded($x2, $y2, $board);

                if ($queen1 && $queen2) {
                    $message = "It's a tie";
                } elseif ($queen1) {
                    $winner1 = getWinner($x1, $y1, $board);
                    $message = $messageWinner . $winner1;
                } elseif ($queen2) {
                    $winner2 = getWinner($x2, $y2, $board);
                    $message = $messageWinner . $winner2;
                }
            } elseif ($queenCount === 1) {
                list($x, $y) = explode(', ', $queens[0]);

                $queen = isQueenSurrounded($x, $y, $board);

                if ($queen) {
                    $winner = getWinner($x, $y, $board);
                    $message = $messageWinner . $winner;
                }
            }
        }
        return $message;
    }

    function isQueenSurrounded($x, $y, $board): bool {
        $adjacentPositions = getAdjacentPositions($x, $y);
        return arePositionsInBoard($board, $adjacentPositions);
    }

    function getWinner($x, $y, $board): string {
        $player = $board["$x, $y"][1];
        return ($player === '0') ? '1' : '0';
    }

    function arePositionsInBoard($board, $positions): bool {
        foreach ($positions as $pos) {
            if (!isset($board["$pos[0], $pos[1]"])) {
                return false;
            }
        }
        return true;
    }

    function findQueens($board): array {
        $queens = [];
        foreach ($board as $pos => $piece) {
            if ($piece[0] === 'Q') {
                $queens[] = $pos;
            }
        }
        return $queens;
    }

    function getAdjacentPositions($x, $y): array {
        return [
            [$x - 1, $y],
            [$x + 1, $y],
            [$x, $y - 1],
            [$x, $y + 1],
            [$x - 1, $y + 1],
            [$x + 1, $y - 1]
        ];
    }
