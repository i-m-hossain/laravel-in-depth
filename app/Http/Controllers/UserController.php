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
     * @queryParam page_size int Size per page. defaults to 10. Example: 10 
     * @queryParam page int page to view. defaults to 1. Example: 1
     * 
     * @apiResourceCollection App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
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
     * @bodyParam name string required Name of the user. Example: John Doe
     * @bodyParam email string required User Email. Example: johndoe@example.com
     * @bodyParam password string required password. 
     * @apiResourceCollection App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
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
     * 
     * @urlParam id int required User Id. Example: 1
     * @apiResourceCollection App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     * @bodyParam name string required Name of the user. Example: John Doe
     * @bodyParam email string required User Email. Example: johndoe@example.com
     * @bodyParam password string required password. 
     * @apiResourceCollection App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
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
     * @response 200 {
     *  "data": "success"
     * }
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
