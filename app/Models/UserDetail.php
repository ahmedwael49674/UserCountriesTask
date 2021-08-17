<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDetail extends Model
{
    use HasFactory;

    const UpdatableAttributes = ['citizenship_country_id', 'first_name', 'last_name', 'phone_number'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'citizenship_country_id', 'first_name', 'last_name', 'phone_number',
    ];

    /**
     * Get the user that owns the details.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Get the Country.
     */
    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class, 'citizenship_country_id');
    }
}
