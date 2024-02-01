<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/src/play.php';

class PlayTest extends TestCase {

// function play($piece, $to, $player, $board, $hand, $errorMessage)

    public function testPlayerHasTile()
    {
        $piece = "Q";
        $to = "1, 0";
        $hand = array("B" => true, "A" => true, "G" => false);
        $playerWhite = 0;
        $board = [];
        $errorMessage = null;

        play($piece, $to, $playerWhite, $board, $hand, $errorMessage);

        $this->assertEquals("Player does not have tile", $_SESSION['error']);
    }

}