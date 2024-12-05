
var modal = (function () {

    var modal_pane_active = 0;
    var modal_pane_active_name = null;
    var modal_func_after_open = [];
    var modal_func_after_close = [];
    var modal_pane_n1 = '#modal-pane-n1';
    var modal_pane_n2 = '#modal-pane-n2';
    var modal_pane_n3 = '#modal-pane-n3';
    var modal_pane_n4 = '#modal-pane-n4';
    var modal_pane_n5 = '#modal-pane-n5';

    var ajax_method = 'GET';
    var ajax_type = 'html';
    var ajax_timeout = 120000;
    var ajax_contentType = 'application/x-www-form-urlencoded; charset=UTF-8';

    $(modal_pane_n1 + "," + modal_pane_n2 + "," + modal_pane_n3 + "," + modal_pane_n4 + "," + modal_pane_n5).on('shown.bs.modal', function (e) {
        modal_pane_active++;

        var modal_pane_func_id = "#" + $(this).attr('id');
        jQuery.each(modal_func_after_open, function(index, funcao) {
            if (modal_pane_func_id == funcao.modal_pane){
                funcao.funcao();
                modal_func_after_open.splice(index, 1);
            }
        });
    });

    $(modal_pane_n1 + "," + modal_pane_n2 + "," + modal_pane_n3 + "," + modal_pane_n4 + "," + modal_pane_n5).on('hidden.bs.modal', function (e) {
        modal_pane_active--;

        var modal_pane_func_id = "#" + $(this).attr('id');
        jQuery.each(modal_func_after_close, function(index, funcao) {
            if (modal_pane_func_id == funcao.modal_pane){
                funcao.funcao();
                modal_func_after_close.splice(index, 1);
            }
        });
    });

    return {
        open_n: function (url, title, width, func_after_open) {
            switch (modal_pane_active)
            {
                case 0:
                    modal.open_n1(url, title, width, func_after_open);
                    break;
                case 1:
                    modal.open_n2(url, title, width, func_after_open);
                    break;
                case 2:
                    modal.open_n3(url, title, width, func_after_open);
                    break;
                case 3:
                    modal.open_n4(url, title, width, func_after_open);
                    break;
                case 4:
                    modal.open_n5(url, title, width, func_after_open);
                    break;
                default:
                    alert('Quantidade do modal não implementado');
                    break;
            }
        },
        open_n1: function (url, title, width, func_after_open) {
            modal.open_modal(url, title, width, modal_pane_n1, func_after_open);
        },
        open_n2: function (url, title, width, func_after_open) {
            modal.open_modal(url, title, width, modal_pane_n2, func_after_open);
        },
        open_n3: function (url, title, width, func_after_open) {
            modal.open_modal(url, title, width, modal_pane_n3, func_after_open);
        },
        open_n4: function (url, title, width, func_after_open) {
            modal.open_modal(url, title, width, modal_pane_n4, func_after_open);
        },
        open_n5: function (url, title, width, func_after_open) {
            modal.open_modal(url, title, width, modal_pane_n5, func_after_open);
        },
        open_modal: function (url, title, width, modal_pane, func_after_open) {
            if (func_after_open != null) {
                modal_func_after_open.push({
                    modal_pane: modal_pane,
                    funcao: func_after_open
                });
            }

            var body = $('body');
            var modal = $(modal_pane).find('.modal-pane-dialog');
            var modal_body = $(modal_pane).find('.modal-pane-body');
            var modal_title = $(modal_pane).find('.modal-pane-title');
            modal.css('width', width + '%');
            modal.css('max-width', '100%');
            $.ajax({
                url: url,
                method: ajax_method,
                dataType: ajax_type,
                timeout: ajax_timeout,
                contentType: ajax_contentType,
                async: true,
                beforeSend: function () {
                    main.carregarPagina(true);
                    $(modal_pane).modal('hide');
                },
                complete: function () {
                    main.carregarPagina(false);
                },
                error: function (httpObj, textStatus) {
                    main.carregarPagina(false);

                    //if (httpObj.status === 401)
                    //    location.href = 'usuario/login';
                },
                success: function (response) {
                    $(modal_pane).on('show.bs.modal', function () {
                        main.carregarPagina(true);
                    });

                    $(modal_pane).on('shown.bs.modal', function () {
                        main.carregarPagina(false);
                    });

                    $(modal_title).html(title);
                    $(modal_body).html(response);
                    if ($(modal_body).find("#modal_pane_id").length)
                        $(modal_body).find("#modal_pane_id").val(modal_pane);

                    $(modal_pane).find(".btn_modal_auxiliar").hide();
                    $(modal_pane).find(".btn_modal_salvar").show();

                    $(modal_pane).modal('show');

                    modal_pane_active_name = modal_pane;
                }
            });
            $(modal_pane).css('overflow-y', 'auto');
        },
        close_n: function (func_after_close) {
            switch (modal_pane_active)
            {
                case 1:
                    modal.close_n1(func_after_close);
                    break;
                case 2:
                    modal.close_n2(func_after_close);
                    break;
                case 3:
                    modal.close_n3(func_after_close);
                    break;
                case 4:
                    modal.close_n4(func_after_close);
                    break;
                case 5:
                    modal.close_n5(func_after_close);
                    break;
                default:
                    alert('Quantidade do modal não implementado');
                    break;
            }
        },
        close_n1: function (func_after_close) {
            modal.close_modal(modal_pane_n1, func_after_close);
        },
        close_n2: function (func_after_close) {
            modal.close_modal(modal_pane_n2, func_after_close);
        },
        close_n3: function (func_after_close) {
            modal.close_modal(modal_pane_n3, func_after_close);
        },
        close_n4: function (func_after_close) {
            modal.close_modal(modal_pane_n4, func_after_close);
        },
        close_n5: function (func_after_close) {
            modal.close_modal(modal_pane_n5, func_after_close);
        },
        close_modal: function (modal_pane, func_after_close) {
            if (func_after_close != null) {
                modal_func_after_close.push({
                    modal_pane: modal_pane,
                    funcao: func_after_close
                });
            }

            $(modal_pane).modal('hide');
        },

        scrollView: function (object_id_focus) {
            $(modal_pane_active_name).animate({
                scrollTop: $(object_id_focus).offset().top
            }, 1000);
        }
    }

})(jQuery);
