<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'avatar',
        'membership_type',
        'notifications_email',
        'notifications_sms',
        'promotions_enabled',
        'newsletter_frequency',
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
            'date_of_birth' => 'date',
            'notifications_email' => 'boolean',
            'notifications_sms' => 'boolean',
            'promotions_enabled' => 'boolean',
        ];
    }

    // Existing addresses relationship
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    // New helper methods
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('avatars/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=3b82f6&color=ffffff';
    }

    public function getFirstNameAttribute()
    {
        return explode(' ', $this->name)[0];
    }

    public function getLastNameAttribute()
    {
        $nameParts = explode(' ', $this->name);
        return count($nameParts) > 1 ? end($nameParts) : '';
    }

    public function getMembershipTitleAttribute()
    {
        return ucfirst($this->membership_type) . ' Member';
    }

    public function orders()
{
    return $this->hasMany(Order::class);
}

}