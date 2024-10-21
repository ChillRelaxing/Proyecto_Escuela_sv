
$(document).ready(function() {
    // Detectamos la entrada en el campo de búsqueda
    $("#buscarUsuario").on("keyup", function() {
        var query = $(this).val();
        
        // Hacemos la llamada AJAX
        $.ajax({
            url: "../routers/usuariosRouter.php",
            method: "GET",
            data: { action: 'search', query: query },
            success: function(data) {
                $("#resultadoUsuarios").html(data); // Mostramos los resultados en la tabla
            }
        });
    });
});