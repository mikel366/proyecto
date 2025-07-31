<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Http\Utilitis\RespuestasApi;
use App\Models\Role;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $roles =(Role::all()->isEmpty()) ? 'Tabla vacia' : RoleResource::collection(Role::all());
        return RespuestasApi::success($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $role = Role::create($validated);
        $role = new RoleResource($role);

        return RespuestasApi::success($role);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $role = Role::findOrFail($id);
        $role = new RoleResource($role);
        return RespuestasApi::success($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id): JsonResponse
    {
        $role = Role::findOrFail($id);
        $role->update($request->validated());
        $role = new RoleResource($role);
        return RespuestasApi::success($role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return RespuestasApi::success(null, 'Rol eliminado correctamente');
    }
}
