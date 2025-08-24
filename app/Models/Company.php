<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'domain', 'owner',
        'phone', 'industry', 'country', 'state',
        'postal_code', 'notes', 'logo'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'company_contact', 'company_id', 'contact_id')->withTimestamps();
    }

    public function deals(): BelongsToMany
    {
        return $this->belongsToMany(Deal::class, 'company_deal', 'company_id', 'deal_id')->withTimestamps();
    }
}
