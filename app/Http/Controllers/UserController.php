<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 10;
        $users =  User::query()->paginate($pageSize);
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     * @return UserResource
     */
    public function store(Request $request)
    {
        $createdUser = User::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return new UserResource($createdUser);
    }

    /**
     * Display the specified resource.
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     * @return UserResource | JsonResponse
     */
    public function update(Request $request, User $user)
    {
        $updated = $user->update([
            "name" => $request->name ?? $user->name,
            "email" => $request->email ?? $user->email,
            "password" => Hash::make($request->password) ?? $user->password
        ]);
        if (!$updated) {
            return new JsonResponse([
                'errors' => [
                    "failed to update user"
                ]
            ], 400);
        }
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        $deleted = $user->forceDelete();
        if (!$deleted) {
            return new JsonResponse([
                "errors" => [
                    "failed to delete user"
                ]
            ], 400);
        }
        return new JsonResponse([
            "data" => "user is successfully deleted"
        ]);
    }
}
