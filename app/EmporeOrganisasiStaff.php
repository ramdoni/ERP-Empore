<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmporeOrganisasiStaff extends Model
{
    protected $table = 'empore_organisasi_staff';

    /**
     * [manager description]
     * @return [type] [description]
     */
    public function manager()
    {
    	return $this->hasOne('\App\EmporeOrganisasiManager', 'id', 'empore_organisasi_manager_id');
    }
}
