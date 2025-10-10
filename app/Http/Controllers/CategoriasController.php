<?php

namespace App\Http\Controllers;

use App\Models\categoria;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class CategoriasController extends Controller
{
    public function index()
    {
        $this->authorize('esAdministrador');

        try {
            // obtenemos todas las categorias
            $categorias = categoria::all();

            return response()->json([
                'categorias' => $categorias
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        $this->authorize('esAdministrador');

        $validated = $request->validate([
            'nombre' => 'required|string|max:60',
        ]);

        try {
            // creamos la categoria
            $categoria = new categoria();
            $categoria->nombre = $validated['nombre'];
            $categoria->fecha = Carbon::now(); // fecha actual con hora

            if ($categoria->save()) {
                return response()->json([
                    'mensaje' => 'Creado correctamente'
                ], Response::HTTP_CREATED);
            } else {
                return response()->json([
                    'mensaje' => 'Error al crear'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        $this->authorize('esAdministrador');

        $validated = $request->validate([
            'id' => 'required|integer|exists:categorias,id',
            'nombre' => 'required|string|max:60',
        ]);

        try {
            // creamos la categoria
            $categoria = categoria::find($validated['id']);
            $updated = $categoria->update([
                'nombre' => $validated['nombre'],
            ]);

            if ($updated) {
                return response()->json([
                    'mensaje' => 'Actualizado correctamente'
                ], Response::HTTP_CREATED);
            } else {
                return response()->json([
                    'mensaje' => 'Error al actualizar'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
