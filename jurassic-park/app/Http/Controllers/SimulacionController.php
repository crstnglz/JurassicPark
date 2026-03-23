<?php

namespace App\Http\Controllers;

use App\Models\Celda;
use App\Models\Dinosaurio;
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

    public function simularBrecha(Request $request)
    {
        if($request->celda_id)
        {
            $celda = Celda::with('dinosaurios')->find($request->celda_id);

            if(!$celda)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Celda no encontrada'
                ], 404);
            }
        }
        else
        {
            $celda = Celda::with('dinosaurios')->inRandomOrder()->first();
            if(!$celda)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay celdas en el parque'
                ], 400);
            }
        }

        $eventos = [];

        //nivel seguridad
        $probabilidadFuga = match($celda->nivel_seguridad)
        {
            'bajo' => 80,
            'medio' => 50,
            'alto' => 20,
            default => 50
        };

        //averías pendientes agravantes
        $probabilidadFuga += $celda->averias_pendientes * 10;
        $probabilidadFuga = min(100, $probabilidadFuga);

        //falta comida aumenta agresividad
        $dinosauriosAgresivos = false;
        if($celda->alimento <= 20)
        {
            $dinosauriosAgresivos = true;
            $probabilidadFuga += 15;
            $probabilidadFuga = min(100, $probabilidadFuga);
            $eventos[] = 'Falta crítica de alimento - dinosaurios muy agrsivos';
        }
        elseif($celda->alimento <= 50)
        {
            $eventos[] = 'Alimento bajo - dinosaurius nerviosos';
        }

        //calcular fuga
        $hayFuga = rand(1, 100) <= $probabilidadFuga;

        //dinosaurios carnivoros letales
        $carnivorosLetales = [];
        $bajasPersonal = 0;
        $dinosauriosHeridos = 0;

        if($hayFuga && $celda->dinosaurios->count() > 0)
        {
            foreach($celda->dinosaurios as $dino)
            {
                if($dino->dieta === 'carnivoro' && in_array($dino->nivel_peligrosidad, ['muy_alto', 'extremo', 'critico']))
                {
                    $carnivorosLetales[] = $dino->nick . '(' . $dino->raza . ')';

                    $dino->estado = 'fugado';
                    $dino->celda_id = null;
                    $dino->save();

                    if($dinosauriosAgresivos || $dino->nivel_peligrosidad === 'critico')
                    {
                        $bajasPersonal += rand(1, 3);
                        $dinosauriosHeridos += rand(0, 2);
                    }
                }

                if($hayFuga && $dinosauriosAgresivos && $dino->dieta !== 'carnivoro')
                {
                    if(rand(1, 100) <= 40)
                    {
                        $dino->estado = 'herido';
                        $dino->save();
                        $dinosauriosHeridos++;
                    }
                }
            }

            if(count($carnivorosLetales) > 0)
            {
                $eventos[] = 'Carnivoros letales escaparon: ' . implode(', ', $carnivorosLetales);
            }

            if($bajasPersonal > 0)
            {
                $eventos[] = '💀 ' . $bajasPersonal . ' miembro(s) del personl atacado(s)';
            }

            if($dinosauriosHeridos > 0)
            {
                $eventos[] = '🩸 ' . $dinosauriosHeridos . ' dinosaurio(s) herido(s) en el caos';
            }
        }

        //resultado
        if(!$hayFuga)
        {
            $resultado = 'contenida';
            $eventos[] = 'la brecha fue contenida con éxito';
        } elseif(count($carnivorosLetales) === 0)
        {
            $resultado = 'fuga_menor';
            $eventos[] = 'Fuga menor - sin carnivoros letales sueltos';
        }
        else
        {
            $resultado = 'catastrofe';
            $eventos[] = 'CATASTROFE - carnivoros letales sueltos en el parque';
        }

        //actualización de celdas
        if($hayFuga)
        {
            $celda->averias_pendientes += rand(1, 3);
            $celda->alimento = max(0, $celda->alimento - rand(10, 30));
            $celda->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Simulación de brecha completada',
            'informe' => [
                'celda' => [
                    'id' => $celda->id,
                    'nombre' => $celda->nombre,
                    'nivel_seguridad' => $celda->nivel_seguridad,
                    'nivel_peligrosidad' => $celda->nivel_peligrosidad,
                    'alimento' => $celda->alimento,
                    'averias_pendientes' => $celda->averias_pendientes
                ],
                'probabilidad_fuga' => $probabilidadFuga,
                'hay_fuga' => $hayFuga,
                'resultado' => $resultado,
                'carnivoros_letales' => $carnivorosLetales,
                'bajas_personal' => $bajasPersonal,
                'dinosaurios_heridos' => $dinosauriosHeridos,
                'dinosaurios_agresivos' => $dinosauriosAgresivos,
                'total_dinosaurios' => $celda->dinosaurios->count(),
                'eventos' => $eventos
            ]
        ], 200);
    }
}
