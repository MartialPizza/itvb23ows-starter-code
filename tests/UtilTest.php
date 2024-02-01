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
        $this->assertEquals(false, isNeighbour($pos1, $pos3));
        $this->assertEquals(false, isNeighbour($pos2, $pos4));
    }

    public function testHasNeighbour() {
        $pos1 = '1, 0';
        $pos2 = '3, 0';
        $board = [
            '0, 1' => 'value1',
            '0, 2' => 'value2',
            '0, 0' => 'value3',
            '0, -1' => 'value4',
            '1, 1' => 'value5',
        ];
        $this->assertEquals(true, hasNeighBour($pos1, $board));
        $this->assertEquals(false, hasNeighBour($pos2, $board));
    }

    // werkt nog niet goed!!
//    public function testneighboursAreSameColor() {
//        $playerWhite = 0;
//        $playerBlack = 1;
//        $pos1 = "1, 0";
//        $pos2 = "1, 2";
//        $board = [
//            "0, 1" => [0, "white"],
//            "0, 2" => [1, "black"],
//            "0, 0" => [0, "white"],
//            "0, 3" => [1, "black"],
//            "-1, 0" => [0, "white"],
//         ];
//        $this->assertEquals(false, neighboursAreSameColor($playerWhite, $pos1, $board));
//        $this->assertEquals(false, neighboursAreSameColor($playerBlack, $pos1, $board));
//        $this->assertEquals(false, neighboursAreSameColor($playerWhite, $pos2, $board));
//        $this->assertEquals(false, neighboursAreSameColor($playerBlack, $pos2, $board));
//    }

    public function testLength() {
        $input = '0';
        $this->assertEquals(0, len($input));

        $input = ['1', '2', '3'];
        $this->assertEquals(3, len($input));
    }

//    public function testSlide() {
//
//    }

}