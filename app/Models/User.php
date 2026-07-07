<?php

namespace App\Models;

 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

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
        'membership_number',
        'status',
        'stripe_customer_id'
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

    /**
     * Generate a unique membership number (e.g. MEM-A8X42K9P).
     */
    public static function generateMembershipNumber(): string
    {
        do {
            $number = 'MEM-' . strtoupper(Str::random(8));
        } while (self::where('membership_number', $number)->exists());

        return $number;
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

    public function collaboratorBusinessDetails()
    {
        return $this->hasOne(CollaboratorBusinessDetails::class);
    }

    public function collaboratorBankDetails()
    {
        return $this->hasOne(CollaboratorBankDetails::class);
    }

    public function adminBusinessDetails()
    {
        return $this->hasOne(AdminBusinessDetails::class);
    }

    public function subOrders()
    {
        return $this->hasMany(SubOrder::class, 'seller_id');
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