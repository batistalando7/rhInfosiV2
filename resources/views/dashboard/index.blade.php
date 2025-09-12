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
                                    <i data-feather="users"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $totalEmployees }}</div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">Total de Funcionários</h3>
                                </div>
                            </div>
                            <a href="{{ route('employeee.index') }}" class="">
                                <i data-feather="more-vertical"></i>
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
                                    <i data-feather="user-check"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $activeEmployees }}</div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">Funcionários Ativos</h3>
                                </div>
                            </div>
                            <a href="{{ route('employeee.filterByStatus', ['status' => 'active']) }}" class="">
                                <i data-feather="more-vertical"></i>
                            </a>
                        </div>
                        <div class="pt-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('employeee.filterByStatus', ['status' => 'active']) }}" class="fs-12 fw-medium text-muted text-truncate-1-line">Ver Detalhes</a>
                                <div class="w-100 text-end">
                                    <span class="fs-12 text-dark">{{ $activeEmployees }}</span>
                                    <span class="fs-11 text-muted">({{ $totalEmployees > 0 ? round(($activeEmployees / $totalEmployees) * 100) : 0 }}%)</span>
                                </div>
                            </div>
                            <div class="progress mt-2 ht-3">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $totalEmployees > 0 ? round(($activeEmployees / $totalEmployees) * 100) : 0 }}%"></div>
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
                                    <i data-feather="briefcase"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $highlightedEmployees }}</div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">Funcionários Destacados</h3>
                                </div>
                            </div>
                            <a href="{{ route('secondment.index') }}" class="">
                                <i data-feather="more-vertical"></i>
                            </a>
                        </div>
                        <div class="pt-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('secondment.index') }}" class="fs-12 fw-medium text-muted text-truncate-1-line">Ver Detalhes</a>
                                <div class="w-100 text-end">
                                    <span class="fs-12 text-dark">{{ $highlightedEmployees }}</span>
                                    <span class="fs-11 text-muted">({{ $totalEmployees > 0 ? round(($highlightedEmployees / $totalEmployees) * 100) : 0 }}%)</span>
                                </div>
                            </div>
                            <div class="progress mt-2 ht-3">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $totalEmployees > 0 ? round(($highlightedEmployees / $totalEmployees) * 100) : 0 }}%"></div>
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
                                    <i data-feather="user-x"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $retiredEmployees }}</div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">Funcionários Reformados</h3>
                                </div>
                            </div>
                            <a href="{{ route('retirements.index') }}" class="">
                                <i data-feather="more-vertical"></i>
                            </a>
                        </div>
                        <div class="pt-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('retirements.index') }}" class="fs-12 fw-medium text-muted text-truncate-1-line">Ver Detalhes</a>
                                <div class="w-100 text-end">
                                    <span class="fs-12 text-dark">{{ $retiredEmployees }}</span>
                                    <span class="fs-11 text-muted">({{ $totalEmployees > 0 ? round(($retiredEmployees / $totalEmployees) * 100) : 0 }}%)</span>
                                </div>
                            </div>
                            <div class="progress mt-2 ht-3">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $totalEmployees > 0 ? round(($retiredEmployees / $totalEmployees) * 100) : 0 }}%"></div>
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
                                    <i data-feather="book-open"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $totalInterns }}</div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">Estagiários</h3>
                                </div>
                            </div>
                            <a href="{{ route('intern.index') }}" class="">
                                <i data-feather="more-vertical"></i>
                            </a>
                        </div>
                        <div class="pt-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('intern.index') }}" class="fs-12 fw-medium text-muted text-truncate-1-line">Ver Detalhes</a>
                                <div class="w-100 text-end">
                                    <span class="fs-12 text-dark">{{ $totalInterns }}</span>
                                    <span class="fs-11 text-muted">({{ $totalInterns > 0 ? 100 : 0 }}%)</span>
                                </div>
                            </div>
                            <div class="progress mt-2 ht-3">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $totalInterns > 0 ? 100 : 0 }}%"></div>
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
                                <div data-bs-toggle="tooltip" title="Maximize/Minimize">
                                    <a href="javascript:void(0);" class="avatar-text avatar-xs bg-success" data-bs-toggle="expand"></a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="avatar-text avatar-sm" data-bs-toggle="dropdown" data-bs-offset="25, 25">
                                    <div data-bs-toggle="tooltip" title="Opções">
                                        <i data-feather="more-vertical"></i>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('employeee.index') }}" class="dropdown-item"><i data-feather="users"></i>Ver Todos</a>
                                    <a href="javascript:void(0);" class="dropdown-item"><i data-feather="settings"></i>Configurações</a>
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
                            <li><a href("javascript:void(0);"><i class="bi bi-arrow-right"></i></a></li>
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
                                    <div class="badge bg-gray-200 text-dark project-mini-card-badge">{{ $activeEmployees > 0 ? round(($permanentEmployees / $activeEmployees) * 100) : 0 }}%</div>
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
                                    <div class="badge bg-gray-200 text-dark project-mini-card-badge">{{ $activeEmployees > 0 ? round(($contractEmployees / $activeEmployees) * 100) : 0 }}%</div>
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
<script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/circle-progress.min.js') }}"></script> <!-- Usando arquivo local -->
<script src="{{ asset('assets/js/common-init.min.js') }}"></script>
<!-- <script src="{{ asset('assets/js/dashboard-init.min.js') }}"></script> --> <!-- Temporariamente removido -->
<script src="{{ asset('assets/js/theme-customizer-init.min.js') }}"></script>
<script src="https://unpkg.com/feather-icons"></script>

<!-- Fallback para CircleProgress se o local falhar -->
<script>
let circleProgressLoaded = false;
function loadCircleProgress() {
    return new Promise((resolve, reject) => {
        if (typeof CircleProgress !== 'undefined') {
            circleProgressLoaded = true;
            console.log('CircleProgress já carregado (local)');
            resolve();
        } else {
            const script = document.createElement('script');
            script.src = 'https://unpkg.com/circle-progress@1.0.0/dist/circle-progress.min.js'; // Fallback CDN alternativo
            script.onload = () => {
                circleProgressLoaded = true;
                console.log('CircleProgress carregado via CDN alternativo');
                resolve();
            };
            script.onerror = () => reject(new Error('Falha ao carregar CircleProgress via CDN'));
            document.head.appendChild(script);
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
    try {
        // Inicializar Feather Icons
        feather.replace();

        // Dados dos cards
        var totalEmployees = {{ $totalEmployees }};
        var activeEmployees = {{ $activeEmployees }};
        var highlightedEmployees = {{ $highlightedEmployees }};
        var retiredEmployees = {{ $retiredEmployees }};
        var totalInterns = {{ $totalInterns }};
        var permanentEmployees = {{ $permanentEmployees }};
        var contractEmployees = {{ $contractEmployees }};
        var departmentsData = @json($departmentsData ?? []);

        // Debug detalhado dos dados
        console.log('Dados completos de departmentsData:', departmentsData);

        // Carregar CircleProgress e inicializar gráficos de círculo
        loadCircleProgress().then(() => {
            if (circleProgressLoaded) {
                new CircleProgress('.employee-progress-permanent', {
                    value: {{ $activeEmployees > 0 ? round(($permanentEmployees / $activeEmployees) * 100) / 100 : 0 }},
                    size: 80,
                    fill: { color: '#007bff' }
                });
                new CircleProgress('.employee-progress-contract', {
                    value: {{ $activeEmployees > 0 ? round(($contractEmployees / $activeEmployees) * 100) / 100 : 0 }},
                    size: 80,
                    fill: { color: '#28a745' }
                });
                console.log('Gráficos de círculo inicializados');
            } else {
                console.error('CircleProgress não carregou corretamente');
            }
        }).catch(error => console.error('Erro ao carregar CircleProgress:', error));

        // Gráfico de Funcionários por Status
        if (permanentEmployees + contractEmployees > 0) {
            var statusOptions = {
                chart: { type: 'bar', height: 350 },
                series: [{ name: 'Funcionários', data: [permanentEmployees, contractEmployees] }],
                xaxis: { categories: ['Efetivos', 'Contratados'] },
                colors: ['#007bff', '#28a745'],
                plotOptions: { bar: { horizontal: false, columnWidth: '45%' } },
                dataLabels: { enabled: false },
                tooltip: { y: { formatter: val => val + " funcionários" } }
            };
            var statusChart = new ApexCharts(document.querySelector("#employeesByStatusChart"), statusOptions);
            statusChart.render().then(() => console.log('Gráfico por Status renderizado')).catch(error => console.error('Erro no Gráfico por Status:', error));
        } else {
            document.querySelector("#employeesByStatusChart").innerHTML = '<p class="text-center text-muted">Nenhum dado disponível</p>';
        }

        // Gráfico de Funcionários por Departamento (Donut Moderno)
        if (Array.isArray(departmentsData) && departmentsData.length > 0) {
            var departmentOptions = {
                chart: { type: 'donut', height: 350, animations: { enabled: true, easing: 'easeinout', speed: 800 } },
                series: departmentsData.map(d => d.count || 0),
                labels: departmentsData.map(d => d.title || 'Sem Título'),
                colors: ['#00bcd4', '#ff9800', '#9c27b0', '#3f51b5', '#f44336'], // Gradientes tecnológicos
                fill: { type: 'gradient', gradient: { shade: 'dark', type: 'horizontal', shadeIntensity: 0.5, gradientToColors: ['#e0f7fa', '#ffe0b2', '#d1c4e9', '#c5cae9', '#ef9a9a'] } },
                stroke: { width: 0 },
                dataLabels: { enabled: true, style: { colors: ['#fff'] }, formatter: val => val + "%" },
                legend: { position: 'bottom', horizontalAlign: 'center', fontSize: '14px', fontFamily: 'Helvetica, Arial, sans-serif' },
                responsive: [{
                    breakpoint: 480,
                    options: { chart: { width: 200 }, legend: { position: 'bottom' } }
                }],
                tooltip: { y: { formatter: val => val + " funcionários" } }
            };
            var departmentChart = new ApexCharts(document.querySelector("#employeesByDepartmentChart"), departmentOptions);
            departmentChart.render().then(() => console.log('Gráfico por Departamento renderizado')).catch(error => console.error('Erro no Gráfico por Departamento:', error));
        } else {
            document.querySelector("#employeesByDepartmentChart").innerHTML = '<p class="text-center text-muted">Nenhum dado disponível para departamentos</p>';
            console.log('Nenhum dado disponível para o gráfico de departamentos');
        }
    } catch (e) {
        console.error('Erro no JS do Dashboard:', e);
    }
});
</script>
@endif
@endsection