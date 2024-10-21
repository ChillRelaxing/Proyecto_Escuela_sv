$(document).ready(function() {
    // Detectamos la entrada en el campo de búsqueda
    $("#buscarReporte").on("keyup", function() {
        var query_reporte = $(this).val();
        
        // Hacemos la llamada AJAX
        $.ajax({
            url: "../routers/reporteRouter.php",
            method: "GET",
            data: { action: 'buscando', query_reporte: query_reporte },
            success: function(data) {
                $("#resultadoReporte").html(data); // Mostramos los resultados en la tabla
            }
        });
    });
});