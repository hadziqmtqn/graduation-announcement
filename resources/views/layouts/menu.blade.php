<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
    <div class="container-xxl d-flex h-100">
        <ul class="menu-inner">
            <li class="menu-item {{ url()->current() == route('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-home-outline"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>
            <li class="menu-item {{ url()->current() == route('school-year.index') ? 'active' : '' }}">
                <a href="{{ route('school-year.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-calendar-multiselect-outline"></i>
                    <div data-i18n="Tahun Ajaran">Tahun Ajaran</div>
                </a>
            </li>
            <li class="menu-item {{ url()->current() == route('student.index') ? 'active' : '' }}">
                <a href="{{ route('student.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-account-multiple-outline"></i>
                    <div data-i18n="Siswa">Siswa</div>
                </a>
            </li>
            <li class="menu-item {{ url()->current() == route('course.index') ? 'active' : '' }}">
                <a href="{{ route('course.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-clipboard-text-outline"></i>
                    <div data-i18n="Mata Pelajaran">Mata Pelajaran</div>
                </a>
            </li>
        </ul>
    </div>
</aside>