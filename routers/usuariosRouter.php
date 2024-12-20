<?php

require_once '../controllers/usuarioController.php';

// Capturamos la opción de la URL
$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';
//AJAX
$query = isset($_GET['query']) ? $_GET['query'] : '';


// Instanciamos el controlador
$controller = new usuarioController();

// Switch para manejar las acciones basadas en el valor de $action
switch ($action) {
    case 'create':
        $controller->create();
        break;

    case 'store': // Caso para almacenar el nuevo usuario
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->delete();
        } else {
            $controller->index();
        }
        break;
    
    case 'search':  //para manejar la búsqueda
        $controller->search($query);
        break;

    case 'exportCSV':
        $controller->exportToCSV();
        break;
        
    case 'exportExcel':
        $controller->exportToExcel();
        break;
        
    case 'exportPDF':
        $controller->exportToPDF();
        break;

    default:
        $controller->index();
        break;
}
?>