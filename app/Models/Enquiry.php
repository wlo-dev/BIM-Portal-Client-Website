<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enquiry extends Model
{
    protected $fillable = [
        'reference', 'type', 'status', 'name', 'email', 'phone', 'company', 'client_type',
        'subject', 'project_name', 'project_type', 'location', 'services', 'message',
        'deadline', 'budget',
    ];

    protected function casts(): array
    {
        return ['services' => 'array'];
    }

    public function files(): HasMany
    {
        return $this->hasMany(EnquiryFile::class);
    }
}