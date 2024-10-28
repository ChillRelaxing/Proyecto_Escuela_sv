<?php

require_once '../controllers/EstudianteMateriaController.php';

// Capturamos la opción de la URL
$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';
//AJAX
$query_em = isset($_GET['query_em']) ? $_GET['query_em'] : '';

// Instanciamos el controlador
$controller = new EstudianteMateriaController();

// Switch para manejar las acciones basadas en el valor de $action
switch ($action) {
    case 'create':
        $controller->create();
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
            $controller->confirmDelete($id); // Mostrar la confirmación
        } else {
            $controller->index();
        }
        break;

    case 'delete':
        if ($_POST && isset($_POST['id'])) {
            $controller->delete(); // Realizar la eliminación
        } else {
            $controller->index();
        }
        break;

    case 'buscan':  //para manejar la búsqueda
        $controller->buscan($query_em);
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
