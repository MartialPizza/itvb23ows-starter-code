<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/src/move.php';

class MovePiecesTest extends TestCase {

    public function testIsValidMoveAnt() {
        $from = '0, 0';
        $to = '0, 1';

        $result = isValidMoveAnt($from, $to);

        $this->assertTrue($result);
    }

    public function testIsUnvalidMoveAnt() {
        $from = '0, 0';
        $to = '0, 2';

        $result = isValidMoveAnt($from, $to);

        $this->assertFalse($result);
        $this->assertEquals('Ants can only move one tile per move', $_SESSION['error']);
    }

    public function testIsValidMoveSpider() {
        $from = '0, 0';
        $to = '0, 3';
        $board = [
            '0, 0' => ['S', '0'],
            '0, 1' => ['A', '1'],
            '0, -1' => ['B', '0'],
            '0, 2' => ['Q', '1'],
            '0, 3' => [],
        ];

        $result = isValidMoveSpider($from, $to, $board);

        $this->assertTrue($result);
        $this->assertTrue(isAlongEdgeHive($to, $board));
        $this->assertEquals(3, countSteps($from, $to));
    }

    public function testSpiderNotAlongEdgeHive() {
        $from = '0, 0';
        $to = '2, 2';
        $board = [
            '0, 0' => ['S', '0'],
            '0, 1' => ['A', '1'],
            '0, -1' => ['B', '0'],
            '0, 2' => ['Q', '1'],
        ];

        $result = isValidMoveSpider($from, $to, $board);

        $this->assertFalse($result);
        $this->assertEquals('Spider must move along the edge of the hive', $_SESSION['error']);
    }

    public function testSpiderMustMoveThreeSteps() {
        $from = '0, 0';
        $to = '0, 2';
        $board = [
            '0, 0' => ['S', '0'],
            '0, 1' => ['A', '1'],
            '0, -1' => ['B', '0'],
            '0, 2' => ['Q', '1'],
        ];

        isValidMoveSpider($from, $to, $board);

        $this->assertEquals('Spider must move exactly three steps', $_SESSION['error']);
    }

    public function testIsAlongEdgeHive() {
        $to = '0, 0';
        $board = [
            '0, 0' => ['Q', '0'],
            '0, 1' => ['B', '1'],
            '1, 0' => ['A', '0']
        ];

        $result = isAlongEdgeHive($to, $board);

        $this->assertTrue($result);
    }

    public function testIsNotAlongEdgeHive() {
        $to = '3, 0';
        $board = [
            '0, 0' => ['Q', '0'],
            '0, 1' => ['B', '1'],
            '1, 0' => ['A', '0']
        ];

        $result = isAlongEdgeHive($to, $board);

        $this->assertFalse($result);
    }

    public function testGetEdgesHive() {
        $board = [
            '0, 0' => ['Q', '0'],
            '0, 1' => ['B', '1'],
            '1, 0' => ['A', '0'],
            '3, 0' => ['A', '1'],
        ];

        $expectedResult = ['0, 0', '0, 1', '1, 0'];

        $result = getEdgesHive($board);

        $this->assertEquals($expectedResult, $result);
    }

    public function testGetNoEdgesHive() {
        $board = [];

        $result = getEdgesHive($board);

        $this->assertEquals([], $result);
    }

    public function testCountStepsSamePosition() {
        $from = '0, 0';
        $to = '0, 0';

        $result = countSteps($from, $to);

        $this->assertEquals(0, $result);
    }

    public function testCountStepsHorizontalMove() {
        $from = '0, 1';
        $to = '0, 3';

        $result = countSteps($from, $to);

        $this->assertEquals(2, $result);
    }

    public function testCountStepsVerticalMove() {
        $from = '1, 0';
        $to = '2, 0';

        $result = countSteps($from, $to);

        $this->assertEquals(1, $result);
    }

    public function testCountStepsDiagonalMove() {
        $from = '0, 0';
        $to = '1, 2';

        $result = countSteps($from, $to);

        $this->assertEquals(2, $result);
    }

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
        $this->assertEquals('Grasshopper must have neighbour', $_SESSION['error']);
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
        $this->assertEquals('Grasshopper must jump over at least one tile', $_SESSION['error']);
    }

    public function testIsValidMovePieceAnt() {
        $tile = ['0', 'A'];
        $from = '0, 0';
        $to = '0, 1';
        $board = [
            '0, 0' => ['A', '0'],
        ];

        $result = isValidMovePieces($tile, $from, $to, $board);

        $this->assertTrue($result);
    }

    public function testIsInvalidMovePieceAnt() {
        $tile = ['0', 'A'];
        $from = '0, 0';
        $to = '2, 0';
        $board = [
            '0, 0' => ['A', '0'],
        ];

        $result = isValidMovePieces($tile, $from, $to, $board);

        $this->assertFalse($result);
    }

//    public function testIsValidMovePieceSpider() {
//        $tile = ['0', 'S'];
//        $from = '1, 0';
//        $to = '4, 0';
//        $board = [
//            '1, 0' => ['S', '0'],
//            '2, 0' => ['G', '0'],
//            '3, 0' => ['B', '0'],
//        ];
//
//        $result = isValidMovePieces($tile, $from, $to, $board);
//
//        $this->assertTrue($result);
//    }

    public function testIsInvalidMovePieceSpider() {
        $tile = ['0', 'S'];
        $from = '0, 0';
        $to = '0, 2';
        $board = [];

        $result = isValidMovePieces($tile, $from, $to, $board);

        $this->assertFalse($result);
    }

//    public function testIsValidMovePieceGrassHopper() {
//        $tile = ['0', 'G'];
//        $from = '0, 0';
//        $to = '0, 2';
//        $board = [
//            '0, 0' => ['G', '0'],
//            '0, 1' => ['A', '1'],
//        ];
//
//        $result = isValidMovePieces($tile, $from, $to, $board);
//
//        $this->assertTrue($result);
//    }

    public function testIsInvalidMovePieceGrassHopper() {
        $tile = ['0', 'G'];
        $from = '0, 0';
        $to = '1, 0';
        $board = [
            '0, 0' => ['G', '0'],
            '0, 1' => ['A', '1'],
        ];

        $result = isValidMovePieces($tile, $from, $to, $board);

        $this->assertFalse($result);
    }

}
