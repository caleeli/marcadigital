<?php

namespace App;

use App\Traits\HasMenus;
use App\Traits\ModelValidation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasMenus;
    use Notifiable;
    use ModelValidation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'role', 'provider', 'provider_id',
    ];

    protected $attributes = [
        'role' => 'admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'avatar' => 'array',
    ];

    public function __construct(array $attributes = [])
    {
        if (!isset($attributes['id'])) {
            $attributes['id'] = \intval(\microtime(true) * 2000000) + \rand(0, 999);
        }
        parent::__construct($attributes);
    }

    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function roleObject()
    {
        return $this->belongsTo(Role::class, 'role', 'role');
    }

    public function validation()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
        ];
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }
}
