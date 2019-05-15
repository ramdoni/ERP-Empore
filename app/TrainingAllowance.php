<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingAllowance extends Model
{
    protected $table = 'training_allowance';

    /**
     * [user description]
     * @return [type] [description]
     */
    public function training()
    {
    	return $this->hasOne('\App\Training', 'id', 'training_id');
    }

    
}