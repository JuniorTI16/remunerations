<?php 
namespace App\Models;

use CodeIgniter\Model;

class UsersM extends Model{
    protected $table = 'users';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id';
    //Para que me retorne objetos en las consultas, array para arreglos
    protected $returnType = 'object';
    //Para que al campo deleted de la base de datos lo coloque en 1
    // protected $useSoftDeletes = 'true';
    //Declarar los campos de la tabla en los que se van a insertar los datos
    protected $allowedFields = ['username', 'name', 'password', 'photo'];
}