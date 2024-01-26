<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApiToken extends Model
{
    use HasFactory;

    // only created_at column
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['access_token', 'expires_in'];

    /**
     * Get not expired latest token.
     *
     * @return self|null
     */
    public static function getValidToken(): ?self
    {
        return self::whereDate(
            'expires_in',
            '>',
            Carbon::now()->format('Y-m-d H:i:s')
        )->latest()->first();
    }
}
