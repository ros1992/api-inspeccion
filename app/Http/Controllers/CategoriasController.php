<?php

namespace App\Http\Controllers;

use App\Models\categorias;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class CategoriasController extends Controller
{
    public function index()
    {
        return view('categorias.index');
    }

    public function create(Request $request)
    {
        $this->authorize('esAdministrador');

        $validated = $request->validate([
            'nombre' => 'required|string|max:60',
        ]);

        try {
            // creamos la categoria
            $categoria = new Categorias();
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
}
