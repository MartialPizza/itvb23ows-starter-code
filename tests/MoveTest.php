<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/src/move.php';

class MoveTest extends TestCase {

    public function testGoodMove() {
        $from = '0, 0';
        $to = '1, 1';
        $player = 0;
        $board = [
            '0, 0' => ['Q', '0'],
            '1, 0' => ['A', '1']
        ];
        $hand = ['Q' => false];

        move($from, $to, $player, $board, $hand);

        $this->assertEquals(['Q', '0'], $board[$from]);
    }

    public function testMoveTileNotEmpty() {
        $from = '0, 0';
        $to = '0, 1';
        $player = 0;
        $board = [
            '0, 0' => ['B', '0'],
            '0, 1' => ['A', '1']
        ];
        $hand = ['Q' => true];

        move($from, $to, $player, $board, $hand);

        $this->assertEquals(['A', '1'], $board[$to]);
    }

    public function testMoveWillSplitHive() {
        $from = '0, 0';
        $to = '0, 3';
        $player = 0;
        $board = [
            '0, 0' => ['B', '0'],
            '0, 1' => ['A', '1']
        ];
        $hand = ['Q' => true];

        move($from, $to, $player, $board, $hand);

        $this->assertEquals(['B', '0'], $board[$from]);
    }

    public function testTileNotOwnedByPlayer() {
        $from = '1, 0';
        $to = '0, 1';
        $playerWhite = 0;
        $board = [
            '0, 0' => ['B', '0'],
            '1, 0' => ['A', '1']
        ];
        $hand = ['Q' => true];

        $result = isValidMove($from, $to, $playerWhite, $board, $hand);

        $this->assertFalse($result);
        $this->assertEquals('Tile is not owned by player', $_SESSION['error']);
    }

    public function testBoardPositionIsEmpty() {
        $from = '0, 0';
        $to = '0, 1';
        $playerWhite = 0;
        $board = [];
        $hand = ['Q' => true];

        $result = isValidMove($from, $to, $playerWhite, $board, $hand);

        $this->assertFalse($result);
        $this->assertEquals('Board position is empty', $_SESSION['error']);
    }

//    public function testQueenBeeIsNotPlayed() {
//        $from = '0, 0';
//        $to = '1, 1';
//        $player = 0;
//        $board = [
//            '0, 0' => ['B', '0'],
//            '1, 0' => ['A', '1'],
//        ];
//        $hand = ['Q' => true];
//        var_dump($board);
//        $result = isValidMove($from, $to, $player, $board, $hand);
//
//        $this->assertFalse($result);
//        $this->assertEquals('Queen bee is not played', $_SESSION['error']);
//    }

//    public function testHiveWouldSplit() {
//        $from = '0, 0';
//        $to = '0, 3';
//        $playerWhite = 0;
//        $board = [
//            '0, 0' => ['Q', '0'],
//            '0, 1' => ['B', '1'],
//        ];
//        $hand = ['B' => true];
//
//        $result = isValidMove($from, $to, $playerWhite, $board, $hand);
//
//        $this->assertFalse($result);
//        $this->assertEquals('Move would split hive', $_SESSION['error']);
//    }

    public function testHiveWouldSplitTile() {
        $all = ['0, 1', '1, 0'];
        $tile = ['Q', '0'];
        $from = '0, 0';
        $to = '0, 2';
        $board = [
            '0, 0' => ['B', '0'],
            '1, 0' => ['A', '1']
        ];

        $result = isValidMoveTile($all, $tile, $from, $to, $board);

        $this->assertFalse($result);
        $this->assertEquals('Move would split hive', $_SESSION['error']);
    }

    public function testTileMustMove() {
        $all = [];
        $tile = ['Q', '0'];
        $from = '0,0';
        $to = '0,0';
        $board = [
            '0, 0' => ['Q', '0'],
            '1, 0' => ['A', '1']
        ];

        $result = isValidMoveTile($all, $tile, $from, $to, $board);

        $this->assertFalse($result);
        $this->assertEquals('Tile must move', $_SESSION['error']);
    }

    public function testTileNotEmpty() {
        $all = [];
        $tile = ['Q', '0'];
        $from = '0, 0';
        $to = '1, 0';
        $board = [
            '0, 0' => ['Q', '0'],
            '1, 0' => ['A', '1']
        ];

        $result = isValidMoveTile($all, $tile, $from, $to, $board);

        $this->assertFalse($result);
        $this->assertEquals('Tile is not empty', $_SESSION['error']);
    }

}
