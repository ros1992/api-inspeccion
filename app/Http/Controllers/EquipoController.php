<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Equipo;
use Carbon\Carbon;


class EquipoController extends Controller
{
    public function index() {
        $this->authorize('esAdministrador');

        try {
            $equipos = Equipo::all();
            return response()->json([
                'equipos' => $equipos
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request) {
        $this->authorize('esAdministrador');

        $validated = $request->validate([
            'tipo_equipo' => 'required|string|max:60',
            'marca' => 'required|string|max:60',
            'modelo' => 'required|string|max:60',
            'area_asignada' => 'required|string|max:60',
        ]);

        try {
            $equipo = new Equipo();
            $equipo->tipo_equipo = $validated['tipo_equipo'];
            $equipo->marca = $validated['marca'];
            $equipo->modelo = $validated['modelo'];
            $equipo->area_asignada = $validated['area_asignada'];
            $equipo->fecha = Carbon::now(); // fecha actual con hora

            if ($equipo->save()) {
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
                'mensaje' => 'Error al crear'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
