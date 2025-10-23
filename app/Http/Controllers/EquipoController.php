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
                $equipos33 = Equipo::all();
                return response()->json([
                    'mensaje' => 'Creado correctamente',
                    'otra'=> $equipos33

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
    public function update(Request $request) {
        $this->authorize('esAdministrador');

        $validated = $request->validate([
            'id_equipo' => 'required|integer|exists:equipos,id_equipo',
            'tipo_equipo' => 'required|string|max:60',
            'marca' => 'required|string|max:60',
            'modelo' => 'required|string|max:60',
            'area_asignada' => 'required|string|max:60',
        ]);

        try {
            $equipo = Equipo::find($validated['id_equipo']);
            $equipo->tipo_equipo = $validated['tipo_equipo'];
            $equipo->marca = $validated['marca'];
            $equipo->modelo = $validated['modelo'];
            $equipo->area_asignada = $validated['area_asignada'];
            $equipo->fecha = Carbon::now(); // fecha actual con hora

            if ($equipo->save()) {
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
                'mensaje' => 'Error al actualizar'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
