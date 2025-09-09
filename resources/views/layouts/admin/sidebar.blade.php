<aside class="sidebar fixed-left"> <!-- Classe principal do Duralux -->
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">INFOSI RH</a>
    </div>
    <ul class="sidebar-nav">
        @if(Auth::check())
            @php $role = Auth::user()->role; @endphp
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('frontend.index') }}" target="_blank"><i class="fas fa-globe me-2"></i> SITE</a>
            </li>
            @if($role === 'admin')
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDept" aria-expanded="false" aria-controls="collapseDept">
                        <i class="fas fa-columns me-2"></i> Departamentos <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseDept">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ url('depart') }}">Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ url('depart/create') }}">Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePositions" aria-expanded="false" aria-controls="collapsePositions">
                        <i class="fas fa-briefcase me-2"></i> Cargos <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapsePositions">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ url('positions') }}">Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ url('positions/create') }}">Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseVacation" aria-expanded="false" aria-controls="collapseVacation">
                        <i class="fas fa-plane-departure me-2"></i> Férias <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseVacation">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ url('vacationRequest') }}">Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ url('vacationRequest/create') }}">Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRetirements" aria-expanded="false" aria-controls="collapseRetirements">
                        <i class="fas fa-user-check me-2"></i> Reforma <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseRetirements">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ url('retirements') }}">Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ url('retirements/create') }}">Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i> Meu Perfil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('new-chat.index') }}"><i class="fas fa-comments me-2"></i> Chat</a>
            </li>
        @endif
    </ul>
</aside>