<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/src/move.php';

class MoveAntTest extends TestCase {

    public function testIsValidMoveAnt() {
        $from = '0, 0';
        $to = '0, 2';
        $board = [
            '0, 0' => ['A', '0'],
            '0, 1' => ['Q', '1'],
        ];

        $result = isValidMoveAnt($from, $to, $board);

        $this->assertTrue($result);
    }

    public function testIsUnvalidMoveFromToSameTileAnt() {
        $from = '0, 0';
        $to = '0, 0';
        $board = [
            '0, 0' => ['A', '0']
        ];

        isValidMoveAnt($from, $to, $board);

        $this->assertEquals('Ant must move', $_SESSION['error']);
    }

    public function testIsUnvalidMoveTileNotEmptyAnt() {
        $from = '0, 0';
        $to = '0, 1';
        $board = [
            '0, 0' => ['A', '0'],
            '0, 1' => ['Q', '1'],
        ];

        isValidMoveAnt($from, $to, $board);

        $this->assertEquals('Board position is not empty', $_SESSION['error']);
    }

}
