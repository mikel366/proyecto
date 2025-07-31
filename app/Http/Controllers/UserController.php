<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Utilitis\RespuestasApi;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = (User::all()->isEmpty()) ? 'Tabla users vacia' : UserResource::collection(User::all());
        return RespuestasApi::success($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $user = User::findOrFail($id);
        return RespuestasApi::success($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();
        return RespuestasApi::success(null, 'User eliminado exitosamente');
    }
}
