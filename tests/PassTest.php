<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/src/pass.php';

class PassTest extends TestCase {

    public function testEmptyBoard() {
        $board = [];

        $this->assertEmpty($board);
    }

    public function testNotEmptyBoard() {
        $board = [
            '0, 0' => ['Q', '0'],
            '1, 0' => ['A', '1']
        ];

        $this->assertNotEmpty($board);
    }

}
