<?php
    function sanitize($arg)
    {
        $arg = trim($arg);
        $arg = filter_var($arg, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        return $arg;
    }

    function isAuth(){
        $session = session();
        $value = $session->get('auth') ?  true : false;
        return $value;
    }

    function funcFind1($con1, $con2, $tipopla, $condic){
        //1080,1081,1082,1083,1001,1002,1011,1012,1029,1032,1025,1047
        $mysqli = new mysqli('localhost', 'root', 'root', 'remuneration');
        // // $mysqli = new mysqli('us-cdbr-east-05.cleardb.net', 'b9475bc7d87319', 'd0256fe9', 'heroku_0d3cc06d5d6ea4e');

        $c1 = $mysqli->query("SELECT SUM($con1) AS '$con1' FROM plh WHERE TIPOPLA = '$tipopla' AND CONDIC = '$condic'");
        $c1 = $c1->fetch_assoc();
        $c1 = $c1[$con1];

        $res = $mysqli->query("SELECT COLUMN_NAME AS c FROM information_schema.columns WHERE table_schema = 'heroku_0d3cc06d5d6ea4e' AND table_name = 'plh'");
        $columnas = [];
        while($coll = $res->fetch_row()){
            array_push($columnas, $coll);
        }
        $valores = [];
        foreach($columnas as $columna){
            array_push($valores, $columna[0]);
        }
        if(in_array("$con2", $valores)){
            if($c2 = $mysqli->query("SELECT SUM($con2) AS '$con2' FROM plh WHERE TIPOPLA = '$tipopla' AND CONDIC = '$condic'")){
                $c2 = $c2->fetch_assoc();
            }

            if(is_array($c2)){
                $c2 = $c2[$con2];
                return $c2 + $c1;
            }
        } else {
            return $c1;
        }
        
    } 
    // echo funcFind1('C1081', 'C1181', 2, 2);

    function funcFind2($con1, $con2, $codniv){
        //1080,1081,1082,1083,1001,1002,1011,1012,1029,1032,1025,1047
        $mysqli = new mysqli('localhost', 'root', 'root', 'remuneration');
        // $mysqli = new mysqli('us-cdbr-east-05.cleardb.net', 'b9475bc7d87319', 'd0256fe9', 'heroku_0d3cc06d5d6ea4e');

        $c1 = $mysqli->query("SELECT SUM($con1) AS '$con1' FROM plh WHERE CODNIV = '$codniv'");
        $c1 = $c1->fetch_assoc();
        $c1 = $c1[$con1];

        $res = $mysqli->query("SELECT COLUMN_NAME AS c FROM information_schema.columns WHERE table_schema = 'heroku_0d3cc06d5d6ea4e' AND table_name = 'plh'");
        $columnas = [];
        while($coll = $res->fetch_row()){
            array_push($columnas, $coll);
        }
        $valores = [];
        foreach($columnas as $columna){
            array_push($valores, $columna[0]);
        }
        if(in_array("$con2", $valores)){
            if($c2 = $mysqli->query("SELECT SUM($con2) AS '$con2' FROM plh WHERE CODNIV = '$codniv'")){
                $c2 = $c2->fetch_assoc();
            }

            if(is_array($c2)){
                $c2 = $c2[$con2];
                return $c2 + $c1;
            }
        } else {
            return $c1;
        }
        
        

        
    } 
    // echo funcFind2('C1080', 'C1182', '2', '2');

    function funcFind3($con, $tipopla, $condic){
        //1080,1081,1082,1083,1001,1002,1011,1012,1029,1032,1025,1047
        $mysqli = new mysqli('localhost', 'root', 'root', 'remuneration');
        // $mysqli = new mysqli('us-cdbr-east-05.cleardb.net', 'b9475bc7d87319', 'd0256fe9', 'heroku_0d3cc06d5d6ea4e');

        $res = $mysqli->query("SELECT COLUMN_NAME AS c FROM information_schema.columns WHERE table_schema = 'heroku_0d3cc06d5d6ea4e' AND table_name = 'plh'");
        $columnas = [];
        while($coll = $res->fetch_row()){
            array_push($columnas, $coll);
        }
        $valores = [];
        foreach($columnas as $columna){
            array_push($valores, $columna[0]);
        }
        if(in_array("$con", $valores)){
            if($c = $mysqli->query("SELECT SUM($con) AS '$con' FROM plh WHERE TIPOPLA = '$tipopla' AND CONDIC = '$condic'")){
                $c = $c->fetch_assoc();
                $c = $c[$con];
                return $c;
            }
        } else {
            return 0;
        }
        
        
    } 
    // echo funcFind3('C1080', 'C1182', 2, 2);

    function funcFind4($con1, $con2){
        //1080,1081,1082,1083,1001,1002,1011,1012,1029,1032,1025,1047
        $mysqli = new mysqli('localhost', 'root', 'root', 'remuneration');
        // $mysqli = new mysqli('us-cdbr-east-05.cleardb.net', 'b9475bc7d87319', 'd0256fe9', 'heroku_0d3cc06d5d6ea4e');

        $c1 = $mysqli->query("SELECT SUM($con1) AS '$con1' FROM plh");
        $c1 = $c1->fetch_assoc();
        $c1 = $c1[$con1];
        
        $res = $mysqli->query("SELECT COLUMN_NAME AS c FROM information_schema.columns WHERE table_schema = 'heroku_0d3cc06d5d6ea4e' AND table_name = 'plh'");
        $columnas = [];
        while($coll = $res->fetch_row()){
            array_push($columnas, $coll);
        }
        $valores = [];
        foreach($columnas as $columna){
            array_push($valores, $columna[0]);
        }

        if(in_array("$con2", $valores)){
            if($c2 = $mysqli->query("SELECT SUM($con2) AS '$con2' FROM plh")){
                $c2 = $c2->fetch_assoc();
            }

            if(is_array($c2)){
                $c2 = $c2[$con2];
                return $c2 + $c1;
            }
        } else {
            return $c1;
        }
        
    } 