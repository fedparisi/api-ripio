<?php

namespace App\Providers;

use App\Models\User;
use Throwable;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

class JWTUserProvider extends ServiceProvider implements UserProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed  $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        throw new Throwable('Method not implemented.');
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        throw new Throwable('Method not implemented.');
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        return $this->getUser($identifier);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        return $this->getUserByCredentials($credentials);
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return $user->username === $credentials['username'] &&
            Hash::check($credentials['password'], $user->getAuthPassword());
    }

    /**
     * Get the User instance used by the authentication process.
     *
     * @param  array  $credentials
     * @return User|null
     */
    private function getUserByCredentials(array $credentials): ?User
    {
        $username = $credentials['username'] ?? null;
        $password = $credentials['password'] ?? null;

        if (empty(trim($username)) || empty(trim($password))) {
            return null;
        }

        return $this->getUser();
    }

    /**
     * Get the User instance with a custom id.
     *
     * @param  string|int  $id
     * @return User
     */
    private function getUser(string|int $id = 0): User
    {
        return tap(new User(), function ($user) use ($id) {
            // The id attribute value will be the subject claim in the JWT token
            $user->id = $id;
            $user->username = env('JWT_USERNAME');
        });
    }
}
