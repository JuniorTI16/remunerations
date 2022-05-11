<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        helper('Datos_helper');
        $auth = isAuth();
        if($auth){
            $session = session();
            $data['header'] = view('layout/header', ['title' => 'Inicio', 'name' => $session->get('name'), 'photo' => $session->get('photo')]);
            // $data['footer'] = view('layout/footer', ['script' => base_url() . '/public/assets/js/users.js']);
            $data['footer'] = view('layout/footer', ['script' => '']);
            $data['name'] = $session->get('name');
            return view('home', $data); 
        } else {
            return redirect()->to(base_url() . '/');
        }
    }
}
