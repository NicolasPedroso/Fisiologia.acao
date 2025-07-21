<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Fase;

/**
 * @OA\Schema(
 *     title="User",
 *     type="object"
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * @OA\Property(
     *     example="1",
     *     format="integer",
     *     type="integer"
     * )
     *
     */
    private $id;

    /**
     * @OA\Property(
     *     example="admin@ecomp.co",
     *     format="string",
     *     type="string"
     * )
     *
     */
    private $email;

    /**
     * @OA\Property(
     *     example="secret",
     *     format="string",
     *     type="string"
     * )
     *
     */
    private $password;

    /**
     * @OA\Property(
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     */
    private $created_at;

    /**
     * @OA\Property(
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     */
    private $updated_at;

    /**
     * Propriedades visíveis.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'image',
        'phone',
        'admin'
    ];

    /**
     * Propriedades escondidas.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function fases() {
        return $this->belongsToMany(Fase::class, 'fase_user')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}
