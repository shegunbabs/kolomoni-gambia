<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    use HasFactory;

    protected $guarded = [
        'id', 'user_id',
    ];

    protected $hidden = [
        'transaction_tracking_ref', 'customer_id', 'account_number',
        'account_officer_code', 'user_id', 'created_at', 'updated_at'
    ];

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// RELATIONSHIPS
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

}
