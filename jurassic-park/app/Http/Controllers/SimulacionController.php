<?php

namespace App\Http\Controllers;

use App\Models\Celda;
use Illuminate\Http\Request;

class SimulacionController extends Controller
{
    public function simularNormal()
    {
        $celdas = Celda::all();

        if($celdas->isEmpty())
        {
            return response()->json([
                'success' => false,
                'message' => 'No hay celdas en el parque'
            ], 400);
        }

        $informe = [];

        foreach($celdas as $celda)
        {
            $alimentoAnterior = $celda->alimento;
            $averiasAnteriores = $celda->averias_pendientes;

            //se reduce alimento segun peligrosidad
            $reduccion = match($celda->nivel_peligrosidad){
                'critico' => rand(30, 50),
                'extremo' => rand(25, 40),
                'muy_alto' => rand(20, 35),
                'alto' => rand(15, 30),
                'medio' => rand(10, 20),
                'bajo' => rand(5, 15),
                default => rand(10, 20)
            };

            //el alimento no puede bajar de 0
            $celda->alimento = max(0, $celda->alimento - $reduccion);

            //generar averias segun nivel de seguridad y peligrosidad
            $probabilidadAveria = match($celda->nivel_seguridad){
                'bajo' => 80,
                'medio' => 50,
                'alto' => 20,
                default => 50
            };

            $nuevasAverias = 0;

            //a mas dinos mas probabilidad de averias
            $intentos = match($celda->nivel_peligrosidad){
                'critico' => 4,
                'extremo' => 3,
                'muy_alto' => 3,
                'alto' => 2,
                'medio' => 2,
                'bajo' => 1,
                default => 1
            };

            for($i = 0; $i < $intentos; $i++)
            {
                if(rand(1, 100) <= $probabilidadAveria)
                {
                    $nuevasAverias++;
                }
            }

            $celda->averias_pendientes += $nuevasAverias;
            $celda->save();

            //estado alerta de celda
            $alerta = 'normal';
            if ($celda->alimento <= 20 || $celda->averias_pendientes >= 3) {
                $alerta = 'critica';
            } elseif ($celda->alimento <= 50 || $celda->averias_pendientes >= 1) {
                $alerta = 'atencion';
            }

            $informe[] = [
                'id' => $celda->id,
                'nombre' => $celda->nombre,
                'nivel_peligrosidad' => $celda->nivel_peligrosidad,
                'nivel_seguridad' => $celda->nivel_seguridad,
                'alimento_anterior' => $alimentoAnterior,
                'alimento_actual' => $celda->alimento,
                'reduccion_alimento' => $reduccion,
                'averias_anteriores' => $averiasAnteriores,
                'averias_actuales' => $celda->averias_pendientes,
                'nuevas_averias' => $nuevasAverias,
                'alerta' => $alerta
            ];
        }

        $criticas = collect($informe)->where('alerta', 'critica')->count();
        $atencion = collect($informe)->where('alerta', 'atencion')->count();
        $normales = collect($informe)->where('alerta', 'normal')->count();

        return response()->json([
            'success' => true,
            'message' => 'Simulación completada',
            'resumen' => [
                'total_celdas' => count($informe),
                'celdas_criticas' => $criticas,
                'celdas_atencion' => $atencion,
                'celdas_normales' => $normales
            ],
            'informe' => $informe
        ], 200);
    }
}
