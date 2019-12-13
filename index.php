<?php
    $fil = file_getcontents("./gamestate");
    $data = json_decode($fil);
    $P1score = $data->Pscore[0];
    $P2score = $data->Pscore[1];
    
?>

<html>
<head>
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
    <table id="board">
    <?php
    $table = $data->table;
    for ($i=0;$i<15;$i++){
        echo "<tr>";
        for ($j=0;$j<15;$j++){
            echo "<td>".$table[i][j]."</td>";
        }
        echo "</tr>";
    }
    ?>
    </table>
    <div id="left">
        <p id="score1">P1 score: 0</p>
        <p id="score2">P2 score: 0</p>
    </div>
</body>
</html>