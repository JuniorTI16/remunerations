<?php 
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DocumentsM;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DocumentsC extends BaseController{

    public function index(){
        helper('Datos_helper');
        $auth = isAuth();
        if($auth){
            $session = session();
            $data['header'] = view('layout/header', ['title' => 'Documentos', 'name' => $session->get('name'), 'photo' => $session->get('photo')]);
            $data['footer'] = view('layout/footer', ['script' => base_url() . '/public/assets/js/documents.js']);
            return view('documents', $data); 
        } else {
            return redirect()->to(base_url() . '/');
        }
    }

    public function add(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
            return redirect()->to(base_url() . '/documents');
        }
        //Se cargan los helpers para añadir validaciones
        // helper(['url', 'form']);
        $validation = \Config\Services::validation();
        //Añadir reglas de validación para los campos del frontend
        $validation->setRules([
            'nExp' => 'required|min_length[3]|max_length[100]',
            'docSubject' => 'required|min_length[3]|max_length[255]',
            'docReason' => 'required|min_length[3]|max_length[255]'
        ],[
            'nExp' => [
                'required' => 'El número de expediente es requerido.',
                'min_length' => 'El número de expediente debe tener más de 3 caracteres.',
                'max_length' => 'El número de expediente no debe tener más de 100 caracteres.'
            ],
            'docSubject' => [
                'required' => 'El asunto es requerido.',
                'min_length' => 'El asunto debe tener más de 3 caracteres.',
                'max_length' => 'El asunto no debe tener más de 255 caracteres.'
            ],
            'docReason' => [
                'required' => 'La razón es requerida.',
                'min_length' => 'La razón debe tener más de 3 caracteres.',
                'max_length' => 'La razón no debe tener más de 255 caracteres.'
            ],
            'docObservation' => [
                'max_length' => 'La observación no debe tener más de 150 caracteres.'
            ]
        ]);
        
        if(!$validation->withRequest($this->request)->run()){
            //Si ocurre un error en la validación
            $errors = $validation->getErrors();
            $data['errors'] = $errors;
            echo json_encode($data);
        } else {
            helper('Datos_helper');
            $nExp = sanitize($this->request->getVar('nExp'));
            $docSubject = sanitize($this->request->getVar('docSubject'));
            $docReason = sanitize($this->request->getVar('docReason'));
            $docObservation = sanitize($this->request->getVar('docObservation')) ?? '';
            $docFile = $this->request->getFile('docFile') ?? '';
            $docDate = date('Y-m-d');
            $fileName = '';
            $session = session();
            $idUser = $session->get('id');
            if ($docFile != '') {
                $fileName = $docFile->getRandomName();
                //Se subirá a la siguiente ruta E:\Xampp\htdocs\Udemy\CursoCodeIgniter4\public\uploads
                $docFile->move(ROOTPATH . 'public/uploads', $fileName);
            }
            $dataInsert = ['docDate' => $docDate, 'nExp' => $nExp, 'subject' => $docSubject, 'reason' => $docReason, 'observation' => $docObservation, 'idUser' => $idUser, 'file' => $fileName];
            $docModel = new DocumentsM();
            $docModel->insert($dataInsert);
            echo json_encode(1);
        }
    }

    public function list(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
            return redirect()->to(base_url() . '/documents');
        }
        $docModel = new DocumentsM();
        // Para solo seleccionar algunos campos de la tabla
        //$data = $docModel->select(['docDate', 'nExp', 'subject', 'reason', 'observation', 'idUser', 'file'])->orderBy('id', 'ASC')->findAll();
        $data = $docModel->orderBy('id', 'ASC')->findAll();
        
        $db = \Config\Database::connect();
        $builder = $db->table("documents as d");
        $builder->select('CONCAT_WS("-", u.photo, u.name) as user, d.id, d.docDate, d.nExp, d.subject, d.reason, d.observation, d.idUser, d.file');
        $builder->join('users as u', 'd.idUser = u.id', 'inner');
        $data = $builder->get()->getResult();

        echo json_encode(["data"=>$data]);
        return;
    }

    public function resume(){
        helper('Datos_helper');
        $auth = isAuth();
        if($auth){
            $session = session();
            $data['header'] = view('layout/header', ['title' => 'Resumen', 'name' => $session->get('name'), 'photo' => $session->get('photo')]);
            $data['footer'] = view('layout/footer', ['script' => base_url() . '/public/assets/js/resume.js']);
            return view('resume', $data); 
        } else {
            return redirect()->to(base_url() . '/');
        }
    }

    public function create_resume(){
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
            return redirect()->to(base_url() . '/resume');
        }
        $validation = \Config\Services::validation();
        //Añadir reglas de validación para los campos del frontend
        $validation->setRules([
            'year' => 'required|min_length[4]|max_length[4]',
            'month' => 'required|min_length[4]|max_length[20]'
        ],[
            'year' => [
                'required' => 'El año es un campo requerido.',
                'min_length' => 'El año debe tener 4 caracteres.',
                'max_length' => 'El año debe tener 4 caracteres.'
            ],
            'month' => [
                'required' => 'El mes es un campo requerido.',
                'min_length' => 'El mes debe tener como mínimo 4 caracteres.',
                'max_length' => 'El mes debe tener como máximo 20 caracteres.'
            ]
        ]);
        
        if(!$validation->withRequest($this->request)->run()){
            //Si ocurre un error en la validación
            $errors = $validation->getErrors();
            $data['errors'] = $errors;
            echo json_encode($data);
        } else {
            $fileplh = $_FILES['fileplh'] ?? '';
            if($fileplh == ''){
                $data['errors'] = ['El archivo es un campo requerido.'];
                echo json_encode($data);
                return;
            }
            
            if(!strpos($fileplh['name'], 'xlsx') || !strpos($fileplh['name'], 'xls')){
                $data['errors'] = ['El archivo debe ser en formato xls o xlsx.'];
                return;
            }

            helper('Datos_helper');
            $year = sanitize($this->request->getVar('year'));
            $month = sanitize($this->request->getVar('month'));
            $nombreArchivo = $fileplh['tmp_name'];
            /*
            $doc = IOFactory::load($nombreArchivo);
            $totalHojas = $doc->getSheetCount();
            $hojaActual = $doc->getSheet(0);
            $numFilas = $hojaActual->getHighestDataRow();
            $letra = $hojaActual->getHighestColumn();
            $numLetra = Coordinate::columnIndexFromString($letra);
            $header = '';
            $matriz = [];
            for ($indiceFila = 1; $indiceFila <= $numFilas; $indiceFila++) {
                $fila = '';
                for ($indiceColumna = 1; $indiceColumna <= $numLetra; $indiceColumna++) { 
                    $datoCelda = $hojaActual->getCellByColumnAndRow($indiceColumna, $indiceFila);
                    if($indiceColumna <= $numLetra && $indiceFila == 1) {
                        $header .= $datoCelda . ',';
                    }
                    if($indiceFila != 1){
                        $fila .= $datoCelda . ',';
                        if($indiceColumna == $numLetra){
                            array_push($matriz,$fila);
                        }
                    }
                }
            }
            $header = rtrim($header, ',');
            $header = explode(',', $header);
            $table = 'create table plh (';
            $c = 0;
            foreach($header as $head){
                if ($c < 34) {
                    $table .= $head . ' varchar(255),';
                } else {
                    $table .= $head . ' decimal(8,2),';
                }
                $c++;
            }
            $table = rtrim( $table, ',');
            $table .= ')Engine=INNODB;'; 
            $db = db_connect();
            $db->query('DROP TABLE IF EXISTS plh');
            $db->query($table);

            $limit = $numLetra - 1;
            $insert = 'insert into plh values (';
            foreach ($matriz as $mat) {
                $mat = rtrim($mat, ',');
                $mat = explode(',', $mat);
                $a = 0;
                foreach ($mat as $m) {
                    if ($a < 34) {
                        $insert .= '"' . $m . '",';
                    } else if ($a == $limit) {
                        $insert .= $m . '),(';
                    } else {
                        $insert .= $m . ',';
                    }
                    $a++;
                }
            }
            $insert = rtrim($insert, ',(');
            $insert .= ";";
            $db->query($insert);*/
            echo json_encode(['mes' => $month, 'anio' => $year]);
        }
    }

    public function make(){

        helper('Datos_helper');
        $year = sanitize($this->request->getVar('anio'));
        $month = sanitize($this->request->getVar('mes'));

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
        $writer->save("/public/summaries/$filename");
        
        echo base_url() . 'public/summaries/' . "$filename";
    }

    public function update(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
            return redirect()->to(base_url() . '/documents');
        }
        $validation = \Config\Services::validation();
        //Añadir reglas de validación para los campos del frontend
        $validation->setRules([
            'id' => 'required',
            'nExp' => 'required|min_length[3]|max_length[100]',
            'docSubject' => 'required|min_length[3]|max_length[255]',
            'docReason' => 'required|min_length[3]|max_length[255]'
        ],[
            'id' => [
                'required' => 'No se encontró el registro solicitado.'
            ],
            'nExp' => [
                'required' => 'El número de expediente es requerido.',
                'min_length' => 'El número de expediente debe tener más de 3 caracteres.',
                'max_length' => 'El número de expediente no debe tener más de 100 caracteres.'
            ],
            'docSubject' => [
                'required' => 'El asunto es requerido.',
                'min_length' => 'El asunto debe tener más de 3 caracteres.',
                'max_length' => 'El asunto no debe tener más de 255 caracteres.'
            ],
            'docReason' => [
                'required' => 'La razón es requerida.',
                'min_length' => 'La razón debe tener más de 3 caracteres.',
                'max_length' => 'La razón no debe tener más de 255 caracteres.'
            ],
            'docObservation' => [
                'max_length' => 'La observación no debe tener más de 150 caracteres.'
            ]
        ]);
        
        if(!$validation->withRequest($this->request)->run()){
            //Si ocurre un error en la validación
            $errors = $validation->getErrors();
            $data['errors'] = $errors;
            echo json_encode($data);
        } else {
            helper('Datos_helper');
            $id = sanitize($this->request->getVar('id'));
            $nExp = sanitize($this->request->getVar('nExp'));
            $docSubject = sanitize($this->request->getVar('docSubject'));
            $docReason = sanitize($this->request->getVar('docReason'));
            $docObservation = sanitize($this->request->getVar('docObservation')) ?? '';
            $docFile = $this->request->getFile('docFile') ?? '';
            $session = session();
            $idUser = $session->get('id');

            $docModel = new DocumentsM();
            $dataUpdate = ['nExp' => $nExp, 'subject' => $docSubject, 'reason' => $docReason, 'observation' => $docObservation, 'idUser' => $idUser];

            $docModel->update($id, $dataUpdate);

            if ($docFile != '') {
                $previousDoc = $docModel->where('id', $id)->first();
                $route = (ROOTPATH . 'public/uploads/' . $previousDoc->file);
                unlink($route);
                $fileName = $docFile->getRandomName();
                $docFile->move(ROOTPATH . 'public/uploads', $fileName);
                $dataUpdate = ['file' => $fileName];
                $docModel->update($id, $dataUpdate);
            }
            echo json_encode(1);
        }
    }
}