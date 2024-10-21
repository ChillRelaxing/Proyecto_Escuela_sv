<?php

require_once '../controllers/rolController.php';

// Capturamos la opción de la URL//p
$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';
//AJAX
$consulta = isset($_GET['consulta']) ? $_GET['consulta'] : '';


// Instanciamos el controlador
$controller = new rolController();

// Switch para manejar las acciones basadas en el valor de $action
switch ($action) {
    case 'create':
        $controller->create();
        break;

    case 'store': // Caso para almacenar el nuevo rol
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->create(); // Procesa el formulario POST en el controlador
        }
        break;

    case 'edit':
        if ($id) {
            $controller->edit($id);
        } else {
            $controller->index();
        }
        break;

        case 'confirmDelete':
            if ($id) {
                $controller->confirmDelete($id); // Mostrar la vista de confirmación
            } else {
                $controller->index();
            }
            break;

    case 'delete':
        //eviados por el POST y pasarlos al controller
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_rol'])) {
            $controller->delete();
        } else {
            $controller->index();
        }
        break;
    
    case 'buscar':  //para manejar la búsqueda
        $controller->buscar($consulta);
        break;

    default:
        $controller->index();
        break;
}

?>