<?php 
namespace App\Controllers;

use App\Models\UsersM;
use App\Controllers\BaseController;

class AuthC extends BaseController{

    public function index(){
        helper('Datos_helper');
        $auth = isAuth();
        if(!$auth){
            return view('login');
        } else {
            return redirect()->to(base_url() . '/home');
        }
    }

    public function auth(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
            return redirect()->to(base_url() . '/');
        }
        $validation = \Config\Services::validation();
        //Añadir reglas de validación para los campos del frontend
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[60]',
            'password' => 'required|min_length[3]|max_length[60]'
        ],[
            'username' => [
                'required' => 'El ususario es requerido.',
                'min_length' => 'El usuario debe tener más de 3 caracteres.',
                'max_length' => 'El usuario no debe tener más de 60 caracteres.'
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
            $password = sanitize($this->request->getVar('password'));

            $userModel = new UsersM();
            $user = $userModel->where('username', $username)->first();

            if(!$user || $user->password != $password){
                echo json_encode(0);
                return;
            }
            $session = session();
            $session->set('auth', true);
            $session->set('id', $user->id);
            $session->set('username', $user->username);
            $session->set('name', $user->name);
            $session->set('photo', $user->photo);
            echo json_encode($user->name);
            // $session->remove('some_name');
        }
    }

    public function logout(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
            return redirect()->to(base_url() . '/');
        }
        $session = session();
        $session->destroy();
    }
}