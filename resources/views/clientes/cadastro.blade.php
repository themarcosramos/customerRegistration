<form action="#" method="post" name="form_cadastro_cliente" id="form_cadastro_cliente" data-toggle="validator">

    <div class="modal-body">

        {{ csrf_field() }}
        <input type="hidden" name="modal_pane_id" id="modal_pane_id">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>CNPJ/CPF</label>
                    <input type="text" name="cnpj_cpf" id="cnpj_cpf" class="form-control cnpjCpfMask"
                           placeholder="CNPJ/CPF" required  data-error="Please fill this field...">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Razão Social ou Nome </label>
                    <input type="text" name="nome_razaoSocial" id="nome_razaoSocial" class="form-control"
                           placeholder="Razão Social ou Nome" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nome Fantasia  ou Sobrenome </label>
                    <input type="text" name="sobrenome_nomeFantasia" id="sobrenome_nomeFantasia"
                           class="form-control"
                           placeholder="Nome Fantasia ou Sobrenome " required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_contato" data-toggle="tab">Contato</a></li>
                        <li><a href="#tab_endereco" data-toggle="tab">Endereço</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_contato">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nome">Nome</label>
                                        <input type="text" name="nome" id="nome" class="form-control"
                                               placeholder="Nome" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" class="form-control"
                                               placeholder="Email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telefone_1">Telefone 1</label>
                                        <input type="text" name="telefone1" id="telefone1"
                                               class="form-control telefoneMask"
                                               placeholder="Telefone 1" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telefone_2">Telefone 2</label>
                                        <input type="text" name="telefone2" id="telefone2"
                                               class="form-control telefoneMask"
                                               placeholder="Telefone 2" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="celular">Celular</label>
                                        <input type="text" name="celular" id="celular" class="form-control celularMask"
                                               placeholder="Celular" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_endereco">

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="cep">CEP</label>
                                        <input type="text" name="cep" id="cep" class="form-control cepMask" placeholder="CEP" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="logradouro">Logradouro</label>
                                        <input type="text" name="logradouro" id="logradouro"
                                               class="form-control"
                                               placeholder="Logradouro" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="numero">Número</label>
                                        <input type="text" name="numero" id="numero" class="form-control"
                                               placeholder="Número" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="bairro">Bairro</label>
                                        <input type="text" name="bairro" id="bairro" class="form-control"
                                               placeholder="Bairro" required>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="cidade">Cidade</label>
                                        <input type="text" name="cidade" id="cidade" class="form-control"
                                               placeholder="Cidade" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="uf">UF</label>
                                        <input type="text" name="uf" id="uf" class="form-control"
                                               placeholder="UF" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="complemento">Complemento</label>
                                        <input type="text" name="complemento" id="complemento"
                                               class="form-control"
                                               placeholder="Complemento" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

<script>

    $(function () {

        main.iniView();
        mascaras.init();

        $('.ativoInativo').bootstrapToggle({
            on: 'sim',
            off: 'não',
            size: 'mini'
        });

        $($('#form_cadastro_cliente #modal_pane_id').val() + " .btn_modal_salvar").prop('onclick',null).off('click');
        $($('#form_cadastro_cliente #modal_pane_id').val() + " .btn_modal_salvar").click(function () {

            main.enviarAjaxPostValidate(
                "clientes/salvar",
                'form_cadastro_cliente',
                function (){
                    main.atualizarDataTable('form_cadastro_cliente #tb_clientes');
                    modal.close_n1();
                }
            );
        });

        $("#form_cadastro_cliente #cep").blur(function () {
            main.carregarCep('form_cadastro_cliente', this.value)
        });
    });

</script>
