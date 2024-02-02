<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/src/play.php';

class PlayTest extends TestCase {

    public function testPlayerDoesNotHaveTile() {
        $piece = 'Q';
        $to = '1, 0';
        $playerWhite = 0;
        $board = [];
        $hand = array('B' => true, 'A' => true, 'Q' => false);
        $errorMessage = null;

        play($piece, $to, $playerWhite, $board, $hand, $errorMessage);

        $this->assertEquals('Player does not have tile', $_SESSION['error']);
    }

    public function testBoardPositionNotEmpty() {
        $piece = 'A';
        $to = '1, 0';
        $playerWhite = 0;
        $board = [
            '1, 0' => ['Q', '0'],
        ];
        $hand = array("B" => true, "A" => true, "Q" => false);
        $errorMessage = null;

        play($piece, $to, $playerWhite, $board, $hand, $errorMessage);

        $this->assertEquals("Board position is not empty", $_SESSION['error']);
    }

    public function testBoardPositionHasNoNeighbour() {
        $piece = 'A';
        $to = '3, 1';
        $playerBlack = 1;
        $board = [
            '0, 1' => ['Q', '0'],
        ];
        $hand = array('B' => true, 'A' => true, 'Q' => false);
        $errorMessage = null;

        play($piece, $to, $playerBlack, $board, $hand, $errorMessage);

        $this->assertEquals('Board position has no neighbour', $_SESSION['error']);
    }

    public function testBoardPositionHasOpposingNeighbour() {
        $piece = 'A';
        $to = '0, 3';
        $playerWhite = 0;
        $board = [
            '0, 1' => ['Q', '0'],
            '0, 2' => ['A', '1'],
        ];
        $hand = array('B' => true, 'A' => true, 'Q' => false);
        $errorMessage = null;

        play($piece, $to, $playerWhite, $board, $hand, $errorMessage);

        $this->assertEquals('Board position has opposing neighbour', $_SESSION['error']);
    }

    public function testMustPlayQueenBee() {
        $piece = 'A';
        $to = '-1, 4';
        $playerBlack = 1;
        $board = [
            '0, 1' => ['Q', '0'],
            '0, 2' => ['A', '1'],
            '0, 0' => ['A', '0'],
            '0, 3' => ['S', '1'],
            '-1, 0' => ['S', '0'],
            '0, 4' => ['S', '1'],
            '-1, -1' => ['B', '0'],
        ];
        $hand = array('Q' => true, 'A' => true);
        $errorMessage = null;

        play($piece, $to, $playerBlack, $board, $hand, $errorMessage);

        $this->assertEquals('Must play queen bee', $_SESSION['error']);
    }

}
