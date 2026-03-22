<?php

namespace App\Http\Controllers;

use App\Models\Dinosaurio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DinosaurioController extends Controller
{
    //GET DINOS
    public function index()
    {
        $dinosaurios = Dinosaurio::with('celda')->get();
        return response()->json($dinosaurios, 200);
    }

    //POST DINO
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nick' => 'required|string|max:255',
            'raza' => 'required|string',
            'edad' => 'required|integer|min:0',
            'nivel_peligrosidad' => 'required|in:bajo,medio,alto,muy_alto,extremo,critico',
            'dieta' => 'required|in:herbivoro,omnivoro,carnivoro',
            'celda_id' => 'nullable|exists:celdas, id'
        ], [
            'nick.required' => 'El nick es obligatorio',
            'raza.required' => 'La raza es obligatoria',
            'edad.required' => 'La edad es obligatoria',
            'nivel_peligrosidad.required' => 'El nivel de peligrosidad es obligatoria',
            'dieta.required' => 'La dieta es obligatoria',
            'celda_id.exists' => 'La celda no existe'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $dinosaurio = Dinosaurio::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Dinosaurio creado correctamente',
            'data' => $dinosaurio
        ], 201);
    }

    //GET DINO (id)
    public function show($id)
    {
        $dinosaurio = Dinosaurio::with('celda')->find($id);

        if(!$dinosaurio)
        {
            return response()->json([
                'success' => false,
                'message' => 'Dinosaurio no encontrado'
            ], 404);
        }

        return response()->json($dinosaurio, 200);
    }

    //UPDATE DINO (id)
    public function update(Request $request, $id)
    {
        $dinosaurio = Dinosaurio::find($id);

        if(!$dinosaurio)
        {
            return response()->json([
                'success' => false,
                'message' => 'Dinosaurio no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nick' => 'string|max:255',
            'raza' => 'string',
            'edad' => 'integer|min:0',
            'nivel_peligrosidad' => 'in:bajo,medio,alto,muy_alto,extremo,critico',
            'dieta' => 'in:herbivoro,omnivoro,carnivoro',
            'celda_id' => 'nullable|exists:celdas,id'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $dinosaurio->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Dinosaurio actualizado correctamente'
        ], 200);
    }

    //DELETE DINO (id)
    public function destroy($id)
    {
        $dinosaurio = Dinosaurio::find($id);

        if(!$dinosaurio)
        {
            return response()->json([
                'success' => false,
                'message' => 'Dinosaruio no encontrado'
            ], 404);
        }

        $dinosaurio->delete();

        return response()->json([
            'success' => true,
            'message' => 'Dinosaurio eliminado correctamente'
        ], 200);
    }

    //ASIGNAR DINO (id)
    public function asignar(Request $request, $id)
    {
        $dinosaurio = Dinosaurio::find($id);

        if(!$dinosaurio)
        {
            return response()->json([
                'success' => false,
                'message' => 'Dinosaruio no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'celda_id' => 'nullable|exists:celdas,id'
        ], [
            'celda_id.exists' => 'La celda no existe'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $dinosaurio->celda_id = $request->celda_id;
        $dinosaurio->save();

        $mensaje = $request->celda_id
            ? 'Dinosaurio asignado a la celda correctamente'
            : 'Dinosaurio desasignado de la celda';

        return response()->json([
            'success' => true,
            'message' => $mensaje,
            'data' => $dinosaurio->load('celda')
        ], 200);
    }

    public function count()
    {
        return response()->json(['total' => \App\Models\Dinosaurio::count()]);
    }
}
