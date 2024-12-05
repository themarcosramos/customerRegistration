<?php

namespace App\Http\Controllers;

use App\Clientes;
use App\Contatos;
use App\Enderecos;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    /**
     * @var Clientes
     */
    private $clientes;

    public function __construct(Clientes $clientes)
    {
        $this->clientes = $clientes;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('clientes.index');
    }

    /**
     * List all clients.
     *
     * @return string
     */
    public function listar()
    {
        $response = $this->clientes->where('status', 1)->get();

        $data = [];
        foreach ($response as $cliente) {
            $data[] = [
                'id' => $cliente->id,
                'tipo_clientes_id' => $cliente->tipo_clientes_id,
                'nome_razaoSocial' => $cliente->nome_razaoSocial,
                'sobrenome_nomeFantasia' => $cliente->sobrenome_nomeFantasia,
                'cnpj_cpf' => $cliente->cnpj_cpf,
                'rg_inscricaoEstadual' => $cliente->rg_inscricaoEstadual,
                'inscricao_municipal' => $cliente->inscricao_municipal,
                'status' => $cliente->status ? "Ativo" : "Inativo",
                'observacao' => $cliente->observacao,
            ];
        }

        return json_encode(["data" => $data]);
    }

    /**
     * Show the form for creating a new client.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cadastrar()
    {
        return view('clientes.cadastro');
    }

    /**
     * Save or update a client.
     *
     * @param Request $request
     * @return array
     */
    public function salvar(Request $request)
    {
        $id = $request->input('id');
        if (!is_null($id)) {
            return $this->editar($request);
        } else {
            $clientes = new Clientes();
            $clientes->fill($request->all());
            $clientes->tipo_clientes_id = 1;
            $clientes->observacao = $request->cliente_observacao;

            if (!$clientes->save()) {
                throw new \InvalidArgumentException('Erro ao cadastrar novo Cliente');
            }

            $contatos = new Contatos();
            $contatos->fill($request->all());
            $contatos->clientes_id = $clientes->id;
            $contatos->contato_tipos_id = 1;
            $contatos->observacao = $request->contato_observacao;
            $contatos->save();

            $enderecos = new Enderecos();
            $enderecos->fill($request->all());
            $enderecos->clientes_id = $clientes->id;
            $enderecos->observacao = $request->endereco_observacao;
            $enderecos->save();

            return response()->json([
                'status' => 201,
                'message' => 'Cliente cadastrado com sucesso',
                'cliente' => $clientes,
            ], 201); 
        }
    }

    /**
     * Edit an existing client.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editar(Request $request)
    {
        $id = $request->input('id');
        $cliente = Clientes::find($id);

        if (!$cliente) {
            throw new \InvalidArgumentException('Cliente não encontrado');
        }

        $cliente->fill($request->all());
        $cliente->observacao = $request->cliente_observacao;

        try {
            $cliente->save();
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Erro ao atualizar o Cliente: ' . $e->getMessage());
        }

        // Atualizar contatos
        $contato = Contatos::where('clientes_id', $id)->first();
        if ($contato) {
            $contato->fill($request->all());
            $contato->observacao = $request->contato_observacao;
            $contato->save();
        }

        // Atualizar endereços
        $endereco = Enderecos::where('clientes_id', $id)->first();
        if ($endereco) {
            $endereco->fill($request->all());
            $endereco->observacao = $request->endereco_observacao;
            $endereco->save();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Cliente atualizado com sucesso',
            'cliente' => $cliente,
        ]);
    }

    /**
     * Get contacts for a client.
     *
     * @param $clienteId
     * @return string
     */
    public function contatos($clienteId)
    {
        $response = $this->clientes->find($clienteId)->contatos;

        $data = [];
        foreach ($response as $contato) {
            $data[] = [
                'id' => $contato->id,
                'contato_tipos_id' => $contato->contato_tipos_id,
                'nome' => $contato->nome,
                'email' => $contato->email,
                'telefone1' => $contato->telefone1,
                'telefone2' => $contato->telefone2,
                'celular' => $contato->celular,
                'status' => $contato->status ? "Ativo" : "Inativo",
                'observacao' => $contato->observacao,
            ];
        }

        return json_encode(["data" => $data]);
    }

    /**
     * Get addresses for a client.
     *
     * @param $clienteId
     * @return string
     */
    public function enderecos($clienteId)
    {
        $response = $this->clientes->find($clienteId)->enderecos;

        $data = [];
        foreach ($response as $endereco) {
            $data[] = [
                'id' => $endereco->id,
                'logradouro' => $endereco->logradouro,
                'numero' => $endereco->numero,
                'complemento' => $endereco->complemento,
                'bairro' => $endereco->bairro,
                'cidade' => $endereco->cidade,
                'uf' => $endereco->uf,
                'cep' => $endereco->cep,
                'status' => $endereco->status ? "Ativo" : "Inativo",
                'observacao' => $endereco->observacao,
            ];
        }

        return json_encode(["data" => $data]);
    }

    /**
     * Show the form for editing a client.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->clientes->find($id);

        return view('clientes.editar', [
            'response' => $response,
        ]);
    }
    public function excluir(Request $request)
    {
        $id = $request->input('id');
        $cliente = Clientes::find($id);
    
        if (!$cliente) {
            return response()->json([
                'status' => 404,
                'message' => 'Cliente não encontrado',
            ], 404);
        }
    
        // Verificar se o campo 'status' está presente
        if (!isset($cliente->status)) {
            return response()->json([
                'status' => 400,
                'message' => 'Campo status não encontrado no cliente.',
            ], 400);
        }
    
        // Atualiza o status do cliente para inativo (0)
        $cliente->status = 0;
    
        try {
            // Tente salvar as alterações
            if ($cliente->save()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Cliente inativado com sucesso',
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Falha ao salvar o cliente',
                ], 500);
            }
        } catch (\Exception $e) {
            // Log para depuração
            \Log::error('Erro ao inativar cliente: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Erro ao inativar o Cliente: ' . $e->getMessage(),
            ], 500);
        }
    }
    
}
