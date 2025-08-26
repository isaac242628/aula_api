<?php

namespace App\Http\Controllers;

use App\Models\primeira_api;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PrimeiraApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registros = Produtos::all();

        $contador = $registros->count();

        if ($contador > 0){
            return response()->json([
                'success' => true,
                'message' => 'Produtos encontradas com sucesso!',
                'data' => $registros,
                'total' => $contador
            ], 200); 
        } else{
            return response()->json([
                'success' => false,
                'message' => 'Nenhum produto encontrada.',
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'name' => 'required',
            'marca' => 'required',
            'preco' => 'required',
        ]);
        if($validador->fails()){
            return response()->json([
                'success' =>false,
                'message' => 'Produtos cadastrados com sucesso!',
                'data' => $registros

            ], 201);
        } else{
            return response()-json([
                'success' => false,
                'message' => 'Erro ao cadastrar um produto'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $registros = Produtos::find($id);

        if($registros){
            return response()->json([
                'success' => true,
                'message' => 'Produto localizada com sucesso!',
                'data' =>$registros
            ], 200);
        } else{
            return response()->json([
                'success' =>false,
                'message' => 'Produto não localizado.',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validador = Validador::make($request->all(), [
            'name' => 'required',
            'message' => 'required',
            'preco' => 'required',
        ]);

        if($validador->fails()){
            return response()->json([
                'succcess' => false,
                'message' => 'Registros inválidos',
                'errors' => $validador->errors()
            ], 400);
        }

        $registrosBanco->name = $request->name;
        $registrosBanco->marca = $request->marca;
        $registrosBanco->preco = $request->preco;

        if($registrosBanco->save()){
            return response()->json([
                'success' => true,
                'message' => 'Produto atualizado com sucesso!',
                'data' => $registrosBanco
            ], 200);
        } else{
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar o produto',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $registros = Produtos::find($id);

        if(!$registros){
            return response()->json([
                'success' => false,
                'message' => 'Produto não encontrado'
            ], 404);
        }

        if ($registros->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Produto deletado com sucesso'
            ], 200);
        }

        return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar um produto'
            ], 500);

    }
}
