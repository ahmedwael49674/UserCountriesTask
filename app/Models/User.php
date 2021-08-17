<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'active',
    ];

    /**
     *
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean'
    ];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the userDetails associated with the user.
     */
    public function details()
    {
        return $this->hasOne(\App\Models\UserDetail::class);
    }

    /***************** scopes ******************** */

    /**
     * Scope a query to get active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query):Builder
    {
        return $query->whereActive(true);
    }

    /**
     * Scope a query to filter users by country iso2.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  null|int $countryId
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCountryId(Builder $query, ?int $countryId):Builder
    {
        if (filled($countryId)) {
            return $query->whereHas('details', function (Builder $queryBuilder) use ($countryId) {
                $queryBuilder->whereCitizenshipCountryId($countryId);
            });
        }
        return $query;
    }
}
