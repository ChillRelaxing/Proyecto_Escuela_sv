
$(document).ready(function() {
    // Detectamos la entrada en el campo de búsqueda
    $("#buscarEstudianteMateria").on("keyup", function() {
        var query_em = $(this).val();
        
        // Hacemos la llamada AJAX
        $.ajax({
            url: "../routers/estudianteMateriaRouter.php",
            method: "GET",
            data: { action: 'buscan', query_em: query_em },
            success: function(data) {
                $("#resultadoEstudiante_materia").html(data); // Mostramos los resultados en la tabla
            }
        });
    });
});