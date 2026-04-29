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
        'profile_image',
        'password',
        'role',
        'speciality',
        'professional_credentials',
        'experience',
        'organization',
        'website',
        'collaborator_message',
        'plan_id',
        'plan_name',
        'plan_price',
        'plan_period',
        'plan_expiry',
        'status'
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

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    /*public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        });
    }*/

    /**
     * Deletes a user by its ID.
     * 
     * @param int $id The user ID to delete.
     * @param array $data The data to delete.
     * 
     * @return int 1 if the user is deleted successfully, 0 otherwise.
     */
    public static function deleteUserByID(int $id=null,$data=[])
    {
        $userDetail = User::where('id', $id)->delete();
        if ($userDetail) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Updates a user by its ID.
     *
     * @param int $id The user ID to update.
     * @param array $data The data to update.
     *
     * @return int 1 if the user is updated successfully, 0 otherwise.
    */
    public static function updateUserByID(int $id=null,$data=[])
    {
        $userDetail = User::where('id', $id)
        ->update($data);
        if ($userDetail) {
            return 1;
        } else {
            return 0;
        }
    }

}