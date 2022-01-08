<?php

namespace App\Controllers;
use App\Models\User;


class IndexController
{
   public function __construct($db)
   {
    $this->conn = $db->getConnect();
   }

  public function index()
   {
    //    include_once 'app/Models/UserModel.php';

       // отримання користувачів
       $users = (new User())::all($this->conn);
       include_once 'views/home.php';
   }
  
   public function login()
   {

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $userLoggined = (new User)::auth($this->conn, $email, $password);

    if(isset($userLoggined)){
    $_SESSION['auth'] = true;
    $_SESSION['id_role'] = $userLoggined['id_role'];
    $_SESSION['id'] = $userLoggined['id'];
    $_SESSION['name'] = $userLoggined['name'];
    $_SESSION['secondName'] = $userLoggined['secondName'];
    } else{
        $error = "Incorrect info!";
    }
    

    $users = (new User())::all($this->conn);
       // виклик відображення
       include_once 'views/home.php';
   }

   public function logout() {
    session_destroy();
    header('Location: ?controller=index');
    }

   

  
    
}
