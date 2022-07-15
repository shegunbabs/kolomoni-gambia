<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
/// ACCESSORS & MUTATORS
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    protected function availableBalance(): Attribute {
        return Attribute::make(
            get: fn ($value) => $value/100.00
        );
    }

    protected function ledgerBalance(): Attribute {
        return Attribute::make(
            get: fn ($value) => $value/100.00
        );
    }


    protected function withdrawableBalance(): Attribute {
        return Attribute::make(
            get: fn ($value) => $value/100.00
        );
    }



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// RELATIONSHIPS
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

}
