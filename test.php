<?php
        $mysqli = new mysqli('us-cdbr-east-05.cleardb.net', 'b9475bc7d87319', 'd0256fe9', 'heroku_0d3cc06d5d6ea4e');
        $res = $mysqli->query("SELECT COLUMN_NAME AS c FROM information_schema.columns WHERE table_schema = 'heroku_0d3cc06d5d6ea4e' AND table_name = 'plh'");
        $columnas = [];
        while($coll = $res->fetch_row()){
            array_push($columnas, $coll);
        }
        $valores = [];
        foreach($columnas as $columna){
            array_push($valores, $columna[0]);
        }
        if(in_array('C1054', $valores)){
            echo '<pre>';
            var_dump($valores);
            echo '</pre>';
        } else {
            echo 0;
        }

    