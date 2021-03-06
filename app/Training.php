<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = 'training';

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('\App\User', 'id', 'user_id');
    }

    /**
     * [atasan description]
     * @return [type] [description]
     */
    public function atasan()
    {
    	return $this->hasOne('\App\User', 'id', 'approved_atasan_id');
    }

    public function manager()
    {
        return $this->hasOne('\App\User', 'id', 'approved_manager_id');
    }

    /**
     * [direktur description]
     * @return [type] [description]
     */
    public function direktur()
    {
    	return $this->hasOne('\App\User', 'id', 'approve_direktur_id');
    }

    public function trainingtype()
    {
        return $this->hasOne('\App\TrainingType', 'id', 'training_type_id');
    }
}