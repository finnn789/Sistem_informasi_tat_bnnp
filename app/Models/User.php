<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nrp',
        'no_telp',
        'satuan_kerja',
        'role',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getNrpAttribute($value)
    {
        return strtoupper($value);
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Accessor untuk foto profile
        public function getProfilePhotoUrlAttributeV4()
    {
        if ($this->profile_photo) {
            return Storage::url($this->profile_photo);
        }

        // Default berdasarkan role
        $roleAvatars = [
            'admin_bnn' => 'avatar-admin.png',
            'operator' => 'avatar-operator.png',
            
        ];

        $defaultAvatar = $roleAvatars[$this->role] ?? 'avatar-default.png';
        return asset("storage/assets/profile/{$defaultAvatar}");
    }

    // Method untuk delete foto lama
    public function deleteOldPhoto()
    {
        if ($this->profile_photo && Storage::disk('public')->exists($this->profile_photo)) {
            Storage::disk('public')->delete($this->profile_photo);
        }
    }

    // Method untuk format nama lengkap dengan NRP
    public function getFullNameAttribute()
    {
        return $this->name . ($this->nrp ? ' (' . $this->nrp . ')' : '');
    }
}
