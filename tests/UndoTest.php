<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/src/undo.php';

class UndoTest extends TestCase {

    public function testEmptyBoardUndo() {
        undo();
        $this->assertEquals($_SESSION['error'], !isset($_SESSION['last_move']));
    }

}
