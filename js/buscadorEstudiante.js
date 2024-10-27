$(document).ready(function() {
    // Detectamos la entrada en el campo de búsqueda
    $("#buscarEstudiante").on("keyup", function() {
        var query_est = $(this).val();
        
        // Hacemos la llamada AJAX
        $.ajax({
            url: "../routers/estudiantesRouter.php",
            method: "GET",
            data: { action: 'Estudiante_buscan', query_est: query_est },
            success: function(data) {
                $("#resultadoEstudiante").html(data); // Mostramos los resultados en la tabla
            }
        });
    });
});

// Función para redirigir al usuario según la opción seleccionada en el SelectList
function navigateToTable_Estd() {
    var tableUrl_Estd= document.getElementById("tableSelect_Estd").value;
    if (tableUrl_Estd) {
        window.location.href = tableUrl_Estd;
    }
}