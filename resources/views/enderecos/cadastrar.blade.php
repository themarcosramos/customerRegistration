<form action="#" method="post" name="form_cadastro_endereco" id="form_cadastro_endereco">

    <div class="modal-body">
        {{ csrf_field() }}
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="form_parent_id" id="form_parent_id">
        <input type="hidden" name="modal_pane_id" id="modal_pane_id">

        <div class="row">
            <div class="col-md-6">
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
                    <input type="text" name="logradouro" id="logradouro" class="form-control"
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
                    <input type="text" name="uf" id="uf" class="form-control" placeholder="UF" required>
                </div>
            </div>
        </div>
        <div class="row">
   
            <div class="col-md-8">
                <div class="form-group">
                    <label for="complemento">Complemento</label>
                    <input type="text" name="complemento" id="complemento" class="form-control"
                           placeholder="Complemento" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="endereco_observacao">Observação</label>
                    <textarea name="endereco_observacao" id="endereco_observacao"
                              class="form-control"></textarea>
                </div>
            </div>
        </div>
    </div>

</form>

<script>

    $(function () {

        main.iniView();
        mascaras.init();



        @if(isset($formParentId))
            $('#form_cadastro_endereco #form_parent_id').val('{{ $formParentId }}');
        @endif

        @if(isset($response))
            var result = JSON.parse('{!! json_encode($response) !!}');
            carregarEndereco(result);
        @endif

        function carregarEndereco(result) {
            if (result['status'] != 200) {
                if (result['mensagem'])
                    alertify.error(result['mensagem']);
                else
                    alertify.error("Erro ao processar dados");
            } else {
                $('#form_cadastro_endereco #id').val(result['response']['endereco']['id']);
                $('#form_cadastro_endereco #cep').val(result['response']['endereco']['cep']);
                $('#form_cadastro_endereco #logradouro').val(result['response']['endereco']['logradouro']);
                $('#form_cadastro_endereco #numero').val(result['response']['endereco']['numero']);
                $('#form_cadastro_endereco #cidade').val(result['response']['endereco']['cidade']);
                $('#form_cadastro_endereco #bairro').val(result['response']['endereco']['bairro']);
                $('#form_cadastro_endereco #uf').val(result['response']['endereco']['uf']);
                $('#form_cadastro_endereco #pais').val(result['response']['endereco']['pais']);
                $('#form_cadastro_endereco #complemento').val(result['response']['endereco']['complemento']);
                $('#form_cadastro_endereco #endereco_observacao').val(result['response']['endereco']['observacao']);
            }
        }

        $($('#form_cadastro_endereco #modal_pane_id').val() + " .btn_modal_salvar").prop('onclick',null).off('click');
        $($('#form_cadastro_endereco #modal_pane_id').val() + " .btn_modal_salvar").click(function () {
            main.enviarAjaxPostValidate(
                "enderecos/salvar",
                'form_cadastro_endereco',
                function (){
                    main.atualizarDataTable('tb_enderecos');
                    modal.close_n2();
                }
            );
        });

        $("#form_cadastro_endereco #cep").blur(function () {
            main.carregarCep('form_cadastro_endereco', this.value)
        });
    });

</script>
