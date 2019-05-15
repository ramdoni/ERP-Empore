<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmporeOrganisasiSupervisor extends Model
{
    protected $table = 'empore_organisasi_supervisor';

    /**
     * [direktur description]
     * @return [type] [description]
     */
    public function manager()
    {
    	return $this->hasOne('\App\EmporeOrganisasiManager', 'id', 'empore_organisasi_manager_id');
    }
}
