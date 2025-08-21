<?php

namespace App\Http\Controllers;

use App\Http\Requests\Locacion\LocacionRequest;
use App\Http\Resources\LocacionResources;
use App\Http\Utilitis\RespuestasApi;
use App\Models\Locacion;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LocacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    

    public function cargarLocacion(LocacionRequest $request): JsonResponse
    {
        try{
            $validated = $request->validated();
            if($validated['is_default']){
                $locacion= Locacion::create($validated);
                $user = Auth::user();
                $user->default_location_id = $locacion->id;
                $user->save();
                return RespuestasApi::success(new LocacionResources($locacion), 'Locación guardada con éxito');
            }else{
                $validated = $request->validated();
                $locacion= Locacion::create([
                    'calle' => $validated['calle'],
                    'numero' => $validated['numero'],
                    'referencia' => $validated['referencia'],
                    'barrio' => $validated['barrio'],
                    'altitud' => $validated['altitud'],
                    'longitud' => $validated['longitud'],
                ]);
                return RespuestasApi::success(new LocacionResources($locacion), 'Locación guardada con éxito');
            }
            
        }catch (\Exception $e){
            return RespuestasApi::error($e->getMessage());
        }
    }
}
