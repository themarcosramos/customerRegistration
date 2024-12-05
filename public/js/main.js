
var main = (function () {

    var qtdPageLoad = 0;

    return {

        iniView: function (){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            });
        },

        upload_arquivo: function (formularioId, pasta, id, campo) {

            campo = (typeof campo !== 'undefined') ? campo : 'upload_arquivos';

            var urls = '';
            $.ajax({
                url: 'uploads/' + pasta + '/' + id,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function (response) {
                    urls = response.urlJson;
                    urlImagem = response.urlImagem;

                },
                complete: function () {

                    $("#" + formularioId + ' #' + campo).fileinput({
                        language: 'pt-BR',
                        allowedFileExtensions: ["jpg", "gif", "png", "txt", "jpeg"],
                        initialPreview: urlImagem,
                        initialPreviewAsData: true,
                        initialPreviewConfig: urls,
                        deleteUrl: "/uploads/delete",
                        uploadUrl: 'uploads/' + pasta + '/' + id,
                        overwriteInitial: false,
                        maxFileSize: 100,
                        initialCaption: "Selecione um arquivo"
                    });

                }
            });

        },

        atualizarDataTable: function(dataTableId){
            $('#' + dataTableId).DataTable().ajax.reload(null, false);
        },
        atualizarDataTableDataSource: function(dataTableId, DataSource){
            $('#' + dataTableId).DataTable().clear().rows.add(DataSource).draw()
        },

        carregarPagina: function (visivel) {

            qtdPageLoad += (visivel == true) ? 1 : -1;
            if (qtdPageLoad > 0) {
                $("#loading-saron").show();
            } else {
                $("#loading-saron").hide();
                qtdPageLoad = 0;
            }

        },

        carregarCep: function (formularioId, cep) {

            if ($('#' + formularioId + ' #pais').val() != 'BRA' || cep == "")
                return;

            $.ajax({
                url: '/carregarCep/' + cep,
                type: 'get',
                async: true,
                beforeSend: function () {
                    main.carregarPagina(true);
                },
                success: function (response) {
                    $('#' + formularioId + ' #cep').val(response.response.cep);
                    $('#' + formularioId + ' #logradouro').val(response.response.logradouro);
                    $('#' + formularioId + ' #bairro').val(response.response.bairro);
                    $('#' + formularioId + ' #cidade').val(response.response.localidade);
                    $('#' + formularioId + ' #uf').val(response.response.uf);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alertify.error(xhr.status + ' - ' + thrownError);
                },
                complete: function () {
                    main.carregarPagina(false);
                }
            });
        },

        enviarAjaxPostValidate: function (url, formId, functionSuccess){
            if (!$('#'+ formId).valid())
                return;

            main.enviarAjax('POST', url, $('#'+ formId).serialize(), functionSuccess);
        },
        enviarAjaxPost: function (url, data, functionSuccess){
            main.enviarAjax('POST', url, data, functionSuccess);
        },
        enviarAjax: function (type, url, data, functionSuccess){
            $.ajax({
                type: type,
                url: url,
                async: false,
                data: data,
                beforeSend: function () {
                    main.carregarPagina(true);
                },
                success: function (result) {
                    if (result['status'] != 200) {
                        if (result['mensagem'])
                            alertify.error(result['mensagem']);
                        else
                            alertify.error("Erro ao processar dados");
                    } else {
                        alertify.success("Dados processados com sucesso");
                        if (functionSuccess != null) functionSuccess(result['response']);
                    }
                },
                complete: function () {
                    main.carregarPagina(false);
                }
            });
        },

        dateToBR: function (date) {
            var d  = new Date(date);
            var yyyy = d.getFullYear().toString();
            var mm = (d.getMonth()+1).toString();;
            var dd  = d.getDate().toString();;

            return (dd[1] ? dd : "0" + dd[0]) + "/" + (mm[1] ? mm : "0" + mm[0]) + "/" + yyyy;
        }

    }

})(jQuery);
