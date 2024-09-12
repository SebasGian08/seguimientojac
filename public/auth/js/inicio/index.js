$(document).ready(function() {
    $('#filtro-form').submit(function() {
        $('#loading').show(); // Muestra el indicador de carga
        $('#filtro-submit').attr('disabled',
            true); 
        return true; 
    });
});

$(function () {
    const $table = $("#tableInicio");

    var $dataTableInicio = $table.DataTable({
        stripeClasses: ["odd-row", "even-row"],
        lengthChange: true,
        lengthMenu: [
            [10, 10, 20, 50, -1],
            [10, 10, 20, 50, "Todo"],
        ],
        info: false,
        ajax: {
            url: "/auth/inicio/listSeguimiento", // Ruta al endpoint del controlador
            dataSrc: 'data', // Especifica que los datos están en la propiedad "data"
        },
        columns: [
            {
                title: "N°",
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
            },
            { title: "Nombre del Asistente", data: "NombreDelAsistente", class: "text-left" },
            { title: "Célula", data: "Célula", class: "text-left" },
            { title: "Programas Registrados", data: "NúmeroDeEventosRegistrados", class: "text-left" },
            { title: "Programas Asistidos", data: "NúmeroDeEventosAsistidos", class: "text-left" },
            { title: "Porcentaje de Asistencia", data: "PorcentajeDeAsistencia", class: "text-left" },
            { title: "Última Asistencia", data: "ÚltimaAsistencia", class: "text-left" },
            { title: "Estado de Compromiso", data: "EstadoDeCompromiso", class: "text-left" },
        ],
    });
});

