<?php 
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DocumentsM;

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

    function list(){
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