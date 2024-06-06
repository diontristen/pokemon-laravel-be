<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Classes\ApiResponseClass;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function register(StoreUserRequest $request)
    {
        $details = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
        ];

        try {
            $details['password'] = Hash::make($request->password);
            $user = $this->userRepository->create($details);
            return ApiResponseClass::sendResponse(new UserResource($user), 'User created successfully');
        } catch (\Exception $ex) {
            return ApiResponseClass::throw($ex);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = [
                'username' => $request->username,
                'password' => $request->password
            ];
            $user = User::where('username', $credentials['username'])->first();
            if (Auth::attempt($credentials)) {
                /** @var \App\Models\User $user **/
                $user = Auth::user();
                if ($user) {
                    $token = $user->createToken($user->username)->accessToken;
                    return ApiResponseClass::sendResponse(['token' => $token], 'User successfully login!', 201);
                }
            }
            return ApiResponseClass::processError(['error' => 'Email or password is incorrect'], 'Login failed!', 401);
        } catch (\Exception $ex) {
            dd($ex);
            return ApiResponseClass::throw($ex);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();

        $request->user()->token()->revoke();

        return ApiResponseClass::sendResponse([], 'Successfully logged out');
    }

    public function getUser(Request $request)
    {
        $user = Auth::guard('api')->user();
        $userDetails = $this->userRepository->getUserDetails($user->id);
        return ApiResponseClass::sendResponse(new UserResource($userDetails), 'User details retrieved successfully');
    }
}
