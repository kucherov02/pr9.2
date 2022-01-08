<?php
namespace route;
use App\Controllers\IndexController;
use App\Controllers\RoleController;
use App\Controllers\UsersController;

class Route{
    function loadPage($db, $controllerName, $actionName = 'index'){
         include_once 'app/Controllers/IndexController.php';
         include_once 'app/Controllers/UsersController.php';
         include_once 'app/Controllers/RoleController.php';

         switch ($controllerName) {
            case 'users':
                $controller = new UsersController($db);
                break;
            
            case 'roles':
                $controller = new RoleController($db);    
                break;

            default:
                $controller = new IndexController($db);
            
                
         }

         $controller->$actionName();
    }
}
?>