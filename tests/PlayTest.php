<?php

use PHPUnit\Framework\TestCase;

require_once 'php/src/play.php';
require_once 'php/src/util.php';

class PlayTest extends TestCase
{
    // Test of 'Q' in de vierde beurt wordt geplaatst
    public function testQueenInFourthTurn()
    {
        // Maak een sessie-array om de toestand van het spel na te bootsen
        $_SESSION = array(
            'player' => 0, // Speler 0 begint
            'board' => array(), // Het bord begint leeg
            'hand' => array(
                array('Q' => 1), // Speler 0 heeft alleen de koningin in zijn hand
                array('Q' => 1), // Speler 1 heeft alleen de koningin in zijn hand
            ),
            'game_id' => 1, // ID van het spel
            'last_move' => 0, // ID van de laatste zet
        );

        // Voer de play-functie uit vier keer, voor elke speler een keer
        for ($i = 0; $i < 4; $i++) {
            play();
        }

        // Controleer of de koningin in de vierde beurt is gespeeld
        $this->assertEquals(3, $_SESSION['last_move']);
        $this->assertEquals(array(3 => array(array(0, 'Q'))), $_SESSION['board']);
    }
}