<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/src/move.php';

class MovePiecesTest extends TestCase {

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

    public function testIsInvalidMovePieceSpider() {
        $tile = ['0', 'S'];
        $from = '0, 0';
        $to = '0, 2';
        $board = [];

        $result = isValidMovePieces($tile, $from, $to, $board);

        $this->assertFalse($result);
    }

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
