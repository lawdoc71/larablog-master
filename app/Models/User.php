<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\UserType;
use App\UserStatus;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'picture',
        'bio',
        'type',
        'status'
    ];

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
    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class,
            'type'=>UserType::class,
        ];
    }

    public function getPictureAttribute($value){
        return $value ? asset('/images/users/'.$value) : asset('/images/users/mike-avatar.png');
    }

    // user relation to social links
    public function social_links(){
        return $this->belongsTo(UserSocialLink::class,'id','user_id');
    }

    // accessor
    public function getTypeAttribute($value){
        return $value;
    }

    public function posts(){
        return $this->hasMany(Post::class,'author_id','id');
    }

}
