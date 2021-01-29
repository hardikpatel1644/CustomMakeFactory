<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Patient.
 */
class Patient extends Model
{
    /**
     * fillable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'age', 'date_of_birth', 'status'
    ];
}
