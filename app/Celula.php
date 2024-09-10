<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Celula extends Model
    {
        use SoftDeletes;

        protected $fillable = [
            'nombre','descripcion'
        ];
    
        public $timestamps = false;
    
        protected $dates = ['deleted_at'];
    
       /*  public function eventosasistencia()
        {
            return $this->hasMany(EventosAsistencia::class, 'id_evento', 'id');
        } */
    
        
        
    }
