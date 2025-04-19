<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enquiry extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_ASSIGNED = 'assigned'; 
    const STATUS_CONVERTED = 'converted';
    const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'user_id',
        'assigned_mentor_id',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'service',
        'preferred_date',
        'duration',
        'status'
    ];

    protected $casts = [
        'preferred_date' => 'datetime',
        'duration' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assigned_mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_mentor_id');
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isAssigned(): bool
    {
        return $this->status === self::STATUS_ASSIGNED;
    }

    public function isConverted(): bool
    {
        return $this->status === self::STATUS_CONVERTED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }
}
