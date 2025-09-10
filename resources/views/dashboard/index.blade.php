@extends('layouts.admin.layout')

@section('title', 'Dashboard RH-INFOSI')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <p>Bem-vindo, {{ Auth::user()->employee->fullName ?? Auth::user()->email }}</p>

    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'director')
        <!-- Cards -->
        <div class="row g-4">
            <!-- Total de Funcionários -->
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-4">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="avatar-text avatar-lg bg-gray-200">
                                    <i class="feather-users"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $totalEmployees }}</div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">Total de Funcionários</h3>
                                </div>
                            </div>
                            <a href="{{ route('employeee.index') }}" class="">
                                <i class="feather-more-vertical"></i>
                            </a>
                        </div>
                        <div class="pt-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('employeee.index') }}" class="fs-12 fw-medium text-muted text-truncate-1-line">Ver Detalhes</a>
                                <div class="w-100 text-end">
                                    <span class="fs-12 text-dark">{{ $totalEmployees }}</span>
                                    <span class="fs-11 text-muted">(100%)</span>
                                </div>
                            </div>
                            <div class="progress mt-2 ht-3">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Funcionários Ativos -->
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-4">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="avatar-text avatar-lg bg-gray-200">
                                    <i class="feather-user-check"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $activeEmployees }}</div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">Funcionários Ativos</h3>
                                </div>
                            </div>
                            <a href="{{ route('employeee.filterByStatus', ['status' => 'active']) }}" class="">
                                <i class="feather-more-vertical"></i>
                            </a>
                        </div>
                        <div class="pt-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('employeee.filterByStatus', ['status' => 'active']) }}" class="fs-12 fw-medium text-muted text-truncate-1-line">Ver Detalhes</a>
                                <div class="w-100 text-end">
                                    <span class="fs-12 text-dark">{{ $activeEmployees }}</span>
                                    <span class="fs-11 text-muted">({{ round(($activeEmployees / $totalEmployees) * 100) }}%)</span>
                                </div>
                            </div>
                            <div class="progress mt-2 ht-3">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ round(($activeEmployees / $totalEmployees) * 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Funcionários Destacados -->
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-4">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="avatar-text avatar-lg bg-gray-200">
                                    <i class="feather-briefcase"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $highlightedEmployees }}</div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">Funcionários Destacados</h3>
                                </div>
                            </div>
                            <a href="{{ route('secondment.index') }}" class="">
                                <i class="feather-more-vertical"></i>
                            </a>
                        </div>
                        <div class="pt-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('secondment.index') }}" class="fs-12 fw-medium text-muted text-truncate-1-line">Ver Detalhes</a>
                                <div class="w-100 text-end">
                                    <span class="fs-12 text-dark">{{ $highlightedEmployees }}</span>
                                    <span class="fs-11 text-muted">({{ round(($highlightedEmployees / $totalEmployees) * 100) }}%)</span>
                                </div>
                            </div>
                            <div class="progress mt-2 ht-3">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ round(($highlightedEmployees / $totalEmployees) * 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Funcionários Reformados -->
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-4">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="avatar-text avatar-lg bg-gray-200">
                                    <i class="feather-user-x"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $retiredEmployees }}</div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">Funcionários Reformados</h3>
                                </div>
                            </div>
                            <a href="{{ route('retirements.index') }}" class="">
                                <i class="feather-more-vertical"></i>
                            </a>
                        </div>
                        <div class="pt-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('retirements.index') }}" class="fs-12 fw-medium text-muted text-truncate-1-line">Ver Detalhes</a>
                                <div class="w-100 text-end">
                                    <span class="fs-12 text-dark">{{ $retiredEmployees }}</span>
                                    <span class="fs-11 text-muted">({{ round(($retiredEmployees / $totalEmployees) * 100) }}%)</span>
                                </div>
                            </div>
                            <div class="progress mt-2 ht-3">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ round(($retiredEmployees / $totalEmployees) * 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Estagiários -->
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-4">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="avatar-text avatar-lg bg-gray-200">
                                    <i class="feather-book-open"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $totalInterns }}</div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">Estagiários</h3>
                                </div>
                            </div>
                            <a href="{{ route('intern.index') }}" class="">
                                <i class="feather-more-vertical"></i>
                            </a>
                        </div>
                        <div class="pt-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('intern.index') }}" class="fs-12 fw-medium text-muted text-truncate-1-line">Ver Detalhes</a>
                                <div class="w-100 text-end">
                                    <span class="fs-12 text-dark">{{ $totalInterns }}</span>
                                    <span class="fs-11 text-muted">({{ round(($totalInterns / ($totalEmployees + $totalInterns)) * 100) }}%)</span>
                                </div>
                            </div>
                            <div class="progress mt-2 ht-3">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ round(($totalInterns / ($totalEmployees + $totalInterns)) * 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela de Chefes de Departamento -->
        <div class="row g-4">
            <div class="col-xxl-8">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">Chefes de Departamento</h5>
                        <div class="card-header-action">
                            <div class="card-header-btn">
                                <div data-bs-toggle="tooltip" title="Refresh">
                                    <a href="javascript:void(0);" class="avatar-text avatar-xs bg-warning" data-bs-toggle="refresh"></a>
                                </div>
                                <div data-bs-toggle="tooltip" title="Maximize/Minimize">
                                    <a href="javascript:void(0);" class="avatar-text avatar-xs bg-success" data-bs-toggle="expand"></a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="avatar-text avatar-sm" data-bs-toggle="dropdown" data-bs-offset="25, 25">
                                    <div data-bs-toggle="tooltip" title="Opções">
                                        <i class="feather-more-vertical"></i>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('employeee.index') }}" class="dropdown-item"><i class="feather-users"></i>Ver Todos</a>
                                    <a href="javascript:void(0);" class="dropdown-item"><i class="feather-settings"></i>Configurações</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body custom-card-action p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr class="border-b">
                                        <th scope="row">Chefe</th>
                                        <th>Departamento</th>
                                        <th>Total de Funcionários</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($departmentHeads as $head)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar-image">
                                                    <img src="{{ $head->photo ? asset('frontend/images/departments/' . $head->photo) : asset('public/assets/images/avatar/default.png') }}" alt="{{ $head->fullName }}" class="img-fluid" />
                                                </div>
                                                <a href="{{ route('employeee.show', $head->id) }}">
                                                    <span class="d-block">{{ $head->fullName }}</span>
                                                    <span class="fs-12 d-block fw-normal text-muted">{{ $head->email }}</span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>{{ $head->department->title ?? 'Sem Departamento' }}</td>
                                        <td>{{ $head->department->employeee->count() }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('employeee.show', $head->id) }}"><i class="feather-more-vertical"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <ul class="list-unstyled d-flex align-items-center gap-2 mb-0 pagination-common-style">
                            <li><a href="javascript:void(0);"><i class="bi bi-arrow-left"></i></a></li>
                            <li><a href="javascript:void(0);" class="active">1</a></li>
                            <li><a href="javascript:void(0);">2</a></li>
                            <li><a href="javascript:void(0);"><i class="bi bi-dot"></i></a></li>
                            <li><a href="javascript:void(0);">8</a></li>
                            <li><a href="javascript:void(0);">9</a></li>
                            <li><a href="javascript:void(0);"><i class="bi bi-arrow-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Gráficos de Círculo -->
            <div class="col-xxl-4">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="hstack justify-content-between mb-4 pb-">
                            <div>
                                <h5 class="mb-1">Distribuição de Funcionários</h5>
                                <span class="fs-12 text-muted">Percentagem por Tipo de Contrato</span>
                            </div>
                            <a href="{{ route('employeee.index') }}" class="btn btn-light-brand">Ver Todos</a>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="card-body border border-dashed border-gray-5 rounded-3 position-relative">
                                    <div class="hstack justify-content-between gap-4">
                                        <div>
                                            <h6 class="fs-14 text-truncate-1-line">Funcionários Efetivos</h6>
                                            <div class="fs-12 text-muted"><span class="text-dark fw-medium">Total:</span> {{ $permanentEmployees }}</div>
                                        </div>
                                        <div class="employee-progress-permanent"></div>
                                    </div>
                                    <div class="badge bg-gray-200 text-dark project-mini-card-badge">{{ round(($permanentEmployees / $totalEmployees) * 100) }}%</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body border border-dashed border-gray-5 rounded-3 position-relative">
                                    <div class="hstack justify-content-between gap-4">
                                        <div>
                                            <h6 class="fs-14 text-truncate-1-line">Funcionários Contratados</h6>
                                            <div class="fs-12 text-muted"><span class="text-dark fw-medium">Total:</span> {{ $contractEmployees }}</div>
                                        </div>
                                        <div class="employee-progress-contract"></div>
                                    </div>
                                    <div class="badge bg-gray-200 text-dark project-mini-card-badge">{{ round(($contractEmployees / $totalEmployees) * 100) }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row g-4">
            <!-- Gráfico de Funcionários por Status -->
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Funcionários por Status</h5>
                    </div>
                    <div class="card-body">
                        <div id="employeesByStatusChart"></div>
                    </div>
                </div>
            </div>
            <!-- Gráfico de Funcionários por Departamento -->
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Funcionários por Departamento</h5>
                    </div>
                    <div class="card-body">
                        <div id="employeesByDepartmentChart"></div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <strong>Atenção:</strong> Você tem acesso aos menus gerais do sistema, porém não pode visualizar os dados estatísticos do dashboard.
        </div>
    @endif
</div>
@endsection

@section('scripts')
@if(Auth::user()->role === 'admin' || Auth::user()->role === 'director')
<script src="{{ asset('public/assets/vendors/js/vendors.min.js') }}"></script>
<script src="{{ asset('public/assets/vendors/js/apexcharts.min.js') }}"></script>
<script src="{{ asset('public/assets/vendors/js/circle-progress.min.js') }}"></script>
<script src="{{ asset('public/assets/js/common-init.min.js') }}"></script>
<script src="{{ asset('public/assets/js/dashboard-init.min.js') }}"></script>
<script src="{{ asset('public/assets/js/theme-customizer-init.min.js') }}"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Dados dos cards
    var totalEmployees = {{ $totalEmployees }};
    var activeEmployees = {{ $activeEmployees }};
    var highlightedEmployees = {{ $highlightedEmployees }};
    var retiredEmployees = {{ $retiredEmployees }};
    var totalInterns = {{ $totalInterns }};
    var permanentEmployees = {{ $permanentEmployees }};
    var contractEmployees = {{ $contractEmployees }};
    var departmentsData = @json($departmentsData);

    // Gráficos de Círculo
    new CircleProgress('.employee-progress-permanent', {
        value: {{ round(($permanentEmployees / $totalEmployees) * 100) / 100 }},
        size: 80,
        fill: { color: '#007bff' }
    });
    new CircleProgress('.employee-progress-contract', {
        value: {{ round(($contractEmployees / $totalEmployees) * 100) / 100 }},
        size: 80,
        fill: { color: '#28a745' }
    });

    // Gráfico de Funcionários por Status
    var statusOptions = {
        chart: {
            type: 'bar',
            height: 350
        },
        series: [{
            name: 'Funcionários',
            data: [permanentEmployees, contractEmployees]
        }],
        xaxis: {
            categories: ['Efetivos', 'Contratados']
        },
        colors: ['#007bff', '#28a745'],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '45%'
            }
        },
        dataLabels: {
            enabled: false
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + " funcionários";
                }
            }
        }
    };
    var statusChart = new ApexCharts(document.querySelector("#employeesByStatusChart"), statusOptions);
    statusChart.render();

    // Gráfico de Funcionários por Departamento
    var departmentOptions = {
        chart: {
            type: 'bar',
            height: 350
        },
        series: [{
            name: 'Funcionários',
            data: departmentsData.map(d => d.count)
        }],
        xaxis: {
            categories: departmentsData.map(d => d.name)
        },
        colors: ['#007bff'],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '45%'
            }
        },
        dataLabels: {
            enabled: false
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + " funcionários";
                }
            }
        }
    };
    var departmentChart = new ApexCharts(document.querySelector("#employeesByDepartmentChart"), departmentOptions);
    departmentChart.render();
});
</script>
@endif
@endsection