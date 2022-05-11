<?php 
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersM;

class UsersC extends BaseController{
    
    public function index(){
        helper('Datos_helper');
        $auth = isAuth();
        if($auth){
            $session = session();
            $data['header'] = view('layout/header', ['title' => 'Usuarios', 'name' => $session->get('name'), 'photo' => $session->get('photo')]);
            $data['footer'] = view('layout/footer', ['script' => base_url() . '/public/assets/js/users.js']);
            return view('users', $data); 
        } else {
            return redirect()->to(base_url() . '/');
        }
    }

    public function add(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
            return redirect()->to(base_url() . '/users');
        }
        //Se cargan los helpers para añadir validaciones
        // helper(['url', 'form']);
        $validation = \Config\Services::validation();
        //Añadir reglas de validación para los campos del frontend
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[60]',
            'name' => 'required|min_length[3]|max_length[100]',
            'password' => 'required|min_length[3]|max_length[60]'
        ],[
            'username' => [
                'required' => 'El nombre de usuario es requerido.',
                'min_length' => 'El nombre de usuario debe tener más de 3 caracteres.',
                'max_length' => 'El nombre de usuario no debe tener más de 60 caracteres.'
            ],
            'name' => [
                'required' => 'El nombre es requerido.',
                'min_length' => 'El nombre debe tener más de 3 caracteres.',
                'max_length' => 'El nombre no debe tener más de 100 caracteres.'
            ],
            'password' => [
                'required' => 'La contraseña es requerida.',
                'min_length' => 'La contraseña debe tener más de 3 caracteres.',
                'max_length' => 'La contraseña no debe tener más de 60 caracteres.'
            ]
        ]);
        
        if(!$validation->withRequest($this->request)->run()){
            //Si ocurre un error en la validación
            $errors = $validation->getErrors();
            $data['errors'] = $errors;
            echo json_encode($data);
        } else {
            helper('Datos_helper');
            $username = sanitize($this->request->getVar('username'));
            $name = sanitize($this->request->getVar('name'));
            $password = sanitize($this->request->getVar('password'));
            $userPhoto = $this->request->getFile('userPhoto') ?? '';
            $photoName = 'default.jpg';

            if ($userPhoto != '') {
                $photoName = $userPhoto->getRandomName();
                //Se subirá a la siguiente ruta E:\Xampp\htdocs\Udemy\CursoCodeIgniter4\public\photos
                $userPhoto->move(ROOTPATH . 'public/photos', $photoName);
            }
            $dataInsert = ['username' => $username, 'name' => $name, 'password' => $password, 'photo' => $photoName];
            $userModel = new UsersM();
            $userModel->insert($dataInsert);
            echo json_encode(1);
        }
    }

    function list(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
            return redirect()->to(base_url() . '/users');
        }
        $userModel = new UsersM();
        $data = $userModel->orderBy('id', 'ASC')->findAll();
        
        echo json_encode(["data"=>$data]);
        return;
    }
    
    public function update(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
            return redirect()->to(base_url() . '/users');
        }
        $validation = \Config\Services::validation();
        //Añadir reglas de validación para los campos del frontend
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[60]',
            'name' => 'required|min_length[3]|max_length[100]',
            'password' => 'required|min_length[3]|max_length[60]'
        ],[
            'username' => [
                'required' => 'El nombre de usuario es requerido.',
                'min_length' => 'El nombre de usuario debe tener más de 3 caracteres.',
                'max_length' => 'El nombre de usuario no debe tener más de 60 caracteres.'
            ],
            'name' => [
                'required' => 'El nombre es requerido.',
                'min_length' => 'El nombre debe tener más de 3 caracteres.',
                'max_length' => 'El nombre no debe tener más de 100 caracteres.'
            ],
            'password' => [
                'required' => 'La contraseña es requerida.',
                'min_length' => 'La contraseña debe tener más de 3 caracteres.',
                'max_length' => 'La contraseña no debe tener más de 60 caracteres.'
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
            $username = sanitize($this->request->getVar('username'));
            $name = sanitize($this->request->getVar('name'));
            $password = sanitize($this->request->getVar('password'));
            $userPhoto = $this->request->getFile('userPhoto') ?? '';

            $dataUpdate = ['username' => $username, 'name' => $name, 'password' => $password];
            $userModel = new UsersM();
            $userModel->update($id, $dataUpdate);

            if ($userPhoto != '') {
                $previousPhoto = $userModel->where('id', $id)->first();
                if ($previousPhoto->photo != 'default.jpg') {
                    $route = (ROOTPATH . 'public/photos/' . $previousPhoto->photo);
                    unlink($route);
                }
                $photoName = $userPhoto->getRandomName();
                $userPhoto->move(ROOTPATH . 'public/photos', $photoName);
                $dataUpdate = ['photo' => $photoName];
                $userModel->update($id, $dataUpdate);
            }
            echo json_encode(1);
        }
    }
}