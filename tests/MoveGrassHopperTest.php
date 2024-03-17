<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/src/move.php';

class MoveGrassHopperTest extends TestCase
{

//    public function testIsValidMoveGrassHopper() {
//        $from = '0, 0';
//        $to = '0, 3';
//        $board = [
//            '0, 0' => ['G', '0'],
//            '0, 1' => ['Q', '1'],
//            '0, 2' => ['Q', '0'],
//        ];
//
//        $result = isValidMoveGrassHopper($from, $to, $board);
//
//        $this->assertTrue($result);
//    }

    public function testGrassHopperTileIsNotEmpty() {
        $from = '0, 0';
        $to = '0, 1';
        $board = [
            '0, 0' => ['G', '0'],
            '0, 1' => ['A', '1'],
            '0, -1' => ['S', '0'],
        ];

        $result = isValidMoveGrassHopper($from, $to, $board);

        $this->assertFalse($result);
        $this->assertEquals('Tile is not empty', $_SESSION['error']);
    }

    public function testGrassHopperMustHaveNeighbour() {
        $from = '0, 0';
        $to = '0, 4';
        $board = [
            '0, 0' => ['G', '0'],
            '0, 1' => ['A', '1'],
            '0, -1' => ['S', '0'],
        ];

        $result = isValidMoveGrassHopper($from, $to, $board);

        $this->assertFalse($result);
        $this->assertEquals('GrassHopper must have neighbour', $_SESSION['error']);
    }

    public function testGrassHopperMustJumpOverOneTile() {
        $from = '0, 0';
        $to = '0, -1';
        $board = [
            '0, 0' => ['G', '0'],
            '0, 1' => ['A', '1'],
            '0, 2' => ['S', '0'],
        ];

        $result = isValidMoveGrassHopper($from, $to, $board);

        $this->assertFalse($result);
        $this->assertEquals('GrassHopper must jump over at least one tile', $_SESSION['error']);
    }

}