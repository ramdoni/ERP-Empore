@if(Auth::user()->access_id == 1)
    <ul class="nav" id="side-menu">
        <li class="user-pro">
            <a href="javascript:void(0)" class="waves-effect"><img src="{{ asset('admin-css/images/user.png') }}" alt="user-img" class="img-circle"> <span class="hide-menu"> {{ Auth::user()->name }}</span>
            </a>
        </li>
        <li> <a href="{{ route('administrator.dashboard') }}"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> Dashboard </a></li>
        <li class="devider"></li>
        <li>
            <a href="{{ route('administrator.karyawan.index') }}">
                <i class="mdi mdi-account-multiple fa-fw"></i> <span class="hide-menu">Employee<span class="fa arrow"></span></span>
            </a>
        </li>
        <li class="mega-nav">
            <a href="#" style="position: relative;">
                <i class="mdi mdi-account-multiple fa-fw"></i> <span class="hide-menu">Workflow Monitoring<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="{{ route('administrator.cuti.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Leave / Permit</span>
                    </a>
                </li>
                 <li>
                    <a href="{{ route('administrator.training.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Training & Business Trip</span>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="{{ route('administrator.structure') }}" class="waves-effect">
                <i class="mdi mdi-account-network fa-fw"></i> <span class="hide-menu">Organization Structure<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="{{ route('administrator.empore-direktur.index') }}"><i class="mdi mdi-account-network fa-fw"></i><span class="hide-menu">Director</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.empore-manager.index') }}"><i class="mdi mdi-account-network fa-fw"></i><span class="hide-menu">Manager</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.empore-supervisor.index') }}"><i class="mdi mdi-account-network fa-fw"></i><span class="hide-menu">Supervisor</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.empore-staff.index') }}"><i class="mdi mdi-account-network fa-fw"></i><span class="hide-menu">Staff</span></a>
                </li>
            </ul>
        </li>
        
        <li class="mega-nav">
            <a href="{{ route('administrator.setting.index') }}" class="waves-effect">
                <i class="mdi mdi-settings fa-fw"></i> <span class="hide-menu">Setting</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)">
                <i class="mdi mdi-newspaper fa-fw"></i> <span class="hide-menu">News List / Memo<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="{{ route('administrator.news.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">News</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.internal-memo.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Internal Memo</span></a>
                </li>
                <li>
                    <a href="{{ route('administrator.peraturan-perusahaan.index') }}"><i class="mdi mdi-clipboard-text fa-fw"></i><span class="hide-menu">Product Information</span></a>
                </li>
            </ul>
        </li>
        

    </ul>
@else
    <ul class="nav" id="side-menu">
        <li class="user-pro">
            <a href="javascript:void(0)" class="waves-effect"><img src="{{ asset('admin-css/images/user.png') }}" alt="user-img" class="img-circle"> <span class="hide-menu"> {{ Auth::user()->name }}</span>
            </a>
        </li>
        <li> <a href="{{ route('karyawan.dashboard') }}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> Dashboard </a></li>
        <li class="devider"></li>
        <li class="mega-nav">
            <a href="javascript:void(0)" class="waves-effect">
                <i class="mdi mdi-account-multiple fa-fw"></i> <span class="hide-menu">Management Form<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="{{ route('karyawan.cuti.index') }}"><i class="ti-user fa-fw"></i><span class="hide-menu">Leave / Permit</span></a>
                </li>
                 <li>
                    <a href="{{ route('karyawan.training.index') }}"><i class="ti-user fa-fw"></i><span class="hide-menu">Training & Business Trip</span></a>
                </li>
            </ul>
        </li>
        

        <!--- cek cuti sebagai DIREKTUR --->
        @if(empore_is_direktur(Auth::user()->id))
        <li style="position: relative;">
                <a href="javascript:void(0)" class="waves-effect">
                    <i class="mdi mdi-account-check fa-fw"></i> <span class="hide-menu">Management Approval As Director<span class="fa arrow"></span></span>
                </a>
                @if(cek_cuti_direktur('null') > 0 ||  cek_training_direktur('null') > 0)    
                    <div class="notify" style="position: absolute;top: 61px;right: 10px;"> <span class="heartbit"></span> <span class="point"></span> </div>
                @endif

            <ul class="nav nav-second-level">
                <li>
                    <a href="{{ route('karyawan.approval.cuti.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Leave / Permit</span>
                        <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ cek_cuti_direktur('null') }}</label>
                    </a>
                </li>
                <li style="position: relative;">
                    <a href="{{ route('karyawan.approval.training.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Training & Business Trip</span>
                        <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ cek_training_direktur('null') }}</label>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        @if(cek_cuti_atasan('all') > 0 || cek_training_atasan('all') > 0 )
        
        <li style="position: relative;">
                <a href="javascript:void(0)" class="waves-effect">
                    <i class="mdi mdi-account-check fa-fw"></i> <span class="hide-menu">Management Approval As Superior<span class="fa arrow"></span></span>
                </a>
                @if(cek_cuti_atasan('null') > 0 || cek_training_atasan('null') > 0  )    
                    <div class="notify" style="position: absolute;top: 61px;right: 10px;"> <span class="heartbit"></span> <span class="point"></span> </div>
                @endif
                
            <ul class="nav nav-second-level">
                <li>
                    <a href="{{ route('karyawan.approval.cuti-atasan.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Leave / Permit</span>
                        <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ cek_cuti_atasan('null') }}</label>
                    </a>
                </li>
                <li style="position: relative;">
                    <a href="{{ route('karyawan.approval.training-atasan.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Training & Business Trip</span>
                        <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ cek_training_atasan('null') }}</label>
                    </a>
                </li>
                
            </ul>
        </li>
        @endif

        <!-- MANAGER-->
         @if(cek_cuti_manager('all') > 0 || cek_training_manager('all') > 0 )
        
        <li style="position: relative;">
                <a href="javascript:void(0)" class="waves-effect">
                    <i class="mdi mdi-account-check fa-fw"></i> <span class="hide-menu">Management Approval As Manager<span class="fa arrow"></span></span>
                </a>
                @if(cek_cuti_manager('null') > 0 || cek_training_manager('null') > 0  )    
                    <div class="notify" style="position: absolute;top: 61px;right: 10px;"> <span class="heartbit"></span> <span class="point"></span> </div>
                @endif
                
            <ul class="nav nav-second-level">
                <li>
                    <a href="{{ route('karyawan.approval.cuti-manager.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Leave / Permit</span>
                        <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ cek_cuti_manager('null') }}</label>
                    </a>
                </li>
                <li style="position: relative;">
                    <a href="{{ route('karyawan.approval.training-manager.index') }}"><i class="ti-check-box fa-fw"></i><span class="hide-menu">Training & Business Trip</span>
                        <label class="btn btn-danger btn-xs" style="position: absolute;right:10px; top: 10px;">{{ cek_training_manager('null') }}</label>
                    </a>
                </li>
                
            </ul>
        </li>
        @endif

    </ul>
@endif