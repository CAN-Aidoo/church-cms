<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'partner_type', 'name', 'category', 'description', 'contact_person',
        'phone', 'email', 'address', 'website', 'logo', 'status',
    ];

    public function agreements()
    {
        return $this->hasMany(PartnershipAgreement::class);
    }

    public function activities()
    {
        return $this->hasMany(PartnershipActivity::class);
    }

    public function financials()
    {
        return $this->hasMany(PartnershipFinancial::class);
    }

    public function activate(): self
    {
        $this->update(['status' => 'active']);

        return $this;
    }

    public function deactivate(): self
    {
        $this->update(['status' => 'inactive']);

        return $this;
    }

    public function scopeActive($query)
    {
        return $query->where('member_status', 'active');
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
