<?php

namespace App\Http\Controllers;

use App\Models\Celda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CeldaController extends Controller
{
    // GET CELDAS
    public function index()
    {
        $celdas = Celda::all();
        return response()->json($celdas, 200);
    }

    //POST CELDAS
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'cantidad_animales' => 'integer|min:0',
            'nivel_peligrosidad' => 'in:bajo,medio,alto,muy_alto,extremo,critico',
            'alimento' => 'integer|min:0|max:100',
            'averias_pendientes' => 'integer|min:0',
            'nivel_seguridad' => 'in:bajo,medio,alto'
        ], [
            'nombre.required' => 'El nombre es obligatorio'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ],422);
        }

        $celda = Celda::create($request->all());

        return response()->json([
            'success' => true,

            'message' => 'Celda creada correctamente',
            'data' => $celda
        ],201);
    }

    //GET CELDA (id)
    public function show($id)
    {
        $celda = Celda::find($id);

        if(!$celda)
        {
            return response()->json([
                'success' => false,
                'message' => 'Celda no encontrada'
            ], 404);
        }

        return response()->json($celda, 200);
    }

    //UPDATE CELDA (id)
    public function update(Request $request, $id)
    {
        $celda = Celda::find($id);

        if(!$celda)
        {
            return response()->json([
                'success' => false,
                'message' => 'Celda no encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'cantidad_animales' => 'integer|min:0',
            'nivel_peligrosidad' => 'in:bajo,medio,alto,muy_alto,extremo,critico',
            'alimento' => 'integer|min:0|max:100',
            'averias_pendientes' => 'integer|min:0',
            'nivel_seguridad' => 'in:bajo,medio,alto'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $celda->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Celda actualizada correctamente',
            'data' => $celda
        ], 200);
    }

    //DELETE CELDA (id)
    public function destroy($id)
    {
        $celda = Celda::find($id);

        if(!$celda)
        {
            return response()->json([
                'success' => false,
                'message' => 'Celda no encontrada'
            ], 404);
        }

        $celda->delete();

        return response()->json([
            'success' => true,
            'message' => 'Celda eliminada correctamente'
        ], 200);
    }
    public function count()
    {
        return response()->json(['total' => \App\Models\Celda::count()]);
    }
}
