<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/src/move.php';

class MoveGrassHopperTest extends TestCase {

    public function testIsUnvalidMoveFromToSameTileGrassHopper() {
        $from = '0, 0';
        $to = '0, 0';
        $board = [
            '0, 0' => ['G', '0']
        ];

        isValidMoveGrassHopper($from, $to, $board);

        $this->assertEquals('GrassHopper must move', $_SESSION['error']);
    }

    public function testIsUnvalidMoveTileIsNotEmptyGrassHopper() {
        $from = '0, 0';
        $to = '0, 1';
        $board = [
            '0, 0' => ['G', '0'],
            '0, 1' => ['A', '1'],
            '0, -1' => ['S', '0'],
        ];

        isValidMoveGrassHopper($from, $to, $board);

        $this->assertEquals('Tile is not empty', $_SESSION['error']);
    }

    public function testIsUnvalidMoveMustHaveNeighbourGrassHopper() {
        $from = '0, 0';
        $to = '0, 4';
        $board = [
            '0, 0' => ['G', '0'],
            '0, 1' => ['A', '1'],
            '0, -1' => ['S', '0'],
        ];

        isValidMoveGrassHopper($from, $to, $board);

        $this->assertEquals('GrassHopper must have neighbour', $_SESSION['error']);
    }

    public function testIsUnvalidMoveMustJumpOverOneTileGrassHopper() {
        $from = '0, 0';
        $to = '1, 1';
        $board = [
            '0, 0' => ['G', '0'],
            '0, 1' => ['A', '1'],
            '0, 2' => ['S', '0'],
        ];

        isValidMoveGrassHopper($from, $to, $board);

        $this->assertEquals('GrassHopper must jump over at least one tile', $_SESSION['error']);
    }

}