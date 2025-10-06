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
        <!-- Cards (mantive igual) -->
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
                                    @forelse($departmentHeads as $head)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="avatar-image">
                                                        <img src="{{ $head->photo ? asset('frontend/images/departments/' . $head->photo) : asset('public/assets/images/avatar/default.png') }}" alt="{{ $head->fullName ?? 'Sem Nome' }}" class="img-fluid" />
                                                    </div>
                                                    <a href="{{ route('employeee.show', $head->id) }}">
                                                        <span class="d-block">{{ $head->fullName ?? 'Sem Nome' }}</span>
                                                        <span class="fs-12 d-block fw-normal text-muted">{{ $head->email ?? 'Sem Email' }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>{{ $head->department->title ?? 'Sem Departamento' }}</td>
                                            <td>{{ $head->department->employeee->count() }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Nenhum chefe de departamento encontrado.</td>
                                        </tr>
                                    @endforelse
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
                            <li><a href="javascript:void(0);"><i class="bi bi-arrow-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Gráficos de Círculo -->
            <div class="col-xxl-4">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="hstack justify-content-between mb-4 pb-0">
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
                                            <h6 class="fs-14 text-truncate-1-line">Efetivos</h6>
                                            <div class="fs-12 text-muted"><span class="text-dark fw-medium">Total:</span> {{ $permanentEmployees }}</div>
                                        </div>
                                        <!-- elemento vazio que circle-progress vai preencher -->
                                        <div class="employee-progress-permanent" data-value="{{ $activeEmployees > 0 ? round(($permanentEmployees / $activeEmployees) * 100) / 100 : 0 }}"></div>
                                    </div>
                                    <div class="badge bg-gray-200 text-dark project-mini-card-badge">{{ $activeEmployees > 0 ? round(($permanentEmployees / $activeEmployees) * 100) : 0 }}%</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body border border-dashed border-gray-5 rounded-3 position-relative">
                                    <div class="hstack justify-content-between gap-4">
                                        <div>
                                            <h6 class="fs-14 text-truncate-1-line">Contratados</h6>
                                            <div class="fs-12 text-muted"><span class="text-dark fw-medium">Total:</span> {{ $contractEmployees }}</div>
                                        </div>
                                        <div class="employee-progress-contract" data-value="{{ $activeEmployees > 0 ? round(($contractEmployees / $activeEmployees) * 100) / 100 : 0 }}"></div>
                                    </div>
                                    <div class="badge bg-gray-200 text-dark project-mini-card-badge">{{ $activeEmployees > 0 ? round(($contractEmployees / $activeEmployees) * 100) : 0 }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Funcionários por Categoria (Sales Pipeline Style) -->
        <div class="col-xxl-12 mt-4">
            <div class="card stretch stretch-full">
                <div class="card-header">
                    <h5 class="card-title">Funcionários por Categoria</h5>
                    <div class="card-header-action">
                        <div class="card-header-btn">
                            <div data-bs-toggle="tooltip" title="Delete">
                                <a href="javascript:void(0);" class="avatar-text avatar-xs bg-danger" data-bs-toggle="remove"></a>
                            </div>
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
                                    <i data-feather="more-vertical"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" class="dropdown-item"><i data-feather="at-sign"></i>Novo</a>
                                <a href="javascript:void(0);" class="dropdown-item"><i data-feather="calendar"></i>Evento</a>
                                <a href="javascript:void(0);" class="dropdown-item"><i data-feather="bell"></i>Adiado</a>
                                <a href="javascript:void(0);" class="dropdown-item"><i data-feather="trash-2"></i>Excluído</a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0);" class="dropdown-item"><i data-feather="settings"></i>Configurações</a>
                                <a href="javascript:void(0);" class="dropdown-item"><i data-feather="life-buoy"></i>Dicas</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body custom-card-action">
                    <ul class="nav mb-4 gap-4 sales-pipeline-tabs" role="tablist">
                        @foreach($categoryData as $index => $category)
                            <li class="nav-item" role="presentation">
                                <a href="javascript:void(0);" class="nav-link text-start {{ $index === 0 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#categoryTab{{ $index }}" role="tab">
                                    <span class="fw-semibold text-dark d-block">{{ $category['name'] }}</span>
                                    <span class="amount fs-18 fw-bold my-1 d-block">{{ $category['count'] }}</span>
                                    <span class="deals fs-12 text-muted d-block">{{ $category['count'] }} Funcionários</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach($categoryData as $index => $category)
                            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="categoryTab{{ $index }}" role="tabpanel">
                                <!-- container para ApexCharts (obrigatório ser DIV) -->
                                <div id="categoryChart{{ $index }}" class="apex-chart" style="min-height: 250px;"></div>
                            </div>
                        @endforeach
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
    <!-- [vendors] start -->
    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <!-- vendors.min.js {always must need to be top} -->
    <script src="{{ asset('assets/vendors/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/circle-progress.min.js') }}"></script>
    <!-- [vendors] end -->

    <!-- [common-init] start -->
    <script src="{{ asset('assets/js/common-init.min.js') }}"></script>
    <!-- [common-init] end -->

    <!-- theme customizer (ok to load early) -->
    <script src="{{ asset('assets/js/theme-customizer-init.min.js') }}"></script>

    <script src="https://unpkg.com/feather-icons"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Replace feather icons
            if (typeof feather !== 'undefined' && feather.replace) {
                feather.replace();
            }

            // Dados vindos do controller
            var totalEmployees = {{ $totalEmployees }};
            var activeEmployees = {{ $activeEmployees }};
            var highlightedEmployees = {{ $highlightedEmployees }};
            var retiredEmployees = {{ $retiredEmployees }};
            var totalInterns = {{ $totalInterns }};
            var permanentEmployees = {{ $permanentEmployees }};
            var contractEmployees = {{ $contractEmployees }};

            // category data do controller (JSON)
            var categoryData = {!! $categoryDataJson !!};

            // --- Circle Progress (jQuery plugin style) ---
            try {
                if (typeof jQuery !== 'undefined' && typeof jQuery.fn.circleProgress !== 'undefined') {
                    // Efetivos
                    var valPerm = parseFloat(document.querySelector('.employee-progress-permanent')?.dataset?.value || 0);
                    $('.employee-progress-permanent').circleProgress({
                        value: valPerm,
                        size: 80,
                        thickness: 6,
                        fill: { gradient: ["#007bff"] }
                    });

                    // Contratados
                    var valContr = parseFloat(document.querySelector('.employee-progress-contract')?.dataset?.value || 0);
                    $('.employee-progress-contract').circleProgress({
                        value: valContr,
                        size: 80,
                        thickness: 6,
                        fill: { gradient: ["#28a745"] }
                    });
                } else {
                    console.warn('circleProgress plugin não encontrado. Verifique se assets/vendors/js/circle-progress.min.js está acessível.');
                }
            } catch (err) {
                console.error('Erro ao inicializar circle-progress:', err);
            }

            // --- ApexCharts: inicializar os gráficos por categoria ---
            try {
                if (typeof ApexCharts === 'undefined') {
                    console.warn('ApexCharts não encontrado. Verifique assets/vendors/js/apexcharts.min.js');
                } else {
                    categoryData.forEach(function(cat, idx) {
                        var el = document.getElementById('categoryChart' + idx);
                        if (!el) {
                            console.error('Elemento #categoryChart' + idx + ' não encontrado. Skipping.');
                            return;
                        }

                        var options = {
                            series: [{
                                name: 'Funcionários',
                                data: [cat.count]
                            }],
                            chart: {
                                type: 'bar',
                                height: 250,
                                toolbar: { show: false }
                            },
                            plotOptions: { bar: { horizontal: false, columnWidth: '60%' } },
                            dataLabels: { enabled: false },
                            xaxis: { categories: [cat.name] },
                            colors: ['#007bff'],
                            tooltip: { y: { formatter: function (val) { return val + " funcionários"; } } }
                        };

                        try {
                            var chart = new ApexCharts(el, options);
                            chart.render();
                        } catch (err) {
                            console.error('Erro ao renderizar chart para', cat.name, err);
                        }
                    });
                }
            } catch (err) {
                console.error('Erro geral ao inicializar ApexCharts:', err);
            }

            // --- Carregar dinamicamente reports-sales-init.min.js após init do dashboard ---
            try {
                var script = document.createElement('script');
                script.src = "{{ asset('assets/js/reports-sales-init.min.js') }}";
                script.async = false;
                script.onload = function() {
                    console.info('reports-sales-init.min.js carregado.');
                };
                script.onerror = function() {
                    console.warn('Falha ao carregar reports-sales-init.min.js. Verifique o caminho em public/assets/js/');
                };
                document.body.appendChild(script);
            } catch (err) {
                console.error('Erro ao anexar reports-sales-init script:', err);
            }
        });
    </script>
@endif
@endsection
