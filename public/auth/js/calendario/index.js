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
            data: function (s) {},
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
            },
            {
                title: "Nombre de Actividad",
                data: "nombre",
                class: "text-center",
            },
            { title: "Lugar", data: "lugar", class: "text-center" },
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
    /* Para abrir modal y editar */
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
