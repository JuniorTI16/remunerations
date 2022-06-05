<?php
    if ($_SERVER['METHOD_REQUEST'] == 'GET') {
        header("Location: https://remunerationsapp.herokuapp.com/");
    }

    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    function funcFind1($con1, $con2, $tipopla, $condic){
        //1080,1081,1082,1083,1001,1002,1011,1012,1029,1032,1025,1047
        // $mysqli = new mysqli('localhost', 'root', 'root', 'remuneration');
        $mysqli = new mysqli('us-cdbr-east-05.cleardb.net', 'b9475bc7d87319', 'd0256fe9', 'heroku_0d3cc06d5d6ea4e');

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
        // $mysqli = new mysqli('localhost', 'root', 'root', 'remuneration');
        $mysqli = new mysqli('us-cdbr-east-05.cleardb.net', 'b9475bc7d87319', 'd0256fe9', 'heroku_0d3cc06d5d6ea4e');

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
        // $mysqli = new mysqli('localhost', 'root', 'root', 'remuneration');
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
        // $mysqli = new mysqli('localhost', 'root', 'root', 'remuneration');
        $mysqli = new mysqli('us-cdbr-east-05.cleardb.net', 'b9475bc7d87319', 'd0256fe9', 'heroku_0d3cc06d5d6ea4e');

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

    $year = $_POST['anio'];
    $month = $_POST['mes'];

    $fieldAA = funcFind3('C1054', '2', '2');
        
    $fieldZ = funcFind3('C1056', '2', '2');
    $fieldY = funcFind1('C1025', 'C1125', '2', '1') + funcFind1('C1025', 'C1125', '4', '1');
    $fieldX = funcFind1('C1029', 'C1128', '2', '1') + funcFind1('C1029', 'C1128', '4', '1');
    $fieldT = funcFind1('C1011', 'C1111', '1', '1') + funcFind1('C1011', 'C1111', '3', '1');
    $fieldU = funcFind1('C1012', 'C1112', '1', '1') + funcFind1('C1012', 'C1112', '3', '1');
    $fieldV = funcFind1('C1029', 'C1128', '1', '1') + funcFind1('C1029', 'C1128', '3', '1');
    $fieldW = funcFind1('C1032', 'C1132', '1', '1') + funcFind1('C1032', 'C1132', '3', '1');
    
    $fieldS = funcFind4('C1047', 'C1147');
    
    $fieldR = funcFind1('C1002', 'C1102', '4', '1');
    $fieldQ = funcFind1('C1001', 'C1101', '4', '1');
    $fieldO = funcFind1('C1001', 'C1101', '2', '1');
    
    $fieldP = funcFind1('C1002', 'C1102', '2', '1');
    $fieldN = funcFind1('C1002', 'C1102', '3', '1');
    $fieldM = funcFind1('C1001', 'C1101', '3', '1');
    $fieldL = funcFind1('C1002', 'C1102', '1', '1');
    $fieldK = funcFind1('C1001', 'C1101', '1', '1');
    $fieldJ = funcFind2('C1083', 'C1183', 'C3');
    $fieldI = funcFind2('C1080', 'C1082', 'C3');
    $fieldH = funcFind1('C1083', 'C1183', '4', '2');
    $fieldG = funcFind1('C1082', 'C1182', '4', '2');
    $fieldF = funcFind1('C1081', 'C1181', '4', '2');
    $fieldE = funcFind1('C1080', 'C1180', '4', '2');
    
    $fieldD = funcFind1('C1083', 'C1183', '2', '2') + funcFind3('C1010', '2', '2') - funcFind2('C1083', 'C1183', 'C3');
    $fieldC = funcFind1('C1082', 'C1182', '2', '2');
    $fieldB = funcFind1('C1081', 'C1181', '2', '2');
    $fieldA = funcFind1('C1080', 'C1180', '2', '2') - funcFind2('C1082', 'C96666', 'C3') - funcFind2('C1080', 'C1182', 'C3');
    
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $arrayData = [
        ['MINISTERIO DE SALUD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
        ['HOSPITAL NACIONAL DOCENTE MADRE NIÑO SAN BARTOLOME', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
        [NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
        ["RESUMEN DE PLANILLA DE PAGO DE REMUNERACIONES - PERSONAL ACTIVO $month $year", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
        [NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
        ['UNIDAD EJECUTORA : 033 HOSPITAL NACIONAL DOCENTE MADRE NIÑO SAN BARTOLOME', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
        [NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
        ['CONCEPTOS REMUNERATIVOS', 'NOMB. ADMINIST. 21.11.12', 'CONT. ADMINIST. 21.11.13','PERSONAL DE CONFIANZA (REG.LAB.PUB.) 21.11.19', 'PROF. DE LA SALUD 21.13.11', 'CONT. PROF DE LA SALUD 21.13.12', '"NOMB. NO PROF. ASIST. 21.13.21', 'CONT. NO  PROF. ASIST. 21.13.22', 'GUARDIAS HOSPITAL 21.13.31', 'ENTREGA ECONOMICA PROFESIONALES 21.13.33', 'ENTREGA ECONOMICA NO PROFES. 21.13.34', 'BONIFICACION ESCOLARIDAD O AGUINALDO (JULIO - DICIEMBRE) 21.19.13', 'TOTAL'],
        ['MONTO UNICO CONSOL. PENS. DS-42', $fieldA, $fieldE, $fieldI, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '=SUMA(E9:O9)'],
        ['MONTO UNICO CONSOL. NO PENS. DS-42', $fieldB, $fieldF, $fieldJ, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '=SUMA(E10:O10)'],
        ['BEN. EXTRAOR. TRANSITORIO. PENS. DS-42', $fieldC, $fieldG, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '=SUMA(E11:O11)'],
        ['BEN. EXTRAOR. TRANSITORIO. NO PENS. DS-42', $fieldD, $fieldH, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '=SUMA(E12:O12)'],
        ['BONIFICACIONES', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '=SUMA(E13:O13)'],
        ['NIVELACION IPSS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '=SUMA(E14:O14)'],
        ['ASIGNACION (2 Y 3 SUELDOS)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '=SUMA(E15:O15)'],
        ['BONIF. EXTRA x TRANS. (DU.072-09)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '=SUMA(E16:O16)'],
        ['VALORIZ. PRINCIPAL 65% D. LEG. 1153', NULL, NULL, NULL, $fieldK, $fieldM, $fieldO, $fieldQ, NULL, NULL, NULL, NULL, '=SUMA(E17:O17)'],
        ['VALORIZ. PRINCIPAL 35% D. LEG. 1153', NULL, NULL, NULL, $fieldL, $fieldN, $fieldP, $fieldR, NULL, NULL, NULL, NULL, '=SUMA(E18:O18)'],
        ['ASIGNACION TRANSITORIA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '=SUMA(E19:O19)'],
        ['REINT. VALORIZ. PRINCIPAL 65% D. LEG. 1153', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '=SUMA(E20:O20)'],
        ['REINT. VALORIZ. PRINCIPAL 35% D. LEG. 1153', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '=SUMA(E21:O21)'],
        ['V.A. RES. JEFE DPTO. 65% DS. 260-1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $fieldT, NULL, NULL, '=SUMA(E22:O22)'],
        ['V.A. RES. JEFE DPTO. 35% DS. 260-1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $fieldU, NULL, NULL, '=SUMA(E23:O23)'],
        ['V.P. ATENC. EN SERV. CRITICOS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $fieldV, $fieldX, NULL, '=SUMA(E24:O24)'],
        ['V.P. AT. ESP. HOSP/INS. N. II N-III', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $fieldW, NULL, NULL, '=SUMA(E25:O25)'],
        ['BONIF. SOPORTE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $fieldY, NULL, '=SUMA(E26:O26)'],
        ['GUARDIAS HOSPITALARIAS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, $fieldS, NULL, NULL, NULL, '=SUMA(E27:O27)'],
        ['BONIFICACION ESCOLARIDAD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $fieldZ, '=SUMA(E28:O28)'],
        ['AGUINALDOS FIESTAS PATRIAS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $fieldAA, '=SUMA(E29:O29)'],
        ['COMPENS. TIEMPO SERVICIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '=SUMA(E30:O30)'],
        ['TOTAL', '=SUMA(E9:E30)', '=SUMA(F9:F30)', '=SUMA(G9:G30)', '=SUMA(H9:H30)', '=SUMA(I9:I30)', '=SUMA(J9:J30)', '=SUMA(K9:K30)', '=SUMA(L9:L30)', '=SUMA(M9:M30)', '=SUMA(N9:N30)', '=SUMA(O9:O30)', '=SUMA(P9:P30)'],
    ];

    $sheet->fromArray(
            $arrayData,
            NULL,
            'D1'
        );
    
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '00000000'],
            ],
        ],
    ];

    $sheet->getStyle('D8:P31')->applyFromArray($styleArray);
    $writer = new Xlsx($spreadsheet);
    $filename = "Resumen$month$year.xlsx";
    $writer->save("/app/writable/$filename");
    
    echo base_url() . "/writable/$filename";