$(function () {
    const $table = $("#tableAsistentes");

    var $dataTableAsistentes = $table.DataTable({
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
            url: "/auth/asistentes/list_all",
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
            /* { title: "DNI", data: "dni", class: "text-left" }, */
            {
                title: "Nombres y Apellidos",
                data: null,
                render: function (data, type, row) {
                    return row.nombre + " " + row.apellido; // Asegúrate de que 'nombre' y 'apellido' sean los nombres correctos
                },
                class: "text-left",
            },
            {
                title: "Fecha de Nacimiento",
                data: "fecha_nac",
                class: "text-left",
            },
            { title: "Distrito", data: "distrito_nombre", class: "text-left" },
            { title: "Dirección", data: "direccion", class: "text-left" },
            { title: "Teléfono", data: "tel", class: "text-left" },
            { title: "Género", data: "genero", class: "text-left" },
            { title: "Celula", data: "celula_nombre", class: "text-left" },
            { title: "Estado", data: "estado", class: "text-left" },
            {
                data: null,
                render: function (data) {
                    // Formatear el número de teléfono para WhatsApp
                    var phoneNumber = data.tel;
                    var whatsappUrl = `https://wa.me/${phoneNumber}`;

                    return (
                        '<div class="btn-group">' +
                        '<a href="javascript:void(0)" class="btn-update btn btn-primary" idDato="' +
                        data.id +
                        '" style="margin-right: 5px;"><i class="fa fa-edit"></i> </a>' +
                        '<a href="javascript:void(0)" class="btn-delete btn btn-danger" idDato="' +
                        data.id +
                        '"><i class="fa fa-trash"></i> </a>' +
                        '<a href="' +
                        whatsappUrl +
                        '" target="_blank" class="btn-whatsapp btn btn-success" style="margin-left: 5px;"><i class="fa fa-whatsapp"></i> </a>' +
                        "</div>"
                    );
                },
            },
        ],
    });
    /* Para abrir modal y editar */
    $table.on("click", ".btn-update", function () {
        const id = $dataTableAsistentes.row($(this).parents("tr")).data().id;
        invocarModalView(id);
    });

    function invocarModalView(id) {
        invocarModal(
            `/auth/asistentes/partialView/${id ? id : 0}`,
            function ($modal) {
                if ($modal.attr("data-reload") === "true")
                    $dataTableAsistentes.ajax.reload(null, false);
            }
        );
    }

    $table.on("click", ".btn-delete", function () {
        const id = $(this).attr("idDato");
        const formData = new FormData();
        formData.append("_token", $("input[name=_token]").val());
        formData.append("id", id);
        confirmAjax(
            `/auth/asistentes/delete`,
            formData,
            "POST",
            null,
            null,
            function () {
                $dataTableAsistentes.ajax.reload(null, false);
            }
        );
    });
});
