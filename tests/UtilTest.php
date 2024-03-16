<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/src/util.php';

class UtilTest extends TestCase {

    public function testIsNeighbour() {
        $pos1 = '0, 0';
        $pos2 = '0, 1';
        $pos3 = '3, 0';
        $pos4 = '2, 0';
        $this->assertEquals(true, isNeighbour($pos1, $pos2));
        $this->assertEquals(true, isNeighbour($pos3, $pos4));
    }

    public function testIsNotNeighbour() {
        $pos1 = '0, 0';
        $pos2 = '0, 1';
        $pos3 = '3, 0';
        $pos4 = '2, 0';
        $this->assertEquals(false, isNeighbour($pos1, $pos3));
        $this->assertEquals(false, isNeighbour($pos2, $pos4));
    }

    public function testHasNeighbour() {
        $pos1 = '1, 0';
        $board = [
            '0, 1' => ['Q', '0'],
            '0, 2' => ['A', '1'],
            '0, 0' => ['A', '0'],
            '0, -1' => ['S', '1'],
            '1, 1' => ['S', '0'],
        ];
        $this->assertEquals(true, hasNeighBour($pos1, $board));
    }

    public function testHasNoNeighbour() {
        $pos2 = '3, 0';
        $board = [
            '0, 1' => ['Q', '0'],
            '0, 2' => ['A', '1'],
            '0, 0' => ['A', '0'],
            '0, -1' => ['S', '1'],
            '1, 1' => ['S', '0'],
        ];
        $this->assertEquals(false, hasNeighBour($pos2, $board));
    }

    public function testNeighboursAreSameColor() {
        $playerWhite = 0;
        $playerBlack = 1;
        $pos1 = '1, 0';
        $pos2 = '1, 2';
        $board = [
            '0, 1' => ['Q', '0'],
            '0, 2' => ['A', '1'],
            '0, 0' => ['A', '0'],
            '0, 3' => ['S', '1'],
            '-1, 0' => ['S', '0'],
         ];
        $this->assertEquals(true, neighboursAreSameColor($playerWhite, $pos1, $board));
        $this->assertEquals(true, neighboursAreSameColor($playerBlack, $pos2, $board));
    }

    public function testNeighboursAreNotTheSameColor() {
        $playerWhite = 0;
        $playerBlack = 1;
        $pos1 = '1, 0';
        $pos2 = '1, 2';
        $board = [
            '0, 1' => ['Q', '0'],
            '0, 2' => ['A', '1'],
            '0, 0' => ['A', '0'],
            '0, 3' => ['S', '1'],
            '-1, 0' => ['S', '0'],
        ];
        $this->assertEquals(false, neighboursAreSameColor($playerBlack, $pos1, $board));
        $this->assertEquals(false, neighboursAreSameColor($playerWhite, $pos2, $board));
    }

    public function testLength() {
        $input = '0';
        $this->assertEquals(0, len($input));

        $input = ['1', '2', '3'];
        $this->assertEquals(3, len($input));
    }

//    public function testValidSlideMove() {
//        $from = '0, -1';
//        $to = '1, 0';
//        $board = [
//            '0, 0' => ['B', '0'],
//            '0, 1' => ['A', '1'],
//            '0, -1' => ['S', '0'],
//            '0, 2' => ['A', '1'],
//        ];
//
//        $result = slide($board, $from, $to);
//
//        $this->assertTrue($result);
//    }

    public function testInvalidSlideMove() {
        $from = '0, 0';
        $to = '0, 1';
        $board = [
            '0, 0' => ['B', '0'],
            '0, 1' => ['A', '1'],
            '0, -1' => ['S', '0'],
        ];

        $result = slide($board, $from, $to);

        $this->assertFalse($result);
    }

}
