<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArchivoController  
{
    /**
     * Obtener un listado de todos los archivos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $archivos = Archivo::all();
        return response()->json($archivos);
    }

    /**
     * Crear un nuevo archivo en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo' => 'required|string|max:255',
            'txt' => 'nullable|string', // Campo opcional
            'contenido' => 'nullable|string', // Campo opcional
            'empresa_id' => 'required|integer|exists:empresas,id', // Valida que la empresa exista
            'archivo' => 'nullable|file|max:4096|mimes:txt,pdf,doc,docx', // Validación de archivo (opcional)
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400); // Error de validación
        }

        $archivoData = $request->only('tipo', 'txt', 'contenido', 'empresa_id');

        // Guardar el archivo en el storage (por ejemplo, en la carpeta 'archivos')
        if ($request->hasFile('archivo')) {
            $fileName = $request->file('archivo')->getClientOriginalName();
            $filePath = $request->file('archivo')->storeAs('archivos', $fileName);
            $archivoData['ruta'] = $filePath; // Ruta del archivo guardado
        }

        
        $archivo = Archivo::create($archivoData);

        return response()->json($archivo, 201); // Código de estado 201 para creación
    }

    /**
     * Obtener un archivo específico por su ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $archivo = Archivo::find($id);
    
        if (!$archivo) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }
    
        if (!$archivo->ruta) {
            return response()->json(['error' => 'El archivo no tiene ruta de almacenamiento'], 404);
        }
    
        // Si se desea mostrar el contenido del archivo (por ejemplo, texto o PDF):
        if ($archivo->tipo === 'txt' || $archivo->tipo === 'pdf') {
            $file = Storage::get($archivo->ruta);
            return response($file, 200)->header('Content-Type', $archivo->tipo);
        } else {
            // Si no es un tipo de archivo compatible para mostrar, devolver información del archivo
            return response()->json($archivo);
        }
    }
    

    /**
     * Actualizar un archivo existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $archivo = Archivo::find($id);

        if (!$archivo) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'tipo' => 'nullable|string|max:255',
            'txt' => 'nullable|string', // Campo opcional
            'contenido' => 'nullable|string', // Campo opcional
            'empresa_id' => 'nullable|integer|exists:empresas,id', // Valida que la empresa exista
            'archivo' => 'nullable|file|max:4096|mimes:txt,pdf,doc,docx', // Validación de archivo (opcional)
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400); // Error de validación
        }

        $archivoData = $request->only('tipo', 'txt', 'contenido', 'empresa_id');
    }


    /**
     * Eliminar un archivo existente.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $archivo = Archivo::find($id);

        if (!$archivo) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        // Eliminar el archivo del almacenamiento (si existe)
        if ($archivo->ruta) {
            Storage::delete($archivo->ruta);
        }

        // Eliminar el registro del archivo en la base de datos
        $archivo->delete();

        return response()->json(['message' => 'Archivo eliminado'], 204); // Sin contenido
    }
}        
