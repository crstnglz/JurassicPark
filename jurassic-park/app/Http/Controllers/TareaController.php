<?php

namespace App\Http\Controllers;

use App\Events\TareaAsignada;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TareaController extends Controller
{
    //GET TAREAS
    public function index(Request $request)
    {
        $user = auth()->user();

        if($user->role === 'admin')
        {
            $tareas = Tarea::with(['usuario', 'celda'])->get();
        }
        else
        {
            $tareas = Tarea::with(['usuario', 'celda'])
                -> where('user_id', $user->id)
                ->get();
        }

        return response()->json($tareas, 200);
    }

    //POST TAREAS
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'celda_id' => 'required|exists:celdas,id',
            'tipo' => 'required|in:veterinario,mantenimiento',
            'descripcion' => 'nullable|string|max:255'
        ], [
            'user_id.required' => 'El trabajador es obligatorio',
            'user_id.exists' => 'El trabajador no existe',
            'celda_id.required' => 'La celda es obligatoria',
            'celda_id.exists' => 'La celda no existe',
            'tipo.required' => 'El tipo de tarea es obligatorio'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $tarea = Tarea::create([
            'user_id' => $request->user_id,
            'celda_id' => $request->celda_id,
            'tipo' => $request->tipo,
            'estado' => 'pendiente',
            'descripcion' => $request->descripcion
        ]);

        event(new TareaAsignada(($tarea->load(['usuario', 'celda']))));

        return response()->json([
            'success' => true,
            'message' => 'Tarea asignada correctamente',
            'data' => $tarea->load(['usuario', 'celda'])
        ], 201);
    }

    //UPDATE TAREAS (ID) - ESTADO
    public function cambiarEstado(Request $request, $id)
    {
        $tarea = Tarea::find($id);

        if(!$tarea)
        {
            return response()->json([
                'success' => false,
                'message' => 'Tarea no encontrada'
            ], 404);
        }

        $user = auth()->user();

        //trabajador asignado o admin pueden cambiar el estado
        if($user->role !== 'admin' && $tarea->user_id !== $user->id)
        {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para modificar esta tarea'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'estado' => 'required|in:pendiente,en_progreso,completada'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $tarea->estado = $request->estado;
        $tarea->save();

        //al completar se restaura según tipo tarea
        if($request->estado === 'completada')
        {
            $celda = $tarea->celda;

            if($tarea->tipo === 'veterinario')
            {
                $celda->alimento = 100;
                $celda->save();
            }

            elseif($tarea->tipo === 'mantenimiento')
            {
                $celda->averias_pendientes = max(0, $celda->averias_pendientes - 1);
                $celda->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente',
            'data' => $tarea->load(['usuario', 'celda'])
        ], 200);
    }

    //DELETE TAREAS (id)
    public function destroy($id)
    {
        $tarea = Tarea::find($id);

        if(!$tarea)
        {
            return response()->json([
                'success' => false,
                'message' => 'Tarea no encontrada'
            ], 404);
        }

        $tarea->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tarea eliminada correctamente'
        ], 200);
    }
}
