<?php
namespace config;
use Dotenv\Dotenv; //підключення інших класів

class Db
{
   private $host;
   private $user;
   private $password;
   private $dbName;

   public function __construct()
   {
       $dotEnv = Dotenv::createImmutable(__DIR__ . '/../');
       $dotEnv->load();
       $this->host = $_ENV['DB_HOST'];
       $this->password = $_ENV['DB_PASSWORD'];
       $this->user = $_ENV['DB_USER'];
       $this->dbName = $_ENV['DB_DATABASE'];
   }

   public function getConnect() {
       $conn = mysqli_connect($this->host, $this->user, $this->password, $this->dbName);
       if (!$conn) {
           echo "No connection with MySQL." . PHP_EOL;
           exit;
       }
       return $conn;
   }
}
