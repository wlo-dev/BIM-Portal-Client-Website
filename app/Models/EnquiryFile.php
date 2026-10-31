<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnquiryFile extends Model
{
    protected $fillable = ['enquiry_id', 'original_name', 'path', 'size_bytes'];

    public function enquiry(): BelongsTo
    {
        return $this->belongsTo(Enquiry::class);
    }
}