<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'first_name', 'last_name', 'email', 'owner', 'phone', 'lead_status', 'logo'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_contact', 'contact_id', 'company_id')->withTimestamps();
    }

    public function deals(): BelongsToMany
    {
        return $this->belongsToMany(Deal::class, 'contact_deal', 'contact_id', 'deal_id')->withTimestamps();
    }

    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
