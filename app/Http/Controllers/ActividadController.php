<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class ActividadController extends Controller
{
    public function index(Request $request) {
        $this->authorize('esAdministrador');

        try {
            $actividades = Actividad::select('id_actividad', 'name', 'id_categoria', 'fecha')->get();
            $categorias = Categoria::select('id_categoria', 'nombre')->get();

            $resultado = $categorias->map(function ($categoria) use ($actividades) {
                return [
                    'id' => $categoria->id_categoria,
                    'nombre' => $categoria->nombre,
                    'actividades' => $actividades->where('id_categoria', $categoria->id_categoria)->values(),
                ];
            });

            return response()->json([
                'actividades' => $resultado
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
            'name' => 'required|string|max:60',
            'id' => 'required|integer'
        ]);

        try {
           $actividad = new Actividad();
           $actividad->name = $validated['name'];
           $actividad->id_categoria = $validated['id'];
           $actividad->fecha = Carbon::now();

           if ($actividad->save()) {
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
            'id' => 'required|integer|exists:actividades,id_actividad',
            'name' => 'required|string|max:60',
            'id_categoria' => 'required|integer'
        ]);

        try {
            $actividad = Actividad::find($validated['id']);

            $updated = $actividad->update([
                'name' => $validated['name'],
                'id_categoria' => $validated['id_categoria']
            ]);

            if ($updated) {
                return response()->json([
                    'mensaje' => 'Actualizado correctamente'
                ], Response::HTTP_OK);
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
