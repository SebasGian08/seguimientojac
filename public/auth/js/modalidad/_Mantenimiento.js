var OnSuccessRegistroModalidad, OnFailureRegistroModalidad;
$(function(){

    const $modal = $("#modalMantenimientoModalidad"), $form = $("form#registroModalidad");

    OnSuccessRegistroModalidad = (data) => onSuccessForm(data, $form, $modal);
    OnFailureRegistroModalidad = () => onFailureForm();
});
