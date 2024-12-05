@extends('adminlte::page')

@section('title', 'CRUD')

@section('content_header')
    {{--<h3>Clientes</h3>--}}
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box-body">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Clientes</h3>
                    </div>
                    <div class="box-body">

                        <div class="row">
                            <div class="col-md-4">
                                <button id="btn_novo_cliente" class="btn btn-primary btn-sm">
                                    <span class="glyphicon glyphicon-plus"></span>
                                    Novo
                                </button>
                            </div>
                        </div>

                        <table id="tb_clientes" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Razão Social ou Nome </th>
                                    <th>Nome Fantasia  ou Sobrenome</th>
                                    <th>CNPJ/CPF</th>
                                    <th>Status</th>
                                    <th> </th>  <!-- Adicionada coluna para ações -->
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')

    <script>

        $(function () {

            main.iniView();

            $('#tb_clientes').DataTable({
                "ajax": "clientes/listar",
                "columns": [
                    {"data": "nome_razaoSocial"},
                    {"data": "sobrenome_nomeFantasia"},
                    {"data": "cnpj_cpf"},
                    {"data": "status"},
                    {
                        "data": "id",
                        "width": 15,
                        "sClass": "grid-column-value-nowrap-button",
                        "render": function (data, type, row) {
                            // Botão de visualizar
                            var viewButton = "<button class='btn btn-info btn-sm' value='" + data + "' title='Visualizar'><span class='glyphicon glyphicon-search'></span></button>";
                            
                            // Botão de excluir
                            var deleteButton = "<button class='btn btn-danger btn-sm btn-excluir' value='" + data + "' title='Excluir'><span class='glyphicon glyphicon-trash'></span></button>";
                            
                            return viewButton + " " + deleteButton;  // Adicionando os botões à coluna de ações
                        }
                    }
                ],
                "destroy": true,
                'paging': true,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                "fnDrawCallback": function (oSettings) {
                    // Ação de editar (visualizar)
                    $(".grid-column-value-nowrap-button").on('click', 'button', function () {
                        var clienteId = $(this).val();
                        if ($(this).hasClass('btn-info')) {
                            modal.open_n("clientes/show/" + clienteId, 'Editar cliente', 70);
                        }
                    });

                    // Ação de excluir (inativar)
                    $(".btn-excluir").on('click', function () {
                        var clienteId = $(this).val();
                        if (confirm('Tem certeza que deseja inativar este cliente?')) {
                            excluirCliente(clienteId);
                        }
                    });
                }
            });

            $('#btn_novo_cliente').click(function () {
                modal.open_n("clientes/cadastrar", 'Novo cliente', 70);
            });

        });

        // Função para excluir (inativar) um cliente
        function excluirCliente(clienteId) {
            $.ajax({
                url: "/clientes/excluir",  // A URL da rota de exclusão lógica
                type: "POST",  // Usa POST, pois estamos enviando dados
                data: {
                    id: clienteId,
                    _token: $('meta[name="csrf-token"]').attr('content')  // Token CSRF
                },
                success: function (response) {
                    if (response.status === 200) {
                        alert(response.message);  // Exibe a mensagem de sucesso
                        $('#tb_clientes').DataTable().ajax.reload();  // Recarrega a tabela
                    } else {
                        alert('Erro ao inativar cliente.');
                    }
                },
                error: function (xhr) {
                    alert(xhr.responseJSON.message || 'Erro ao inativar cliente.');
                }
            });
        }

    </script>

@stop
