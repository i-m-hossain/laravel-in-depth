<?php

namespace App\Http\Controllers;


use App\Events\Models\User\UserCreated;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
/**

 * @group User management
 * 
 * Api's to manage the user resource
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @queryParam page_size int Size per page. defaults to 10 example:20
     * @queryParam page int defaults to 20 example:
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        // event(new UserCreated(User::factory()->make()));
        $page_size = $request->page_size ?? 10;
        $users =  User::query()->paginate($page_size);
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     * @return UserResource
     */
    public function store(Request $request, UserRepository $userRepository)
    {
        $createdUser = $userRepository->create($request->only([
            "name", "email", "password"
        ]));
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
    public function update(Request $request, User $user, UserRepository $userRepository)
    {
        $updatedUser = $userRepository->update($user, $request->only([
            "name", "email", "password"
        ]));
        return new UserResource($updatedUser);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy(User $user, UserRepository $userRepository)
    {
        $userRepository->forceDelete($user);
        return new JsonResponse([
            "data" => "user is successfully deleted"
        ]);
    }
}
