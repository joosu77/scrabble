<?php
    $fil = file_get_contents("./gamestate.txt");
    //$fil = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
    $data = json_decode($fil);
    $P1score = $data->Pscore[0];
    $P2score = $data->Pscore[1];
    
?><!DOCTYPE html>
<html lang="et">
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <style>
    #board {
        float: left;
    }
    #left {
        float: right;
    }
    </style>
    <script>
    
    </script>
</head>
<body>
    <h1>SCRABBLE</h1>
    <table id="board"><?php
    $table = $data->table;
    for ($i=0;$i<15;$i++){
        echo "<tr>";
        for ($j=0;$j<15;$j++){
            echo "<td>".$table[$i][$j]."</td>";
        }
        echo "</tr>";
    }
    ?></table>
    <div id="left">
        <?php
            echo "<p>".$data->turn." kord on käia</p>";
        ?>
        <form name="xd" action="" method="get">
            <input type="text" name="pass" placeholder="pass">
            <input type="text" name="word" placeholder="sõna">
            <input type="text" name="coords" placeholder="(x,y)">
            <input type="submit">
        </form>
        <?php
            if (isset($_GET['pass']) and isset($_GET['coords']) and isset($_GET['word'])){
            $t = $data->turn;
            $p = $_GET['pass'];
            if ($p == $data->pass->$t){
                echo $_GET["coords"],$_GET["word"];
                $temphand = $data->hand[$data->turn];
                foreach($_GET["word"] as $letter){
                    if (in_array($letter,$temphand)){
                        for ($i=0;$i<count($temphand);$i++){
                            if ($temphand[$i]==$letter){
                                unset($temphand[$i]);
                                break;
                            }
                        }
                    } else {
                        echo "Sul pole piisavalt tähti selle käimiseks: ".$letter."\n";
                    }
                }
            }
            }
        ?>
        <p id="score1">P1 score: 0</p>
        <p id="score2">P2 score: 0</p>
    </div>
</body>
</html>