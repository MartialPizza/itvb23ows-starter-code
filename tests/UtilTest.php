<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/src/util.php';

class PlayTest extends TestCase
{
//    public function testValidGameId() {
//        $this->assertSame(true, isset($_SESSION['game_id']));
//        $this->assertSame(true, $_SESSION['game_id'] > 0);
//    }

    public function testLen() {
        $input = '0';
        $this->assertEquals(0, len($input));
    }
}