<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class user extends Authenticatable
{
    use HasFactory, Notifiable;


    // Only these fields can be  filled from a form.
    // Therefore  nobody can make themselves an admin by editing the request.
    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
{
    return [
    'email_verifies_at'=>'datetime',
    'password'=> 'hashed',
    ];
    }
    public function isAdmin(): bool
{
    return $this->role == 'admin';
    }
}
