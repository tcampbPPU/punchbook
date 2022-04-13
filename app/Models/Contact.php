<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $appends = ['first_name', 'avatar'];
    public static array $sortable = [
        'name',
        'phone',
        'email',
        'created_at',
        'updated_at',
    ];
    public static array $filterable = ['name', 'phone', 'email'];

    public function getFirstNameAttribute(): string
    {
        return explode(' ', $this->name)[0];
    }

    public function getAvatarAttribute(): string
    {
        return "https://avatars.dicebear.com/api/human/{$this->email}.svg";
    }

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OrderScope('updated_at', 'desc'));
    }

    /**
     * Local Filter Scope
     *
     * @param Builder<Contact> $query
     * @param array $filters
     * @param string $comparison
     * @return void
     */
    public function scopeFilter(Builder $query, array $filters, string $comparison = 'like'): void
    {
        $query->when($filters['search'] ?? null, fn($query, $search) =>
            $query->where('name', $comparison, "%{$search}%")
                ->orWhere('phone', $comparison, "%{$search}%")
                ->orWhere('email', $comparison, "%{$search}%"));
    }
}
