$(document).ready(function() {
    // Detectamos la entrada en el campo de búsqueda
    $("#buscarMateriasCrs").on("keyup", function() {
        var query_mt_curso = $(this).val();
        
        // Hacemos la llamada AJAX
        $.ajax({
            url: "../routers/materiasCursosRouter.php",
            method: "GET",
            data: { action: 'materiacurso_buscar', query_mt_curso: query_mt_curso },
            success: function(data) {
                $("#resultadoMateriasCrs").html(data); // Mostramos los resultados en la tabla
            }
        });
    });
});