<aside class="sidebar fixed-left bg-dark text-white"> <!-- Fixa como na imagem Duralux -->
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-brand text-white">INFOSI RH</a>
    </div>
    <ul class="sidebar-nav">
        @if(Auth::check())
            @php $role = Auth::user()->role; @endphp
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('frontend.index') }}" target="_blank"><i class="fas fa-globe me-2"></i> SITE</a>
            </li>
            @if($role === 'admin')
                <li class="nav-item has-submenu">
                    <a class="nav-link text-white" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDept"><i class="fas fa-columns me-2"></i> Departamentos <i class="fas fa-chevron-down ms-auto"></i></a>
                    <ul class="submenu collapse" id="collapseDept">
                        <li><a class="nav-link" href="{{ url('depart') }}">Ver Todos</a></li>
                        <li><a class="nav-link" href="{{ url('depart/create') }}">Adicionar Novo</a></li>
                    </ul>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link text-white" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePositions"><i class="fas fa-briefcase me-2"></i> Cargos <i class="fas fa-chevron-down ms-auto"></i></a>
                    <ul class="submenu collapse" id="collapsePositions">
                        <li><a class="nav-link" href="{{ url('positions') }}">Ver Todos</a></li>
                        <li><a class="nav-link" href="{{ url('positions/create') }}">Adicionar Novo</a></li>
                    </ul>
                </li>
                <!-- Adicione os outros menus semelhantes aqui, como Especialidades, Férias, Reforma, etc. -->
                <li class="nav-item has-submenu">
                    <a class="nav-link text-white" href="#" data-bs-toggle="collapse" data-bs-target="#collapseVacation"><i class="fas fa-plane-departure me-2"></i> Férias <i class="fas fa-chevron-down ms-auto"></i></a>
                    <ul class="submenu collapse" id="collapseVacation">
                        <li><a class="nav-link" href="{{ url('vacationRequest') }}">Ver Todos</a></li>
                        <li><a class="nav-link" href="{{ url('vacationRequest/create') }}">Adicionar Novo</a></li>
                    </ul>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link text-white" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRetirements"><i class="fas fa-user-check me-2"></i> Reforma <i class="fas fa-chevron-down ms-auto"></i></a>
                    <ul class="submenu collapse" id="collapseRetirements">
                        <li><a class="nav-link" href="{{ url('retirements') }}">Ver Todos</a></li>
                        <li><a class="nav-link" href="{{ url('retirements/create') }}">Adicionar Novo</a></li>
                    </ul>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i> Meu Perfil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('new-chat.index') }}"><i class="fas fa-comments me-2"></i> Chat</a>
            </li>
        @endif
    </ul>
</aside>