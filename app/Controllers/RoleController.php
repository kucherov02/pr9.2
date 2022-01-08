<?php

namespace App\Controllers;

class RoleController {
    private $conn;
    
    public function __construct($db){
        $this->conn = $db->getConnect();
    }


    public function index(){
        include_once 'app/Models/RoleModel.php';
        $roles = (new Role())::allRoles($this->conn);

        include_once 'views/roles.php';
    }

    public function addForm(){
        include_once 'views/addRole.php';
    }

    public function add(){
        include_once 'views/addRole.php';
        include_once 'app/Models/RoleModel.php';

        $roleId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $roleTitle = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        if (trim($roleId) !== "" && trim($roleTitle) !== "") {
            $role = new Role($roleId, $roleTitle);
            $role->addRole($this->conn);
        }

        header('Location: ?controller=roles');
    }

    public function delete(){
        include_once 'app/Models/RoleModel.php';  

        $roleId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (trim($roleId) !== "" && is_numeric($roleId)) {
            (new Role())::deleteRole($this->conn, $roleId);
        }

        header('Location: ?controller=roles');
    }

    public function show() {
        include_once 'app/Models/RoleModel.php';  

        $roleId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (trim($roleId) !== "") {
            $role = (new Role())::roleById($this->conn, $roleId);
        }

        include_once 'views/showRole.php';
        
    }

    public function showAll() {
        include_once 'app/Models/RoleModel.php';

        $roles = (new Role())::allRoles($this->conn);

        include_once 'views/roles.php';
    }

    public function edit() {
        
        include_once 'app/Models/RoleModel.php';

        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $data = [];
        $data[0] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data[1] = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $role = (new Role)::updateRole($this->conn, $id, $data);

        header('Location: ?controller=roles');

    }

}
?>