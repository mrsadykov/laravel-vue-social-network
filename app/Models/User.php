<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasLog;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    // многие-через-отношение - чаты (user - profile - chats)
    public function chats(): HasManyThrough
    {
        return $this->hasManyThrough(Chat::class, Profile::class);
    }

    // многие-через-отношение - комментарии (user - profile - comments)
    public function comments(): HasManyThrough
    {
        return $this->hasManyThrough(Comment::class, Profile::class);
    }

    // многие-через-отношение - сообщения (user - profile - messages)
    public function messages(): HasManyThrough
    {
        return $this->hasManyThrough(Message::class, Profile::class);
    }

    // многие-через-отношение - статьи (user - profile - posts)
    public function posts(): HasManyThrough
    {
        return $this->hasManyThrough(Post::class, Profile::class)->latest();
    }

    /*protected static function booted()
    {
        static::created(function(User $user) {
            //dd($user);
            $user->profile()->create([ 'login' => $user->email ]);
        });
    }*/

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function getIsAdminAttribute(): bool
    {
        return $this->roles->contains('title', 'admin');
    }

    public function getIsModeratorPostsAttribute(): bool
    {
        return $this->roles->contains('title', 'moderator_posts');
    }

    public function getIsModeratorVideosAttribute(): bool
    {
        return $this->roles->contains('title', 'moderator_videos');
    }

    //public function permissions()
    //{
        //return $this->roles()->leftJoin('permission_role', 'roles.id', '=', 'permission_role.role_id');
    //}

    // связь через - комментарии постов
    /*public function permissions(): HasManyThrough
    {
        return $this->hasManyThrough(Permission::class, Role::class);
    }*/

    public function permissions(): array
    {
        return DB::table('permission_role')
            ->leftJoin('permissions', 'permissions.id', '=', 'permission_role.permission_id')
            ->select('permissions.id', 'permissions.title')
            ->where('permission_role.role_id', $this->roles->pluck('id')->toArray())
            ->get()
            ->pluck('title')
            ->toArray();
    }
}
