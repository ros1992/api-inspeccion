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
            $actividades = Actividad::select('id', 'name', 'categoria_id', 'fecha')->get();
            $categorias = Categoria::select('id', 'nombre')->get();

            $resultado = $categorias->map(function ($categoria) use ($actividades) {
                return [
                    'id' => $categoria->id,
                    'nombre' => $categoria->nombre,
                    'actividades' => $actividades->where('categoria_id', $categoria->id)->values(),
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
            'categoria_id' => 'required|integer'
        ]);

        try {
           $actividad = new Actividad();
           $actividad->name = $validated['name'];
           $actividad->categoria_id = $validated['categoria_id'];
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
            'id' => 'required|integer|exists:actividades,id',
            'name' => 'required|string|max:60',
            'categoria_id' => 'required|integer'
        ]);

        try {
            $actividad = Actividad::find($validated['id']);

            $updated = $actividad->update([
                'name' => $validated['name'],
                'categoria_id' => $validated['categoria_id']
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
