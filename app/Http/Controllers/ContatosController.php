<?php

namespace App\Http\Controllers;

use App\Contatos;
use Illuminate\Http\Request;

class ContatosController extends Controller
{

    private $contatos;

    public function __construct(Contatos $contatos)
    {
        $this->contatos = $contatos;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * @return string
     */
    public function listar()
    {
        $response = $this->contatos->all();

        $data = [];
        if (isset($response[0]->id)) {
            foreach ($response as $tipo) {
                $data[] = [
                    'nome' => $tipo->nome,
                    'email' => $tipo->email
                ];
            }
        }

        return json_encode(["data" => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validação dos dados enviados pela requisição
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id', // Verifica se o cliente existe
            'contato_tipos_id' => 'required|exists:contato_tipos,id', // Tipo do contato deve existir
            'nome' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefone1' => 'nullable|string|max:15',
            'telefone2' => 'nullable|string|max:15',
            'celular' => 'nullable|string|max:15',
            'status' => 'required|boolean',
            'observacao' => 'nullable|string',
        ]);
    
        try {
            // Criação do contatos
            $contato = new Contatos();
            $contato->cliente_id = $validatedData['cliente_id'];
            $contato->contato_tipos_id = $validatedData['contato_tipos_id'];
            $contato->nome = $validatedData['nome'];
            $contato->email = $validatedData['email'] ?? null;
            $contato->telefone1 = $validatedData['telefone1'] ?? null;
            $contato->telefone2 = $validatedData['telefone2'] ?? null;
            $contato->celular = $validatedData['celular'] ?? null;
            $contato->status = $validatedData['status'];
            $contato->observacao = $validatedData['observacao'] ?? null;
    
            // Salva o contato no banco de dados
            $contato->save();
    
            // Retorna uma resposta de sucesso
            return response()->json([
                'status' => 200,
                'message' => 'Contato criado com sucesso!',
                'data' => $contato
            ]);
        } catch (\Exception $e) {
            // Captura erros e retorna uma mensagem
            return response()->json([
                'status' => 500,
                'message' => 'Erro ao criar contato: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contatos  $contatos
     * @return \Illuminate\Http\Response
     */
    public function show(Contatos $contatos)
{
    try {
        // Dados do contato a serem retornados
        $data = [
            'id' => $contatos->id,
            'cliente_id' => $contatos->cliente_id,
            'contato_tipos_id' => $contatos->contato_tipos_id,
            'nome' => $contatos->nome,
            'email' => $contatos->email,
            'telefone1' => $contatos->telefone1,
            'telefone2' => $contatos->telefone2,
            'celular' => $contatos->celular,
            'status' => $contatos->status ? "Ativo" : "Inativo",
            'observacao' => $contatos->observacao,
        ];

        // Retorna os dados como JSON
        return response()->json([
            'status' => 200,
            'message' => 'Contato encontrado com sucesso!',
            'data' => $data
        ]);
    } catch (\Exception $e) {
        // Em caso de erro, retorna uma mensagem de erro
        return response()->json([
            'status' => 500,
            'message' => 'Erro ao buscar o contato: ' . $e->getMessage()
        ], 500);
    }
}
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contatos  $contatos
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Contatos $contatos)
    {
        // Validação dos dados enviados pela requisição
        $validatedData = $request->validate([
            'contato_tipos_id' => 'required|exists:contato_tipos,id', // Tipo do contato deve existir
            'nome' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefone1' => 'nullable|string|max:15',
            'telefone2' => 'nullable|string|max:15',
            'celular' => 'nullable|string|max:15',
            'status' => 'required|boolean',
            'observacao' => 'nullable|string',
        ]);
    
        try {
            // Atualizar os campos do contato
            $contatos->contato_tipos_id = $validatedData['contato_tipos_id'];
            $contatos->nome = $validatedData['nome'];
            $contatos->email = $validatedData['email'] ?? null;
            $contatos->telefone1 = $validatedData['telefone1'] ?? null;
            $contatos->telefone2 = $validatedData['telefone2'] ?? null;
            $contatos->celular = $validatedData['celular'] ?? null;
            $contatos->status = $validatedData['status'];
            $contatos->observacao = $validatedData['observacao'] ?? null;
    
            // Salva as alterações no banco de dados
            $contatos->save();
    
            // Retorna uma resposta de sucesso
            return response()->json([
                'status' => 200,
                'message' => 'Contato atualizado com sucesso!',
                'data' => $contatos
            ]);
        } catch (\Exception $e) {
            // Captura erros e retorna uma mensagem
            return response()->json([
                'status' => 500,
                'message' => 'Erro ao atualizar contato: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contatos  $contatos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contatos $contatos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contatos  $contatos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contatos $contatos)
    {
        //
    }
}
