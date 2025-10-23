<?php

namespace App\Http\Controllers;

use App\Models\Inspecciones;
use App\Models\Resultados_inspeccion;
use App\Models\Actividad;
use App\Models\Categoria;
use App\Models\Equipo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Illuminate\Http\Response;


class InspeccionController extends Controller
{
    public function index()
    {
        Gate::authorize('esAdministradorOsupervisor');

        try {
            $inspecciones = Inspecciones::select('id_inspeccion', 'id_user', 'id_equipo', 'fecha_inspeccion', 'periodo_desde', 'periodo_hasta', 'observaciones', 'firma_conductor', 'firma_responsable_sst', 'fecha')->get();
            $resultados = Resultados_inspeccion::select('id_resultado', 'id_inspeccion', 'id_actividad', 'dia_semana', 'turno', 'valor_respuesta', 'observacion_item', 'fecha')->get();
            $actividades = Actividad::select('id_actividad', 'name', 'id_categoria', 'fecha')->get();
            $categorias = Categoria::select('id_categoria', 'nombre')->get();
            $equipos = Equipo::select('id_equipo', 'tipo_equipo', 'marca', 'modelo', 'area_asignada')->get();
            $usuarios = User::select('id', 'name', 'email')->get();

            $resultado = $inspecciones->map(function ($inspeccion) use ($resultados, $actividades, $categorias, $equipos, $usuarios) {

                $equipo = $equipos->firstWhere('id_equipo', $inspeccion->id_equipo);
                $usuario = $usuarios->firstWhere('id', $inspeccion->id_user);

                return [
                    'id' => $inspeccion->id_inspeccion,
                    'id_user' => $inspeccion->id_user,
                    'usuario' => $usuario->name ?? 'Sin asignar',
                    'id_equipo' => $inspeccion->id_equipo,
                    'tipo_equipo' => $equipo->tipo_equipo ?? '',
                    'marca' => $equipo->marca ?? '',
                    'modelo' => $equipo->modelo ?? '',
                    'area_asignada' => $equipo->area_asignada ?? '',
                    'fecha_inspeccion' => $inspeccion->fecha_inspeccion,
                    'periodo_desde' => $inspeccion->periodo_desde,
                    'periodo_hasta' => $inspeccion->periodo_hasta,
                    'observaciones' => $inspeccion->observaciones,
                    'firma_conductor' => $inspeccion->firma_conductor,
                    'firma_responsable_sst' => $inspeccion->firma_responsable_sst,
                    'fecha' => $inspeccion->fecha,
                    'resultados' => $resultados->where('id_inspeccion', $inspeccion->id_inspeccion)->values(),
                ];
            });

            return response()->json([
                'inspeccion' => $resultado
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener las inspecciones: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function store(Request $request)
    {
        // Validar que el usuario tenga permiso para ver equipos
        Gate::authorize('esAdministradorOsupervisor');

        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_equipo' => 'required|exists:equipos,id_equipo',
            'fecha_inspeccion' => 'required|date',
            'periodo_desde' => 'required|date',
            'periodo_hasta' => 'required|date',
            'observaciones' => 'nullable|string',
            'firma_conductor' => 'nullable|string',
            'firma_responsable_sst' => 'nullable|string',
            'resultados' => 'required|array',
            'resultados.*.id_actividad' => 'required|exists:actividades,id_actividad',
            'resultados.*.dia_semana' => 'required|string',
            'resultados.*.turno' => 'required|string',
            'resultados.*.valor_respuesta' => 'nullable|string',
            'resultados.*.observacion_item' => 'nullable|string',

        ]);

        //Usar transacción para manejar errores
        return DB::transaction(function () use ($request) {
            try {
                // Creamos la inspección
                $inspeccon = new Inspecciones();
                $inspeccon->id_user = $request->id_user;
                $inspeccon->id_equipo = $request->id_equipo;
                $inspeccon->fecha_inspeccion = $request->fecha_inspeccion;
                $inspeccon->periodo_desde = $request->periodo_desde;
                $inspeccon->periodo_hasta = $request->periodo_hasta;
                $inspeccon->observaciones = $request->observaciones;
                $inspeccon->firma_conductor = $request->firma_conductor;
                $inspeccon->firma_responsable_sst = $request->firma_responsable_sst;
                $inspeccon->fecha = Carbon::now();
                $inspeccon->save();

                // Creamos los resultados de la inspeccion.
                foreach ($request->resultados as $resultado) {
                    $resultados_inspeccion = new Resultados_inspeccion();
                    $resultados_inspeccion->id_inspeccion = $inspeccon->id_inspeccion;
                    $resultados_inspeccion->id_actividad = $resultado['id_actividad'];
                    $resultados_inspeccion->dia_semana = $resultado['dia_semana'];
                    $resultados_inspeccion->turno = $resultado['turno'];
                    $resultados_inspeccion->valor_respuesta = $resultado['valor_respuesta'];
                    $resultados_inspeccion->observacion_item = $resultado['observacion_item'];
                    $resultados_inspeccion->fecha = Carbon::now();
                    $resultados_inspeccion->save();
                }
                return response()->json([
                    'message' => 'Inspeccion creada correctamente'
                ], Response::HTTP_CREATED);

            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Error al crear la inspección: ' . $e->getMessage()
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });
    }

    public function update(Request $request)
    {
        // Validar que el usuario tenga permiso para ver equipos
        Gate::authorize('esAdministradorOsupervisor');

        $request->validate([
            'id' => 'required|exists:inspecciones,id_inspeccion',
            'id_user' => 'required|exists:users,id',
            'id_equipo' => 'required|exists:equipos,id_equipo',
            'fecha_inspeccion' => 'required|date',
            'periodo_desde' => 'required|date',
            'periodo_hasta' => 'required|date',
            'observaciones' => 'nullable|string',
            'firma_conductor' => 'nullable|string',
            'firma_responsable_sst' => 'nullable|string',
            'resultados' => 'required|array',
            'resultado.*.id_resultado' => 'required|exists:resultados_inspeccion,id_resultado',
            'resultados.*.id_actividad' => 'required|exists:actividades,id_actividad',
            'resultados.*.dia_semana' => 'required|string',
            'resultados.*.turno' => 'required|string',
            'resultados.*.valor_respuesta' => 'nullable|string',
            'resultados.*.observacion_item' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($request) {
            try {
                $inspeccion = Inspecciones::find($request->id);
                $update1 = $inspeccion->update([
                    'id_user' => $request->id_user,
                    'id_equipo' => $request->id_equipo,
                    'fecha_inspeccion' => $request->fecha_inspeccion,
                    'periodo_desde' => $request->periodo_desde,
                    'periodo_hasta' => $request->periodo_hasta,
                    'observaciones' => $request->observaciones,
                    'firma_conductor' => $request->firma_conductor,
                    'firma_responsable_sst' => $request->firma_responsable_sst,
                    'fecha' => Carbon::now(),
                ]);

                foreach ($request->resultados as $resultado) {
                    $resultados_inspeccion = Resultados_inspeccion::find($resultado['id_resultado']);
                    $update2 = $resultados_inspeccion->update([
                        'id_actividad' => $resultado['id_actividad'],
                        'dia_semana' => $resultado['dia_semana'],
                        'turno' => $resultado['turno'],
                        'valor_respuesta' => $resultado['valor_respuesta'],
                        'observacion_item' => $resultado['observacion_item'],
                        'fecha' => Carbon::now(),
                    ]);
                }

                if ($update1 && $update2){
                    return response()->json([
                        'message' => 'Inspección actualizada correctamente'
                    ], Response::HTTP_OK);
                }else{
                    return response()->json([
                        'message' => 'Error al actualizar la inspección'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Error al actualizar la inspección: ' . $e->getMessage()
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });
    }


}
