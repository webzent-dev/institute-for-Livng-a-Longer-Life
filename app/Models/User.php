<?php

namespace App\Models;

 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    
    use HasFactory, Notifiable;
 
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'role',
        'Specialty',
        'professional_credentials',
        'experience',
        'organization',
        'website',
        'collaborator_massge',
         'status',
        
    ];

     
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCollaborator()
    {
        return $this->role === 'collaborator';
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

     public function products()
    {
        return $this->hasMany(Product::class);
    }
}
