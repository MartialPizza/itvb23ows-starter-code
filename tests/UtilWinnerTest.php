<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/src/util.php';

class UtilWinnerTest extends TestCase {

    public function testQueenIsSurrounded() {
        $board = [
            '0, 0' => ['Q', '0'],
            '0, 1' => ['A', '1'],
            '0, -1' => ['S', '0'],
            '-1, 0' => ['A', '1'],
            '1, 0' => ['B', '1'],
            '-1, 1' => ['B', '0'],
            '1, -1' => ['S', '0']
        ];

        $result = 'The winner is player 1';

        $this->assertEquals($result, isWinner($board));
    }

    public function testQueensAreSurrounded() {
        $board = [
            '0, 0' => ['Q', '0'],
            '0, 1' => ['Q', '1'],
            '0, -1' => ['S', '0'],
            '-1, 0' => ['A', '1'],
            '1, 0' => ['B', '1'],
            '-1, 1' => ['B', '0'],
            '1, -1' => ['S', '1'],
            '1, 1' => ['A', '0'],
            '0, 2' => ['S', '1'],
            '-1, 2' => ['B', '0'],
        ];

        $result = "It's a tie";

        $this->assertEquals($result, isWinner($board));
    }

    public function testQueenIsNotSurrounded() {
        $board = [
            '0, 0' => ['Q', '0'],
            '0, 1' => ['A', '1'],
            '0, -1' => ['S', '0'],
            '-1, 0' => ['A', '1'],
            '1, 0' => ['B', '1'],
        ];

        $this->assertEquals('', isWinner($board));
    }

    public function testPositionsInBoard() {
        $board = [
            '0, 0' => ['Q', '0'],
            '0, 1' => ['Q', '1'],
            '0, -1' => ['S', '0'],
            '-1, 0' => ['A', '1'],
            '1, 0' => ['B', '1'],
            '-1, 1' => ['B', '0'],
            '1, -1' => ['S', '1'],
            '1, 1' => ['A', '0'],
            '0, 2' => ['S', '1'],
            '-1, 2' => ['B', '0'],
        ];

        $positions = [[-1, 0], [1, 0], [0, -1], [0, 1], [-1, 1], [1, -1]];

        $this->assertTrue(arePositionsInBoard($board, $positions));
    }

    public function testPositionsNotInBoard() {
        $board = [
            '0, 0' => ['Q', '0'],
            '0, 1' => ['Q', '1'],
            '0, -1' => ['S', '0'],
        ];

        $positions = [[-1, 0], [1, 0], [0, -1], [0, 1], [-1, 1], [1, -1]];

        $this->assertFalse(arePositionsInBoard($board, $positions));
    }

    public function testGetQueens() {
        $board = [
            '0, 0' => ['Q', '0'],
            '0, 1' => ['Q', '1'],
            '0, -1' => ['S', '0'],
        ];

        $result = ['0, 0', '0, 1'];

        $this->assertEquals($result, findQueens($board));
    }

    public function testGetNoQueens() {
        $board = [
            '0, 0' => ['A', '0'],
            '0, 1' => ['B', '1'],
            '0, -1' => ['S', '0'],
        ];

        $result = [];

        $this->assertEquals($result, findQueens($board));
    }

    public function testGetAdjacentPositions() {
        $x = 0;
        $y = 0;

        $result = [[-1, 0], [1, 0], [0, -1], [0, 1], [-1, 1], [1, -1]];

        $this->assertEquals($result, getAdjacentPositions($x, $y));
    }

    public function testGetAdjacentPositionsWrong() {
        $x = 1;
        $y = 0;

        $result = [[-1, 0], [1, 0], [0, -1], [0, 1], [-1, 1], [1, -1]];

        $this->assertNotSame($result, getAdjacentPositions($x, $y));
    }

}
