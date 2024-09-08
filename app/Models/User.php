<?php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;


use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable ,SoftDeletes;
    /**
     ** Since role is not in $fillable:
     *  *it cannot be mass-assigned using methods like create() or update() directly.
     ** Since role is not in $guarded:
        *it's still a normal attribute that can be set manually, but it’s simply not included in mass-assignment operations.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email','password'];
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
         return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the 
    *JWT.
    *
    * @return array
    */
    public function getJWTCustomClaims()
    {
         return [];
    }

    /**
     * one to many relation
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class,'assigned_to');
    }
}