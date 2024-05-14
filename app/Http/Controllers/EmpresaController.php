<?php

namespace App\Http\Controllers;


use App\Models\Empresa;
use Illuminate\Http\Request;


class EmpresaController  
{
    /**
     * Obtiene un listado de las empresas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = Empresa::all();
        return response()->json($empresas);
    }

    /**
     * Crea una nueva empresa en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datosValidados = $request->validate([
            'ruc' => 'required|unique:empresas',
            'nombre' => 'required',
            'ciudad' => 'required',
            'provincia' => 'required',
            'direccion' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $empresa = Empresa::create($datosValidados);
        return response()->json($empresa, 201);
    }

    /**
     * Obtiene una empresa específica por su identificador.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empresa = Empresa::find($id);
        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        return response()->json($empresa);
    }

    /**
     * Actualiza una empresa existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $empresa = Empresa::find($id);
        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        $datosValidados = $request->validate([
            'ruc' => 'required|unique:empresas,id,' . $empresa->id,
            'nombre' => 'required',
            'ciudad' => 'required',
            'provincia' => 'required',
            'direccion' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $empresa->update($datosValidados);
        return response()->json($empresa);
    }

    /**
     * Elimina una empresa de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empresa = Empresa::find($id);
        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        $empresa->delete();
        return response()->json([], 204);
    }
}

