function clickExcel(){
    $('.dt-buttons .buttons-excel').click()
}

$(function () {
    const $table = $("#tableActividades");

    var $dataTableActividades = $table.DataTable({
        columnDefs: [
            {
                defaultContent: "-",
                targets: "_all",
            },
        ],
        stripeClasses: ["odd-row", "even-row"],
        lengthChange: true,
        lengthMenu: [
            [10, 10, 20, 50, -1],
            [10, 10, 20, 50, "Todo"],
        ],
        info: false,
        ajax: {
            url: "/auth/calendario/listarCalendario",
            data: function (d) {
                // Add date filters to the request
                d.fecha_desde = $("#fecha_desde").val();
                d.fecha_hasta = $("#fecha_hasta").val();
            },
        },
        columns: [
            {
                title: "N°",
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
            },
            {
                title: "Fecha Registro",
                data: "fecha_registro",
                class: "text-center",
                render: function (data) {
                    if (!data) return "-";
                    const date = new Date(data);
                    const options = { day: '2-digit', month: 'short' };
                    return new Intl.DateTimeFormat('en-GB', options).format(date);
                },
            },
            {
                title: "Nombre de Actividad",
                data: "nombre",
                class: "text-center",
            },
            { title: "Tema", data: "tema", class: "text-center" },
            { title: "Libro", data: "libro", class: "text-center" },
            { title: "Responsable", data: "responsable", class: "text-center" },
            {
                title: "Estado",
                data: "estado",
                render: function (data) {
                    return data === 1 || data === '1'
                        ? "<span class='estado-activo'>Activo</span>"
                        : "<span class='estado-inactivo'>Inactivo</span>";
                },
            },
            {
                data: null,
                render: function (data) {
                    return (
                        '<div class="btn-group">' +
                        '<a href="javascript:void(0)" class="btn-update btn btn-primary" idDato="' +
                        data.id +
                        '" style="margin-right: 5px;"><i class="fa fa-edit"></i> </a>' +
                        "</div>"
                    );
                },
            },
        ],
    });

    // Filter button click event
    $("#btn-consultar").on("click", function () {
        $dataTableActividades.ajax.reload(); // Reload data with new parameters
    });

    $table.on("click", ".btn-update", function () {
        const id = $dataTableActividades.row($(this).parents("tr")).data().id;
        invocarModalView(id);
    });

    function invocarModalView(id) {
        invocarModal(
            `/auth/calendario/partialView/${id ? id : 0}`,
            function ($modal) {
                if ($modal.attr("data-reload") === "true")
                    $dataTableActividades.ajax.reload(null, false);
            }
        );
    }
});
