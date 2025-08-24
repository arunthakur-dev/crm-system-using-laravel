<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'amount', 'owner', 'status', 'priority', 'close_date'];
    protected $casts = [
        'close_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The contacts associated with the deal.
     */
    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_deal', 'deal_id', 'contact_id')
                    ->withTimestamps();
    }

    /**
     * The companies associated with the deal.
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_deal', 'deal_id', 'company_id')
                    ->withTimestamps();
    }
}
