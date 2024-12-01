<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunicado extends Model
{
    use HasFactory;

    protected $dates = ['date'];

    protected $table = 'tasks';

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
