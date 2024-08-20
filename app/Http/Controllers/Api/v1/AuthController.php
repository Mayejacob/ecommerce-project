<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\SignInRequest;
use App\Http\Requests\Auth\SignUpRequest;
use App\Interfaces\AuthRepositoryInterface;
use App\Http\Controllers\Api\BaseController;

class AuthController extends BaseController
{
    private AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * @OA\Post(
     *     path="/v1/auth/login",
     *     summary="User Sign In",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User signed in successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User signed in"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="token-string"),
     *                 @OA\Property(property="name", type="string", example="John Doe")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid username or password",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Invalid username or password."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="error", type="string", example="Invalid username or password")
     *             )
     *         )
     *     )
     * )
     */
    public function signin(SignInRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            $success['token'] =  $authUser->createToken('admin-token', ['create', 'read', 'update', 'delete'])->plainTextToken;
            $success['name'] =  $authUser->name;

            return $this->sendResponse($success, 'User signed in');
        } else {
            return $this->sendError('Invalid username or password.', ['error' => 'Invalid username or password'], 401);
        }
    }
   
    /**
     * @OA\Post(
     *     path="/v1/auth/register",
     *     summary="User Sign Up",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "confirmPassword"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="confirmPassword", type="string", format="password", example="password123")
     *         ),
     *     ),
     * @OA\Response(
     *         response=200,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User created successfully."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="token-string"),
     *                 @OA\Property(property="user", ref="#/components/schemas/UserResource")
     *             )
     *         )
     *     )
     * )
     */
    public function signup(SignUpRequest $request)
    {
        $user = User::create($request->all());

        $success['token'] =  $user->createToken('admin-token', ['create', 'read', 'update', 'delete'])->plainTextToken;
        $success['user'] =  new UserResource($user);

        return $this->sendResponse($success, 'User created successfully.');
    }

}
