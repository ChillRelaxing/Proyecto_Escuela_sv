<?php

require_once '../controllers/MateriasCursosController.php';

// Capturamos la opción de la URL
$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';
//AJAX
$query_mt_curso = isset($_GET['query_mt_curso']) ? $_GET['query_mt_curso'] : '';

// Instanciamos el controlador
$controller = new MateriasCursosController();

// Switch para manejar las acciones basadas en el valor de $action
switch ($action) {
    case 'create':
        $controller->create();
        break;

    case 'store': // Caso para almacenar el nuevo MateriasCursos
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
        if ($id) {
            $controller->delete($id);
        } else {
            $controller->index();
        }
        break;

    case 'materiacurso_buscar':  //para manejar la búsqueda
        $controller->materiacurso_buscar($query_mt_curso);
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
