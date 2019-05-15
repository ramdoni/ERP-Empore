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

    public function supervisor()
    {
    	return $this->hasOne('\App\EmporeOrganisasiSupervisor', 'id', 'empore_organisasi_supervisor_id');
    }
}
