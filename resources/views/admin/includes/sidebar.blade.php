@php
    $user = Auth::user();
@endphp

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ URL::to('/admin/dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ URL::to('/admin/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Modules
    </div>

    @if (
        $user->can('role.create') ||
            $user->can('role.view') ||
            $user->can('role.edit') ||
            $user->can('role.delete') ||
            $user->can('user.view') ||
            $user->can('user.create'))
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRole"
                aria-expanded="true" aria-controls="collapseRole">
                <i class="fas fa-fw fa-tasks"></i>
                <span>
                    User & roles
                </span>
            </a>
            <div id="collapseRole"
                class="collapse {{ in_array(URL::current(), [URL::to('/admin/roles'), URL::to('/admin/create-role'), URL::to('/admin/edit-role'), URL::to('/admin/users'), URL::to('/admin/create-user'), URL::to('/admin/edit-user')]) ? 'show' : '' }}"
                aria-labelledby="collapseRole" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if ($user->can('role.view'))
                        <a class="collapse-item {{ in_array(URL::current(), [URL::to('/admin/roles'), URL::to('/admin/edit-role')]) ? 'active' : '' }}"
                            href="{{ URL::to('/admin/roles') }}">Manage Roles</a>
                    @endif
                    @if ($user->can('role.create'))
                        <a class="collapse-item {{ URL::current() == URL::to('/admin/create-role') ? 'active' : '' }}"
                            href="{{ URL::to('/admin/create-role') }}">New Role</a>
                    @endif

                    @if ($user->can('user.view'))
                        <a class="collapse-item {{ in_array(URL::current(), [URL::to('/admin/users'), URL::to('/admin/edit-user')]) ? 'active' : '' }}"
                            href="{{ URL::to('/admin/users') }}">Manage Users</a>
                    @endif

                    @if ($user->can('user.create'))
                        <a class="collapse-item {{ URL::current() == URL::to('/admin/create-user') ? 'active' : '' }}"
                            href="{{ URL::to('/admin/create-user') }}">New User</a>
                    @endif
                </div>
            </div>
        </li>
    @endif

    <!-- Setting -->
    @if ($user->can('admissionFee.create') || $user->can('monthlyFee.create') || $user->can('stationaryFee.create'))
        <!-- Nav Item - Setting -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSetting"
                aria-expanded="true" aria-controls="collapseSetting">
                <i class="fas fa-fw fa-cog"></i>
                <span>Setting</span>
            </a>
            <div id="collapseSetting"
                class="collapse {{ in_array(URL::current(), [URL::to('/admin/getAllAdmissionFee'), URL::to('/admin/getAllmonthlyFee'), URL::to('/admin/stationary-setup')]) ? 'show' : '' }}"
                aria-labelledby="collapseSetting" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if ($user->can('admissionFee.create'))
                        <a class="collapse-item {{ URL::current() == URL::to('/admin/getAllAdmissionFee') ? 'active' : '' }}"
                            href="{{ URL::to('/admin/getAllAdmissionFee') }}">Admission Fee Setup</a>
                    @endif
                    @if ($user->can('monthlyFee.create'))
                        <a class="collapse-item {{ URL::current() == URL::to('/admin/getAllMonthlyFee') ? 'active' : '' }}"
                            href="{{ URL::to('/admin/getAllMonthlyFee') }}">Monthly Fee Setup</a>
                    @endif
                    @if ($user->can('stationaryFee.create'))
                        <a class="collapse-item {{ URL::current() == URL::to('/admin/getAllStationaryFee') ? 'active' : '' }}"
                            href="{{ URL::to('/admin/getAllStationaryFee') }}">Stationary & Book</a>
                    @endif
                </div>
            </div>
        </li>
    @endif

    @if (
        $user->can('studentClass.create') ||
            $user->can('studentClass.view') ||
            $user->can('studentClass.edit') ||
            $user->can('studentClass.delete'))
        <!-- Nav Item - Category -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudentClass"
                aria-expanded="true" aria-controls="collapseStudentClass">
                <i class="fas fa-fw fa-th"></i>
                <span>Class</span>
            </a>
            <div id="collapseStudentClass"
                class="collapse {{ in_array(URL::current(), [URL::to('/admin/getAllStudentsClass'), URL::to('/admin/create-studentClass'), URL::to('/admin/edit-studentClass')]) ? 'show' : '' }}"
                aria-labelledby="collapseStudentClass" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if ($user->can('studentClass.view'))
                        <a class="collapse-item {{ in_array(URL::current(), [URL::to('/admin/getAllStudentsClass'), URL::to('/admin/edit-studentClass')]) ? 'active' : '' }}"
                            href="{{ URL::to('/admin/getAllStudentsClass') }}">Classes</a>
                    @endif
                    @if ($user->can('studentClass.create'))
                        <a class="collapse-item {{ URL::current() == URL::to('/admin/create-studentClass') ? 'active' : '' }}"
                            href="{{ URL::to('/admin/create-studentClass') }}">Add new</a>
                    @endif
                </div>
            </div>
        </li>
    @endif
    @if (
        $user->can('student.create') ||
            $user->can('student.view') ||
            $user->can('student.edit') ||
            $user->can('student.delete'))
        <!-- Nav Item - Category -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudent"
                aria-expanded="true" aria-controls="collapseStudent">
                <i class="fas fa-fw fa-th"></i>
                <span>Student</span>
            </a>
            <div id="collapseStudent"
                class="collapse {{ in_array(URL::current(), [URL::to('/admin/getAllStudents'), URL::to('/admin/create-student'), URL::to('/admin/edit-student')]) ? 'show' : '' }}"
                aria-labelledby="collapseStudent" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if ($user->can('student.view'))
                        <a class="collapse-item {{ in_array(URL::current(), [URL::to('/admin/getAllStudents'), URL::to('/admin/edit-student')]) ? 'active' : '' }}"
                            href="{{ URL::to('/admin/getAllStudents') }}">Student list</a>
                    @endif
                    @if ($user->can('student.create'))
                        <a class="collapse-item {{ URL::current() == URL::to('/admin/getAllStudentPromotion') ? 'active' : '' }}"
                            href="{{ URL::to('/admin/getAllStudentPromotion') }}">Promotion</a>
                    @endif
                    @if ($user->can('student.create'))
                        <a class="collapse-item {{ URL::current() == URL::to('/admin/getAllStudentShifting') ? 'active' : '' }}"
                            href="{{ URL::to('/admin/getAllStudentShifting') }}">Class Shifting</a>
                    @endif
                    @if ($user->can('student.create'))
                        <a class="collapse-item {{ URL::current() == URL::to('/admin/getStudentLedger') ? 'active' : '' }}"
                            href="{{ URL::to('/admin/student-ledger') }}">Student Ledger</a>
                    @endif
                </div>
            </div>
        </li>
    @endif

    {{-- @if ($user->can('admissionFee.create') || $user->can('admissionFee.view') || $user->can('admissionFee.edit') || $user->can('admissionFee.delete'))
        <!-- Nav Item - Category -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmissionFee"
                aria-expanded="true" aria-controls="collapseAdmissionFee">
                <i class="fas fa-fw fa-th"></i>
                <span>Admission Fees Setup</span>
            </a>
            <div id="collapseAdmissionFee"
                class="collapse {{ in_array(URL::current(), [URL::to('/admin/getAllAdmissionFee'), URL::to('/admin/create-admissionFee'), URL::to('/admin/edit-admissionFee')]) ? 'show' : '' }}"
                aria-labelledby="collapseAdmissionFee" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if ($user->can('admissionFee.view'))
                        <a class="collapse-item {{ in_array(URL::current(), [URL::to('/admin/getAllAdmissionFee'), URL::to('/admin/edit-admissionFee')]) ? 'active' : '' }}"
                            href="{{ URL::to('/admin/getAllAdmissionFee') }}">Manage Admission Fees</a>
                    @endif
                    @if ($user->can('admissionFee.create'))
                        <a class="collapse-item {{ URL::current() == URL::to('/admin/create-admissionFee') ? 'active' : '' }}"
                            href="{{ URL::to('/admin/create-admissionFee') }}">New Admission Fee</a>
                    @endif
                </div>
            </div>
        </li>
    @endif
    @if ($user->can('monthlyFee.create') || $user->can('monthlyFee.view') || $user->can('monthlyFee.edit') || $user->can('monthlyFee.delete'))
        <!-- Nav Item - Category -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMonthlyFee"
                aria-expanded="true" aria-controls="collapseMonthlyFee">
                <i class="fas fa-fw fa-th"></i>
                <span>Monthly Fees Setup</span>
            </a>
            <div id="collapseMonthlyFee"
                class="collapse {{ in_array(URL::current(), [URL::to('/admin/getAllmonthlyFee'), URL::to('/admin/create-monthlyFee'), URL::to('/admin/edit-monthlyFee')]) ? 'show' : '' }}"
                aria-labelledby="collapseMonthlyFee" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if ($user->can('monthlyFee.view'))
                        <a class="collapse-item {{ in_array(URL::current(), [URL::to('/admin/getAllmonthlyFee'), URL::to('/admin/edit-monthlyFee')]) ? 'active' : '' }}"
                            href="{{ URL::to('/admin/getAllMonthlyFee') }}">Manage Monthly Fees</a>
                    @endif
                    @if ($user->can('monthlyFee.create'))
                        <a class="collapse-item {{ URL::current() == URL::to('/admin/create-monthlyFee') ? 'active' : '' }}"
                            href="{{ URL::to('/admin/create-monthlyFee') }}">New Monthly Fee</a>
                    @endif
                </div>
            </div>
        </li>
    @endif --}}
    @if (
        $user->can('monthlyFeeStudent.create') ||
            $user->can('monthlyFeeStudent.view') ||
            $user->can('monthlyFeeStudent.edit') ||
            $user->can('monthlyFeeStudent.delete'))
        <!-- Nav Item - Category -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMonthlyFeeStudent"
                aria-expanded="true" aria-controls="collapseMonthlyFeeStudent">
                <i class="fas fa-fw fa-th"></i>
                <span>Monthly Tuition</span>
            </a>
            <div id="collapseMonthlyFeeStudent"
                class="collapse {{ in_array(URL::current(), [URL::to('/admin/getAllmonthlyFee'), URL::to('/admin/monthly-fee-student'), URL::to('/admin/edit-monthlyFee')]) ? 'show' : '' }}"
                aria-labelledby="collapseMonthlyFee" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if ($user->can('monthlyFeeStudent.view'))
                        <a class="collapse-item {{ in_array(URL::current(), [URL::to('/admin/monthly-fee-student'), URL::to('/admin/edit-monthlyFee')]) ? 'active' : '' }}"
                            href="{{ URL::to('/admin/monthly-fee-student') }}">Generate Due list</a>
                    @endif
                    @if ($user->can('monthlyFeeStudent.create'))
                        <a class="collapse-item {{ URL::current() == URL::to('/admin/getAllStudentMonthlyFee') ? 'active' : '' }}"
                            href="{{ URL::to('/admin/getAllStudentMonthlyFee') }}">All Student Monthly Fee</a>
                    @endif
                </div>
            </div>
        </li>
    @endif

    {{-- @if ($user->can('stationaryFee.create') || $user->can('stationaryFee.view') || $user->can('stationaryFee.edit') || $user->can('stationaryFee.delete'))
        <!-- Nav Item - Category -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStationaryFee"
                aria-expanded="true" aria-controls="collapseStationaryFee">
                <i class="fas fa-fw fa-th"></i>
                <span>Stationary Fees Setup</span>
            </a>
            <div id="collapseStationaryFee"
                class="collapse {{ in_array(URL::current(), [URL::to('/admin/getAllStationaryFee'), URL::to('/admin/create-stationaryFee'), URL::to('/admin/edit-stationaryFee')]) ? 'show' : '' }}"
                aria-labelledby="collapseStationaryFee" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if ($user->can('stationaryFee.view'))
                        <a class="collapse-item {{ in_array(URL::current(), [URL::to('/admin/getAllStationaryFee'), URL::to('/admin/edit-stationaryFee')]) ? 'active' : '' }}"
                            href="{{ URL::to('/admin/getAllStationaryFee') }}">Manage Stationary Fees</a>
                    @endif
                    @if ($user->can('stationaryFee.create'))
                        <a class="collapse-item {{ URL::current() == URL::to('/admin/create-stationaryFee') ? 'active' : '' }}"
                            href="{{ URL::to('/admin/create-stationaryFee') }}">New Stationary Fee</a>
                    @endif
                </div>
            </div>
        </li>
    @endif --}}

    @if (
        $user->can('stationaryFeeBuy.create') ||
            $user->can('stationaryFeeBuy.view') ||
            $user->can('stationaryFeeBuy.edit') ||
            $user->can('stationaryFeeBuy.delete'))
        <!-- Nav Item - Category -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse"
                data-target="#collapseStationaryFeeBuy" aria-expanded="true"
                aria-controls="collapseStationaryFeeBuy">
                <i class="fas fa-fw fa-th"></i>
                <span>Items Sells</span>
            </a>
            <div id="collapseStationaryFeeBuy"
                class="collapse {{ in_array(URL::current(), [URL::to('/admin/getAllStationaryFeeBuy'), URL::to('/admin/create-stationaryFeeBuy'), URL::to('/admin/edit-stationaryFeeBuy')]) ? 'show' : '' }}"
                aria-labelledby="collapseStationaryFeeBuy" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- @if ($user->can('stationaryFeeBuy.view'))
                        <a class="collapse-item {{ in_array(URL::current(), [URL::to('/admin/getAllStationaryFeeBuy'), URL::to('/admin/edit-stationaryFeeBuy')]) ? 'active' : '' }}"
                            href="{{ URL::to('/admin/getAllStationaryFeeBuy') }}">Manage Stationary Buy</a>
                    @endif --}}
                    @if ($user->can('stationaryFeeBuy.create'))
                        <a class="collapse-item {{ URL::current() == URL::to('/admin/create-stationaryFeeBuy') ? 'active' : '' }}"
                            href="{{ URL::to('/admin/create-stationaryFeeBuy') }}">New Stationary Buy</a>
                    @endif
                </div>
            </div>
        </li>
    @endif

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEvent"
            aria-expanded="true" aria-controls="collapseEvent">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Events</span>
        </a>
        <div id="collapseEvent" class="collapse" aria-labelledby="headingEvent" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ URL::to('/admin/create-eventFee') }}">Create Event</a>
                <a class="collapse-item" href="{{ URL::to('/admin/show-eventFee') }}">Show Event</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport"
            aria-expanded="true" aria-controls="collapseReport">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Reports</span>
        </a>
        <div id="collapseReport" class="collapse" aria-labelledby="headingReport" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ URL::to('/admin/reports/new-admitted-student-list') }}">Newly
                    admitted
                    student list</a>
                <a class="collapse-item" href="{{ URL::to('/admin/reports/all-admitted-student-fee') }}">Total
                    admission fee
                    collection</a>
                <a class="collapse-item" href="{{ URL::to('/admin/reports/all-admitted-student-list') }}">All student
                    list</a>
                <a class="collapse-item" href="{{ URL::to('/admin/reports/daily-collection') }}">Monthly overdue
                    list</a>
                <a class="collapse-item" href="{{ URL::to('/admin/reports/daily-collection') }}">Daily Report</a>
                <a class="collapse-item" href="{{ URL::to('/admin/reports/getAllStudentMonthlyFee') }}">Monthly
                    Report</a>
                {{-- <a class="collapse-item" href="{{ URL::to('/admin/reports/getAllDueStudentMonthlyFee') }}">Monthly
                    Due Report</a> --}}
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTask"
            aria-expanded="true" aria-controls="collapseTask">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Task</span>
        </a>
        <div id="collapseTask" class="collapse" aria-labelledby="headingTask" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ URL::to('/admin/tasks/create-task') }}">Create Task</a>
                <a class="collapse-item" href="{{ URL::to('/admin/tasks/getYourTasks') }}">Show your
                    task
                </a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
