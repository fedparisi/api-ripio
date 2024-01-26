<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginAuthRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyHttpResponse;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginAuthRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (!$token = auth('api')->attempt($credentials)) {
            return $this->invalidCredentials();
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(): JsonResponse
    {
        return response()->apiRipio(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth('api')->logout();

        return $this->loggedOut();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Return json response with unauthorized status code.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidCredentials(): JsonResponse
    {
        return response()->apiRipio(
            null,
            SymfonyHttpResponse::HTTP_UNAUTHORIZED,
            "Invalid credentials"
        );
    }

    /**
     * Returns json response with a logged out message.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function loggedOut(): JsonResponse
    {
        return response()->apiRipio(
            null,
            SymfonyHttpResponse::HTTP_OK,
            'Successfully logged out'
        );
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        $expiresIn = auth('api')->factory()->getTTL() * 60;

        return response()->apiRipio(
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $expiresIn,
                'expires_at' => Carbon::now()
                    ->addSeconds($expiresIn)
                    ->toDateTimeString(),
            ],
            SymfonyHttpResponse::HTTP_CREATED
        );
    }
}
