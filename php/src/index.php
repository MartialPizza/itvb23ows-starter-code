<?php
    include_once 'board.php';

    $board = $_SESSION['board'];
    $player = $_SESSION['player'];
    $hand = $_SESSION['hand'];

    $to = [];
    $to = possibleMoveTo($board, $to);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hive</title>
        <link rel="stylesheet" href="index.css">
    </head>
    <body>
        <div class="board">
            <?php board($board);?>
        </div>
        <div class="hand">
            White: <?php playerTiles($hand, '0', '0');?>
        </div>
        <div class="hand">
            Black: <?php playerTiles($hand, '1', '1');?>
        </div>
        <div class="turn">
            Turn: <?php echo ($player == 0) ? "White" : "Black"; ?>
        </div>
        <form method="post" action="play.php">
            <select name="piece">
                <?php tileOptions($hand, $player) ?>
            </select>
            <select name="to">
                <?php playOptions($to, $board) ?>
            </select>
            <input type="submit" value="Play">
        </form>
        <form method="post" action="move.php">
            <select name="from">
                <?php moveFrom($board, $player) ?>
            </select>
            <select name="to">
                <?php moveTo($to) ?>
            </select>
            <input type="submit" value="Move">
        </form>
        <form method="post" action="pass.php">
            <input type="submit" value="Pass">
        </form>
        <form method="post" action="undo.php">
            <input type="submit" value="Undo">
        </form>
        <form method="post" action="restart.php">
            <input type="submit" value="Restart">
        </form>
        <strong><?php hasError(); ?></strong>
        <ol>
            <?php showMoves(); ?>
        </ol>
    </body>
</html>
