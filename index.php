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
            <input type="text" name="coords" placeholder='[0,0,"p"]'>
            <input type="submit">
        </form>
        <?php
            if (isset($_GET['pass']) and isset($_GET['coords']) and isset($_GET['word'])){
            $t = $data->turn;
            $p = $_GET['pass'];
            if ($p == $data->pass->$t){
                $playable = true;
                echo $_GET["coords"],$_GET["word"];
                
                $lemmad = explode("\n", file_get_contents("./lemmad2013.txt"));
                if (!in_array($_GET["word"],$lemmad) or strlen($_GET["word"])<2){
                    echo "See sõna ei ole sõna<br>";
                    $playable = false;
                }
                
                $temphand = $data->hand[$data->turn];
                $loccords = json_decode($_GET["coords"]);
                $x = $loccords[0];
                $y = $loccords[1];
                for($l=0;$l<strlen($_GET["word"]);$l++){
                    $letter = $_GET["word"][$l];
                    if ($table[$y][$x]!=$letter and in_array($letter,$temphand)){
                        for ($i=0;$i<count($temphand);$i++){
                            if ($temphand[$i]==$letter){
                                unset($temphand[$i]);
                                break;
                            }
                        }
                    } else if ($table[$y][$x]==$letter){
                        //xd
                    } else {
                        echo "Sul pole piisavalt tähti selle käimiseks: ".$letter."<br>";
                        $playable = false;
                    }
                    if ($x>14 or $y>14 or ($table[$y][$x]!=" " and $table[$y][$x]!=$letter)){
                        echo "Su sõna ei mahu ära: ".$x." ".$y."<br>";
                        $playable = false;
                    }
                    if ($loccords[2]=="p")$x++;
                    else if ($loccords[2]=="a")$y++;
                    else {
                        echo "Sisestatud koordinaadid on vigased<br>";
                        $playable = false;
                    }
                }
                if ($playable){
                    $data->hand[$data->turn] = $temphand;
                }
            } else {
                echo "Vale pass<br>";
            }
            }
        ?>
        <p id="score1">P1 score: 0</p>
        <p id="score2">P2 score: 0</p>
    </div>
</body>
</html>