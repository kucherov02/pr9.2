<?php

namespace App\Controllers;
use App\Models\User;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

class UsersController
{
   private $conn;
   public function __construct($db)
   {
       $this->conn = $db->getConnect();
   }

   public function index()
   {
    

       // отримання користувачів
       $users = (new User())::all($this->conn);

       include_once 'views/users.php';
   }

   public function addForm(){
       include_once 'views/addUser.php';
   }

   public function add()
   {
       
       // блок з валідацією
       $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
       $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $id_role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

       $target_dir = 'public/uploads/';
       $target_file = $target_dir . basename($_FILES["photo"]["name"]);
       $path_to_img = '';

       if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
          $path_to_img = $target_dir . basename($_FILES["photo"]["name"]);
        }

       if (trim($name) !== "" && trim($email) !== "" && trim($gender) !== "" && trim($password) !== "" && trim($id_role) ) {
           // додати користувача
           $user = new User($name, $email, $gender,$password, $path_to_img, $id_role);
           $user->add($this->conn);
       }
       header('Location: ?controller=users');
   }

   public function delete(){
    

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (trim($id) !== "" && is_numeric($id)) {
        (new User())::delete($this->conn, $id);
    }

    header('Location: ?controller=users');
}

public function show(){
  

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (trim($id) !== "" && is_numeric($id)) {
  $user = (new User())::byId($this->conn, $id);
}
include_once 'views/showUser.php';
}


    public function edit(){
       // блок з валідацією
       $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
       $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $id_role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       
         $target_dir = 'public/uploads/';
         $target_file = $target_dir . basename($_FILES["photo"]["name"]);
         $path_to_img = '';

       if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
          $path_to_img = $target_dir . basename($_FILES["photo"]["name"]);
        }
    
       
       

       if (trim($id) !== "" && is_numeric($id) && trim($name) !== "" && trim($email) !== "" && trim($gender) !== "" && trim($id_role)) {
           // додати користувача
           $user = new User();
           $user->edit($this->conn, $id,$name,$email,$gender,$path_to_img, $id_role);
       }

       header('Location: ?controller=users');
    }

    public function contacts() {
      include_once 'views/contacts.php';
    }
 
    

   public function sendmail(){

    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    try{
        $mail = new PHPMailer(); 
        $mail->IsSMTP();
        $mail->SMTPAuth = true; 
        $mail->SMTPSecure= 'ssl';
        $mail->CharSet = 'UTF-8'; 
        $mail->Host = $_ENV['SMTP_SERVER']; 
        $mail->Port = $_ENV['SMTP_PORT'];
        $mail->isHTML(true);
        $mail->Username = $_ENV['SMTP_USERNAME']; 
        $mail->Password = $_ENV['SMTP_PASSWORD']; 
        $mail->Subject = $subject; 
        $mail->Body = "
        <h3>Author: $author</h3>
        <p>$text</p>
        "; 
        $mail->AddAddress($_ENV['SMTP_USERNAME']);
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
   }
}
