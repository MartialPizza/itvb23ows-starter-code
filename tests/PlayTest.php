<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/src/play.php';

class PlayTest extends TestCase {

    public function testPlayerDoesNotHaveTile()
    {
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
        $piece = "A";
        $to = "1, 0";
        $playerWhite = 0;
        $board = ["1, 0" => true];
        $hand = array("B" => true, "A" => true, "Q" => false);
        $errorMessage = null;

        play($piece, $to, $playerWhite, $board, $hand, $errorMessage);

        $this->assertEquals("Board position is not empty", $_SESSION['error']);
    }

    public function testBoardPositionHasNoNeighbour() {
        $piece = 'A';
        $to = '3, 1';
        $playerWhite = 0;
        $board = ['1, 0' => true];
        $hand = array('B' => true, 'A' => true, 'Q' => false);
        $errorMessage = null;

        play($piece, $to, $playerWhite, $board, $hand, $errorMessage);

        $this->assertEquals('Board position has no neighbour', $_SESSION['error']);
    }

}