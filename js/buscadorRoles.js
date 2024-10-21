$(document).ready(function() {
    // Detectamos la entrada en el campo de búsqueda
    $("#buscarRol").on("keyup", function() {
        var consulta = $(this).val();
        
        // Hacemos la llamada AJAX
        $.ajax({
            url: "../routers/rolesRouter.php",
            method: "GET",
            data: { action: 'buscar', consulta: consulta },
            success: function(data) {
                $("#resultadoRoles").html(data); // Mostramos los resultados en la tabla
            }
        });
    });
});