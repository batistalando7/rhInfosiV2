<aside class="sidebar fixed-left" id="sidebarMenu">
    <style>
        .sidebar-nav {
            list-style-type: none;
            padding-left: 0;
        }

        .sidebar-nav li {
            list-style-type: none;
        }

        .submenu {
            list-style-type: none;
            padding-left: 0;
        }

        .submenu .nav-link {
            padding-left: 30px;
        }
    </style>
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">INFOSI RH</a>
    </div>
    <ul class="sidebar-nav">
        @if (Auth::check())
            @php $role = Auth::user()->role; @endphp

            <!-- Painel -->
            <li class="nav-item" style="color: #6c757d; font-weight: bold; padding: 10px 15px;">Painel</li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>
                    Painel de Controle</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('frontend.index') }}" target="_blank"><i
                        class="fas fa-globe me-2"></i> SITE</a>
            </li>

            @if ($role === 'admin' || $role === 'hr')
                <!-- Estrutura Organizacional -->

                <li class="nav-item" style="color: #6c757d; font-weight: bold; padding: 10px 15px;">Estrutura
                    Organizacional</li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDept"
                        aria-expanded="false" aria-controls="collapseDept">
                        <i class="fas fa-columns me-2"></i> Departamentos <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseDept">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.department.index') }}"><i
                                        class="fas fa-eye me-2"></i> Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.department.create') }}"><i
                                        class="fas fa-plus me-2"></i> Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePositions"
                        aria-expanded="false" aria-controls="collapsePositions">
                        <i class="fas fa-briefcase me-2"></i> Cargos <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapsePositions">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.positions.index') }}"><i
                                        class="fas fa-eye me-2"></i> Ver
                                    Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.positions.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSpecialties"
                        aria-expanded="false" aria-controls="collapseSpecialties">
                        <i class="fas fa-star me-2"></i> Especialidades <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseSpecialties">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.specialties.index') }}"><i
                                        class="fas fa-eye me-2"></i> Ver
                                    Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.specialties.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEmployeeType"
                        aria-expanded="false" aria-controls="collapseEmployeeType">
                        <i class="fas fa-id-badge me-2"></i> Vínculo de Funcionários <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseEmployeeType">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.employeeTypes.index') }}"><i
                                        class="fas fa-eye me-2"></i> Ver
                                    Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.employeeTypes.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseEmployeeCategories" aria-expanded="false"
                        aria-controls="collapseEmployeeCategories">
                        <i class="fas fa-tags me-2"></i> Categorias de Funcionários <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseEmployeeCategories">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.employeeCategories.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todas</a></li>
                            <li><a class="nav-link" href="{{ route('admin.employeeCategories.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Nova</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCourses"
                        aria-expanded="false" aria-controls="collapseCourses">
                        <i class="fas fa-book-open me-2"></i> Cursos <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseCourses">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.courses.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.courses.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Gestão de Pessoas -->
                <li class="nav-item" style="color: #6c757d; font-weight: bold; padding: 10px 15px;">Gestão de Pessoas
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEmp"
                        aria-expanded="false" aria-controls="collapseEmp">
                        <i class="fas fa-users me-2"></i> Funcionários <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseEmp">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.employeee.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.employeee.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseIntern"
                        aria-expanded="false" aria-controls="collapseIntern">
                        <i class="fas fa-user-graduate me-2"></i> Estagiários <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseIntern">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.intern.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.intern.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseRetirements" aria-expanded="false"
                        aria-controls="collapseRetirements">
                        <i class="fas fa-user-check me-2"></i> Reforma <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseRetirements">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.retirements.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.retirements.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseSalaryPayment" aria-expanded="false"
                        aria-controls="collapseSalaryPayment">
                        <i class="fa-solid fa-money-check-dollar me-2"></i> Salário <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseSalaryPayment">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('salaryPayment.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('salaryPayment.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseExtras"
                        aria-expanded="false" aria-controls="collapseExtras">
                        <i class="fas fa-briefcase me-2"></i> Trabalhos Extras <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseExtras">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.extras.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.extras.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseVacationRequest" aria-expanded="false"
                        aria-controls="collapseVacationRequest">
                        <i class="fas fa-umbrella-beach me-2"></i> Pedido de Férias <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseVacationRequest">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.vacationRequestes.departmentSummary') }}">Férias
                                    por Departamento</a></li>
                            <li><a class="nav-link" href="{{ route('admin.vacationRequestes.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.vacationRequestes.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Licenças e Movimentações -->
                <li class="nav-item" style="color: #6c757d; font-weight: bold; padding: 10px 15px;">Licenças e
                    Movimentações</li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLeaveType"
                        aria-expanded="false" aria-controls="collapseLeaveType">
                        <i class="fas fa-file-contract me-2"></i> Tipos de Licença <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseLeaveType">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.leaveTypes.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver
                                    Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.leaveTypes.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLeaveRequest" aria-expanded="false"
                        aria-controls="collapseLeaveRequest">
                        <i class="fas fa-file-alt me-2"></i> Pedidos de Licença <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseLeaveRequest">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.leaveRequestes.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.leaveRequestes.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMobility"
                        aria-expanded="false" aria-controls="collapseMobility">
                        <i class="fas fa-exchange-alt me-2"></i> Mobilidade <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseMobility">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.mobilities.index') }}"><i class="fas fa-eye me-2"></i>Ver
                                    Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.mobilities.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseSecondment" aria-expanded="false"
                        aria-controls="collapseSecondment">
                        <i class="fa-solid fa-users-rays me-2"></i> Destacamento <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseSecondment">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ url('secondment') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ url('secondment/create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Administração e Controle -->
                <li class="nav-item" style="color: #6c757d; font-weight: bold; padding: 10px 15px;">Administração e
                    Controle</li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseAttendance" aria-expanded="false"
                        aria-controls="collapseAttendance">
                        <i class="fa-solid fa-calendar-check me-2""></i> Mapa de Efetividade <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseAttendance">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('attendance.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Registros</a></li>
                            <li><a class="nav-link" href="{{ route('attendance.create') }}"><i
                                        class="fas fa-plus me-2"></i>Registrar Presença</a></li>
                            <li><a class="nav-link" href="{{ route('attendance.dashboard') }}"><i
                                        class="fa-solid fa-table-columns me-2"></i>Dashboard de Efetividade</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#deptHeadMenu"
                        aria-expanded="false" aria-controls="deptHeadMenu">
                        <i class="fas fa-user-tie me-2"></i> Portal do Chefe Dept. <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="deptHeadMenu">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('dh.myEmployees') }}"><i
                                        class="fa-solid fa-users me-2"></i>Meus Funcionários</a></li>
                            <li><a class="nav-link" href="{{ route('dh.pendingVacations') }}"><i
                                        class="fas fa-umbrella-beach me-2"></i>Férias Pendentes</a></li>
                            <li><a class="nav-link" href="{{ route('dh.pendingLeaves') }}"><i
                                        class="fas fa-file-alt me-2"></i>Licenças Pendentes</a></li>
                            <li><a class="nav-link" href="{{ route('dh.pendingRetirements') }}"><i
                                        class="fas fa-user-clock me-2"></i>Pedidos de Reforma</a></li>
                        </ul>
                    </div>
                </li>

                {{-- Módulo de fornecedor (Material) --}}
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSupplier"
                        aria-expanded="false" aria-controls="collapseSupplier">
                        <i class="fas fa-box me-2"></i> Fornecedor <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseSupplier">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.suppliers.index') }}"><i
                                        class="fas fa-eye me-2"></i> Lista</a></li>
                            <li><a class="nav-link" href="{{ route('admin.suppliers.create') }}"><i
                                        class="fas fa-plus me-2"></i> Novo</a></li>
                        </ul>
                    </div>
                </li>

                {{-- Módulo de Infraestrutura (Material) --}}
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMaterial"
                        aria-expanded="false" aria-controls="collapseMaterial">
                        <i class="fas fa-tools me-2"></i> Infraestrutura <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseMaterial">
                        <ul class="submenu">
                           {{-- <li><a class="nav-link" href="{{ route('admin.suppliers.index') }}"><i
                                        class="fas fa-box me-2"></i> Entrada de Material</a></li>
                            <li><a class="nav-link" href="{{ route('admin.suppliers.create') }}"><i
                                        class="fas fa-box me-2"></i> Saída de Material</a></li>
                             <li><a class="nav-link" href="{{ route('materials.index') }}"><i
                                        class="fas fa-box me-2"></i> Materiais</a></li>--}}
                            <li><a class="nav-link" href="{{ route('admin.infrastructures.index') }}"><i
                                        class="fas fa-eye me-2"></i> Lista</a></li>
                            <li><a class="nav-link" href="{{ route('admin.infrastructures.create') }}"><i
                                        class="fas fa-plus me-2"></i> Novo Material</a></li>
                            <li><a class="nav-link" href="{{ route('admin.infrastructures.materialInput') }}"><i
                                        class="fas fa-sign-in-alt me-2"></i> Registrar Entrada</a></li>
                            <li><a class="nav-link" href="{{ route('admin.infrastructures.materialOutput') }}"><i
                                        class="fas fa-sign-out-alt me-2"></i> Registrar Saída</a></li>
                        </ul>
                    </div>
                </li>


                {{-- Módulo de Património (Heritage) --}}
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseHeritage"
                        aria-expanded="false" aria-controls="collapseHeritage">
                        <i class="fas fa-building me-2"></i> Património <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseHeritage">
                        <ul class="submenu">
                            {{-- <li><a class="nav-link" href="{{ route('admin.heritages.index') }}"><i
                                        class="fas fa-box me-2"></i> Patrimónios</a></li> --}}
                                        <li><a class="nav-link" href="{{ route('admin.heritageTypes.index') }}"><i
                                                    class="fas fa-tags me-2"></i> Categoria de Património</a></li>
                                        <li><a class="nav-link" href="{{ route('admin.heritages.index') }}"><i
                                        class="fas fa-eye me-2"></i> Lista</a></li>
                            <li><a class="nav-link" href="{{ route('admin.heritages.create') }}"><i
                                        class="fas fa-plus me-2"></i> Novo Material</a></li>
                            <li><a class="nav-link" href="{{ route('admin.heritages.materialInput') }}"><i
                                        class="fas fa-sign-in-alt me-2"></i> Registrar Entrada</a></li>
                            <li><a class="nav-link" href="{{ route('admin.heritages.materialOutput') }}"><i
                                        class="fas fa-sign-out-alt me-2"></i> Registrar Saída</a></li>
                            {{-- ROTAS DE TRANSAÇÃO (Histórico, Entrada, Saída) REMOVIDAS --}}
                        </ul>
                    </div>
                </li>

                <!-- Frota e Transporte -->
                <li class="nav-item" style="color: #6c757d; font-weight: bold; padding: 10px 15px;">Frota e Transporte
                </li>
                {{-- <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLicenseCategories" aria-expanded="false"
                        aria-controls="collapseLicenseCategories">
                        <i class="fa-solid fa-list-check me-2"></i> Categorias de Carta <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseLicenseCategories">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('licenseCategories.index') }}"><i
                                        class="fas fa-eye me-2"></i> Ver Todas</a></li>
                            <li><a class="nav-link" href="{{ route('licenseCategories.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Nova</a></li>
                        </ul>
                    </div>
                </li> --}}
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseVehicles"
                        aria-expanded="false" aria-controls="collapseVehicles">
                        <i class="fas fa-truck me-2"></i> Veículos <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseVehicles">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.vehicles.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.vehicles.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDrivers"
                        aria-expanded="false" aria-controls="collapseDrivers">
                        <i class="fas fa-user-tie me-2"></i> Atribuir Meios <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseDrivers">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.resourceAssignments.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.resourceAssignments.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                {{-- <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDrivers"
                        aria-expanded="false" aria-controls="collapseDrivers">
                        <i class="fas fa-user-tie me-2"></i> Condutores <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseDrivers">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('drivers.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('drivers.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li> --}}
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseMaintenance" aria-expanded="false"
                        aria-controls="collapseMaintenance">
                        <i class="fas fa-tools me-2"></i> Manutenção <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseMaintenance">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.maintenances.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.maintenances.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Geral -->
                <li class="nav-item" style="color: #6c757d; font-weight: bold; padding: 10px 15px;">Geral</li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseStatute"
                        aria-expanded="false" aria-controls="collapseStatute">
                        <i class="fas fa-file-alt me-2"></i> Estatuto <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseStatute">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.statutes.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.statutes.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsers"
                        aria-expanded="false" aria-controls="collapseUsers">
                        <i class="fas fa-users-cog me-2"></i> Usuários <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseUsers">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.users.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver
                                    Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.users.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
            @elseif($role === 'director')
                <!-- Estrutura Organizacional -->
                <li class="nav-item" style="color: #6c757d; font-weight: bold; padding: 10px 15px;">Estrutura
                    Organizacional</li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDept"
                        aria-expanded="false" aria-controls="collapseDept">
                        <i class="fas fa-columns me-2"></i> Departamentos <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseDept">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.department.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver
                                    Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.department.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePositions"
                        aria-expanded="false" aria-controls="collapsePositions">
                        <i class="fas fa-briefcase me-2"></i> Cargos <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapsePositions">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.positions.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver
                                    Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.positions.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseSpecialties" aria-expanded="false"
                        aria-controls="collapseSpecialties">
                        <i class="fas fa-star me-2"></i> Especialidades <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseSpecialties">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.specialties.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.specialties.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Gestão de Pessoas -->
                <li class="nav-item" style="color: #6c757d; font-weight: bold; padding: 10px 15px;">Gestão de Pessoas
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('internEvaluation.index') }}"><i
                            class="fas fa-clipboard-check me-2"></i> Avaliações de Estagiários</a>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEmp"
                        aria-expanded="false" aria-controls="collapseEmp">
                        <i class="fas fa-users me-2"></i> Funcionários <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseEmp">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.employeee.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver
                                    Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.employeee.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseVacationRequest" aria-expanded="false"
                        aria-controls="collapseVacationRequest">
                        <i class="fas fa-umbrella-beach me-2"></i> Pedido de Férias <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseVacationRequest">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('vacationRequestes.departmentSummary') }}">Férias
                                    por Departamento</a></li>
                            <li><a class="nav-link" href="{{ url('vacationRequest') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ url('vacationRequest/create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Licenças e Movimentações -->
                <li class="nav-item" style="color: #6c757d; font-weight: bold; padding: 10px 15px;">Licenças e
                    Movimentações</li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLeaveRequest" aria-expanded="false"
                        aria-controls="collapseLeaveRequest">
                        <i class="fas fa-file-alt me-2"></i> Pedidos de Licença <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseLeaveRequest">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.leaveRequestes.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.leaveRequestes.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMobility"
                        aria-expanded="false" aria-controls="collapseMobility">
                        <i class="fas fa-exchange-alt me-2"></i> Mobilidade <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseMobility">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.mobilities.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver
                                    Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.mobilities.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseSecondment" aria-expanded="false"
                        aria-controls="collapseSecondment">
                        <i class="fa-solid fa-users-rays me-2"></i> Destacamento <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseSecondment">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ url('secondment') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ url('secondment/create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Administração e Controle -->
                <li class="nav-item" style="color: #6c757d; font-weight: bold; padding: 10px 15px;">Administração e
                    Controle</li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#deptHeadMenu"
                        aria-expanded="false" aria-controls="deptHeadMenu">
                        <i class="fas fa-user-tie me-2"></i> Portal do Chefe Dept. <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="deptHeadMenu">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('dh.myEmployees') }}"><i
                                        class="fa-solid fa-users me-2"></i>Meus Funcionários</a></li>
                            <li><a class="nav-link" href="{{ route('dh.pendingVacations') }}"><i
                                        class="fas fa-umbrella-beach me-2"></i>Férias Pendentes</a></li>
                            <li><a class="nav-link" href="{{ route('dh.pendingLeaves') }}"><i
                                        class="fas fa-file-alt me-2"></i>Licenças Pendentes</a></li>
                            <li><a class="nav-link" href="{{ route('dh.pendingRetirements') }}"><i
                                        class="fas fa-user-clock me-2"></i>Pedidos de Reforma</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Área Administrativa (RH) -->
                <li class="nav-item" style="color: #6c757d; font-weight: bold; padding: 10px 15px;">Área
                    Administrativa (RH)</li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#hrMenu"
                        aria-expanded="false" aria-controls="hrMenu">
                        <i class="fas fa-user-cog me-2"></i> Gestão RH <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="hrMenu">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.hr.pendingVacations') }}"><i
                                        class="fas fa-umbrella-beach me-2"></i>Férias para Encaminhar</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Direção Geral -->
                <li class="nav-item" style="color: #6c757d; font-weight: bold; padding: 10px 15px;">Direção Geral</li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#directorMenu"
                        aria-expanded="false" aria-controls="directorMenu">
                        <i class="fas fa-user-tie me-2"></i> Portal Direção <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="directorMenu">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.director.pendingVacations') }}"><i
                                        class="fas fa-check-double me-2"></i>Aprovação de Férias</a></li>
                        </ul>
                    </div>
                </li>
            @elseif($role === 'department_head')
                <!-- Gestão de Pessoas -->
                <li class="nav-item" style="color: #6c757d; font-weight: bold; padding: 10px 15px;">Gestão de Pessoas
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseVacationRequest" aria-expanded="false"
                        aria-controls="collapseVacationRequest">
                        <i class="fas fa-umbrella-beach me-2"></i> Pedido de Férias <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseVacationRequest">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('vacationRequestes.departmentSummary') }}">Férias
                                    por Departamento</a></li>
                            <li><a class="nav-link" href="{{ url('vacationRequest') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ url('vacationRequest/create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEmpEval"
                        aria-expanded="false" aria-controls="collapseEmpEval">
                        <i class="fas fa-star me-2"></i> Avaliações Funcionários <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseEmpEval">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('employeeEvaluations.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('employeeEvaluations.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseInternEvaluation" aria-expanded="false"
                        aria-controls="collapseInternEvaluation">
                        <i class="fas fa-clipboard-check me-2"></i> Avaliações de Estagiários <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseInternEvaluation">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('internEvaluation.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('internEvaluation.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Licenças e Movimentações -->
                <li class="nav-item" style="color: #6c757d; font-weight: bold; padding: 10px 15px;">Licenças e
                    Movimentações</li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLeaveRequest" aria-expanded="false"
                        aria-controls="collapseLeaveRequest">
                        <i class="fas fa-file-alt me-2"></i> Pedidos de Licença <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseLeaveRequest">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('admin.leaveRequestes.index') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ route('admin.leaveRequestes.create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Administração e Controle -->
                <li class="nav-item" style="color: #6c757d; font-weight: bold; padding: 10px 15px;">Administração e
                    Controle</li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#deptHeadMenu"
                        aria-expanded="false" aria-controls="deptHeadMenu">
                        <i class="fas fa-user-tie me-2"></i> Portal do Chefe Dept. <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="deptHeadMenu">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('dh.myEmployees') }}">Meus Funcionários</a></li>
                            <li><a class="nav-link" href="{{ route('dh.pendingVacations') }}">Férias Pendentes</a>
                            </li>
                            <li><a class="nav-link" href="{{ route('dh.pendingLeaves') }}">Licenças Pendentes</a>
                            </li>
                            <li><a class="nav-link" href="{{ route('dh.pendingRetirements') }}">Pedidos de
                                    Reforma</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseAttendance" aria-expanded="false"
                        aria-controls="collapseAttendance">
                        <i class="fas fa-calendar-check me-2"></i> Mapa de Efetividade <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseAttendance">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ route('attendance.index') }}"><i
                                        class="fas fa-eye me-2"></i> Ver Registros</a></li>
                            <li><a class="nav-link" href="{{ route('attendance.create') }}"><i
                                        class="fas fa-plus me-2"></i>Registrar Presença</a></li>
                            <li><a class="nav-link" href="{{ route('attendance.dashboard') }}"><i
                                        class="fa-solid fa-table-columns me-2"></i>Dashboard de Efetividade</a></li>
                        </ul>
                    </div>
                </li>
            @elseif($role === 'employee')
                <!-- Gestão de Pessoas -->
                <li class="nav-item" style="color: #6c757d; font-weight: bold; padding: 10px 15px;">Gestão de Pessoas
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseVacationRequest" aria-expanded="false"
                        aria-controls="collapseVacationRequest">
                        <i class="fas fa-umbrella-beach me-2"></i> Pedido de Férias <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseVacationRequest">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ url('vacationRequest') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ url('vacationRequest/create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseRetirements" aria-expanded="false"
                        aria-controls="collapseRetirements">
                        <i class="fas fa-user-check me-2"></i> Reforma <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseRetirements">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ url('retirements') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ url('retirements/create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Licenças e Movimentações -->
                <li class="nav-item" style="color: #6c757d; font-weight: bold; padding: 10px 15px;">Licenças e
                    Movimentações</li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLeaveRequest" aria-expanded="false"
                        aria-controls="collapseLeaveRequest">
                        <i class="fas fa-file-alt me-2"></i> Pedidos de Licença <i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="collapseLeaveRequest">
                        <ul class="submenu">
                            <li><a class="nav-link" href="{{ url('leaveRequest') }}"><i
                                        class="fas fa-eye me-2"></i>Ver Todos</a></li>
                            <li><a class="nav-link" href="{{ url('leaveRequest/create') }}"><i
                                        class="fas fa-plus me-2"></i>Adicionar Novo</a></li>
                        </ul>
                    </div>
                </li>
            @endif
        @endif

        <li class="nav-item">
            <a class="nav-link" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i> Meu Perfil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('new-chat.index') }}"><i class="fas fa-comments me-2"></i> Chat</a>
        </li>
    </ul>
</aside>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var collapseElements = document.querySelectorAll('.collapse');
        collapseElements.forEach(function(collapse) {
            var bsCollapse = new bootstrap.Collapse(collapse, {
                toggle: false
            });
            collapse.addEventListener('show.bs.collapse', function() {
                collapse.closest('.has-submenu').classList.add('show');
                collapse.previousElementSibling.querySelector('i.ms-auto').style.transform =
                    'rotate(180deg)';
                collapseElements.forEach(function(otherCollapse) {
                    if (otherCollapse !== collapse && otherCollapse.classList.contains(
                            'show')) {
                        otherCollapse.classList.remove('show');
                        otherCollapse.previousElementSibling.querySelector('i.ms-auto')
                            .style.transform = 'rotate(0deg)';
                    }
                });
            });
            collapse.addEventListener('hide.bs.collapse', function() {
                collapse.closest('.has-submenu').classList.remove('show');
                collapse.previousElementSibling.querySelector('i.ms-auto').style.transform =
                    'rotate(0deg)';
            });
        });
    });
</script>
