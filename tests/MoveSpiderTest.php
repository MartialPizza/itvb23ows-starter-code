<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/src/move.php';

class MoveSpiderTest extends TestCase {

    public function testIsValidMoveSpider() {
        $from = '0, 0';
        $to = '0, 3';
        $board = [
            '0, 0' => ['S', '0'],
            '0, 1' => ['A', '1'],
            '0, -1' => ['B', '0'],
            '0, 2' => ['Q', '1'],
            '0, 3' => [],
        ];

        $result = isValidMoveSpider($from, $to, $board);

        $this->assertTrue($result);
    }

    public function testIsUnvalidMoveFromToSameTileSpider() {
        $from = '0, 0';
        $to = '0, 0';
        $board = [
            '0, 0' => ['S', '0'],
        ];

        isValidMoveSpider($from, $to, $board);

        $this->assertEquals('Spider must move', $_SESSION['error']);
    }

    public function testIsUnvalidMoveSpiderNotAlongEdgeHive() {
        $from = '0, 0';
        $to = '2, 2';
        $board = [
            '0, 0' => ['S', '0'],
            '0, 1' => ['A', '1'],
            '0, -1' => ['B', '0'],
            '0, 2' => ['Q', '1'],
        ];

        isValidMoveSpider($from, $to, $board);

        $this->assertEquals('Spider must move along the edge of the hive', $_SESSION['error']);
    }

    public function testIsUnvalidMoveSpiderMustMoveThreeSteps() {
        $from = '0, 0';
        $to = '0, 2';
        $board = [
            '0, 0' => ['S', '0'],
            '0, 1' => ['A', '1'],
            '0, -1' => ['B', '0'],
            '0, 2' => ['Q', '1'],
        ];

        isValidMoveSpider($from, $to, $board);

        $this->assertEquals('Spider must move exactly three steps', $_SESSION['error']);
    }

    public function testIsAlongEdgeHive() {
        $to = '1, 0';
        $board = [
            '0, 0' => ['Q', '0'],
            '0, 1' => ['B', '1'],
            '1, 0' => ['A', '0'],
        ];

        $result = isAlongEdgeHive($to, $board);

        $this->assertTrue($result);
    }

    public function testIsNotAlongEdgeHive() {
        $to = '3, 0';
        $board = [
            '0, 0' => ['Q', '0'],
            '0, 1' => ['B', '1'],
            '1, 0' => ['A', '0']
        ];

        $result = isAlongEdgeHive($to, $board);

        $this->assertFalse($result);
    }

    public function testGetEdgesHive() {
        $board = [
            '0, 0' => ['Q', '0'],
            '0, 1' => ['B', '1'],
            '1, 0' => ['A', '0'],
            '3, 0' => ['A', '1'],
        ];

        $expectedResult = ['0, 0', '0, 1', '1, 0'];

        $result = getEdgesHive($board);

        $this->assertEquals($expectedResult, $result);
    }

    public function testNoEdgesHive() {
        $board = [];

        $result = getEdgesHive($board);

        $this->assertEquals([], $result);
    }

    public function testCountStepsSamePosition() {
        $from = '0, 0';
        $to = '0, 0';

        $result = countSteps($from, $to);

        $this->assertEquals(0, $result);
    }

    public function testCountStepsHorizontalMove() {
        $from = '0, 1';
        $to = '0, 3';

        $result = countSteps($from, $to);

        $this->assertEquals(2, $result);
    }

    public function testCountStepsVerticalMove() {
        $from = '1, 0';
        $to = '2, 0';

        $result = countSteps($from, $to);

        $this->assertEquals(1, $result);
    }

    public function testCountStepsDiagonalMove() {
        $from = '0, 0';
        $to = '1, 2';

        $result = countSteps($from, $to);

        $this->assertEquals(3, $result);
    }

}