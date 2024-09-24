<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aniversario extends Model
{
    use SoftDeletes;

    protected $fillable = ['nombre', 'tel', 'foto'];

    public $timestamps = false;

    protected $dates = ['deleted_at'];
}
