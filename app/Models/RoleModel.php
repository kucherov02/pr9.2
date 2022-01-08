<?php
namespace App\Models;

class Role {
    
    private $roleId;
    private $roleTitle;

    public function __construct($roleId = '', $roleTitle = '') {
        $this->roleId = $roleId;
        $this->roleTitle = $roleTitle;
    }

    public function addRole($conn) {
        $sql = "INSERT INTO roles (id, title) VALUES ('$this->roleId', '$this->roleTitle')";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            return true;
        }
    }

    public static function allRoles($conn) {
        $sql = "SELECT * FROM roles";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $arr = [];
            while ( $db_field = $result->fetch_assoc() ) {
                $arr[] = $db_field;
            }
            return $arr;
        } else {
            return [];
        }
    }

    public static function roleById($conn, $roleId) {

        $sql = "SELECT * FROM roles WHERE id=$roleId";
        $result = $conn->query($sql);   
        
        if ($result->num_rows > 0) {
            $roleData = [];

            while($db_field = $result->fetch_assoc()) {
                $roleData = $db_field;
            }
    
            return $roleData;
        }
        
    }

    public static function updateRole($conn, $id, $data) {
    
        $sql = "UPDATE roles SET id='$data[0]', title='$data[1]' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
        
    }

    public static function deleteRole($conn, $id) {
        $sql = "DELETE FROM roles WHERE id=$id";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            return true;
        }
    }

}
?>