@extends('layouts.contentNavbarLayout')

@section('title', 'Página Inicial')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Bem vindo, {{ explode(' ', auth()->user()->name)[0] }}!
                                🎉</h5>
                            <p class="mb-4">Comece a navegar clicando no <span class="fw-bold">menu</span> à
                                esquerda.<br>Seu último
                                login foi em <span
                                    class="fw-bold">{{ \Carbon\Carbon::parse(auth()->user()->previous_last_login)->translatedFormat('d/M/Y à\s H:m') }}</span>
                            </p>

                            <a href="javascript:;" class="btn btn-sm btn-outline-primary">Ver Notificações</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{asset('assets/img/illustrations/man-with-laptop-light.png')}}" height="140"
                                 alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                 data-app-light-img="illustrations/man-with-laptop-light.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body px-3">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{asset('assets/img/icons/unicons/cc-primary.png')}}" alt="Credit Card"
                                         class="rounded">
                                </div>

                            </div>
                            <span class="fw-semibold d-block mb-1">Dízimos</span>
                            <h3 class="card-title mb-2">R$ 6,540.53</h3>
                            <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> + R$
                                1,540.53</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body px-3">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{asset('assets/img/icons/unicons/wallet-info.png')}}" alt="Credit Card"
                                         class="rounded">
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Ofertas</span>
                            <h3 class="card-title text-nowrap mb-2">R$ 10,450.35</h3>
                            <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> + R$
                                1,320.05</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gráfico -->
        <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-12 p-2">
                        <h5 class="card-title text-center pt-3 ">Gráfico de Movimentação Financeira</h5>

                        <canvas id="financesChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Total Revenue -->
        <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
            <div class="card mb-3" style="height: calc(100% - 24px);">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2 mb-1">Meus Últimos Registros</h5>
                    <h6 class="mb-0 text-success"><i class='bx bx-check-double'></i> R$ 2.270,60</h6>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{asset('assets/img/icons/unicons/cc-primary.png')}}" alt="Credit Card"
                                     class="rounded">
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Dízimo</small>
                                    <h6 class="mb-0">29/07/2022</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0"><span class="text-muted">+</span> R$ 880,00</h6>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{asset('assets/img/icons/unicons/cc-primary.png')}}" alt="Credit Card"
                                     class="rounded">
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Dízimo</small>
                                    <h6 class="mb-0">26/06/2022</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0"><span class="text-muted">+</span> R$ 650,30</h6>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{asset('assets/img/icons/unicons/wallet-info.png')}}" alt="User"
                                     class="rounded">
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Ofertas</small>
                                    <h6 class="mb-0">26/06/2022</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0"><span class="text-muted">+</span> R$ 50,00</h6>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{asset('assets/img/icons/unicons/cc-primary.png')}}" alt="Credit Card"
                                     class="rounded">
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Dízimo</small>
                                    <h6 class="mb-0">06/05/2022</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0"><span class="text-muted">+</span> R$ 650,30</h6>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{asset('assets/img/icons/unicons/wallet-info.png')}}" alt="User"
                                     class="rounded">
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Ofertas</small>
                                    <h6 class="mb-0">06/05/2022</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0"><span class="text-muted">+</span> R$ 20,00</h6>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{asset('assets/img/icons/unicons/wallet-info.png')}}" alt="User"
                                     class="rounded">
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Ofertas</small>
                                    <h6 class="mb-0">29/04/2022</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0"><span class="text-muted">+</span> R$ 20,00</h6>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @can('users.read')
        <div class="row">
            <div class="col-12">
                <div class="card pb-5" id="membersTableCard">
                    <div class="card-header d-flex flex-column flex-sm-row align-items-center justify-content-between">
                        <h5 class="mb-0 py-3">Membros e Pastores da IPP</h5>
                        <form id="searchForm" class="d-flex">
                            <input type="text" name="filter[name]" class="form-control border-0 shadow-none"
                                   placeholder="Pesquisar..." aria-label="Search...">
                            <button type="submit" style="border: none; background-color: transparent; color: #697a8d;">
                                <i class="bx bx-search fs-4 lh-0"></i></button>
                        </form>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>
                                    <a href="{{ route('index', [] + (!request()->has('sort') || request()->get('sort') == 'name' ? ['sort' => '-name'] : ['sort' => 'name'])) }}">Nome
                                        <i class='bx bx-filter'></i></a></th>
                                <th>E-mail</th>
                                <th>Telefone</th>
                                <th>Aniversário</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @foreach($users as $user)
                                <tr>
                                    <td class="d-flex justify-content-center">
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                            class="avatar avatar-xs pull-up" title=""
                                            data-bs-original-title="Foto de {{ explode(' ', $user->name)[0] }}"><img
                                                src="{{asset('storage/' . $user->profile_picture )}}" alt="Avatar"
                                                class="rounded-circle"></li>
                                    </td>
                                    <td><strong>{{ $user->name  }}</strong></td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile_phone  }}</td>
                                    <td>{{ \Carbon\Carbon::parse($user->birth_date)->translatedFormat('d/m/Y')  }}</td>
                                    <td>
                                        @if($user->hasRole(['Oficial']))
                                            <span class="badge bg-label-info me-1">Oficial</span>
                                        @else
                                            <span class="badge bg-label-primary me-1">Membro</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="true"><i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu"
                                                 style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(-145px, 27px);"
                                                 data-popper-placement="bottom-end">
                                                @can('users.edit')
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex w-100 justify-content-center mt-4">
                        {!! $users->links() !!}
                    </div>
                </div>
            </div>
        </div>
    @endcan

@endsection

@section('page-script')
    <script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>

    <script>
        const ctx = $('#financesChart');

        var chartConfig = {
            type: 'line',
            data: {
                labels: ['Abril', 'Maio', 'Junho', 'Julho', 'Agosto'],
                datasets: [{
                    label: 'Dízimos',
                    backgroundColor: "rgba(105, 108, 255, 1)",
                    borderColor: "rgb(105, 108, 255, 1)",
                    fill: false,
                    data: [50, 140, 90, 120, 200, 200, 140],
                }, {
                    label: 'Ofertas',
                    backgroundColor: "rgba(3, 195, 236, 1)",
                    borderColor: "rgb(3, 195, 236, 1)",
                    fill: false,
                    data: [50, 180, 100, 200, 150, 200, 170],
                }]
            },
            options: {
                animation: false,
                tension: 0.4,
                responsive: true,
                title: {
                    display: true,
                    text: 'Chart.js Line Chart - Logarithmic'
                },
                scales: {
                    x: {
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Date'
                        },
                    },
                    y: {
                        ticks: {
                            min: 0,
                            max: 500,
                            // forces step size to be 5 units
                            stepSize: 100,
                            callback: function (value, index, ticks) {
                                return value.toLocaleString("pt-BR", {style: "currency", currency: "BRL"});
                            }
                        },
                        //type: 'logarithmic',
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Index Returns'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('pt-BR', {
                                        style: 'currency',
                                        currency: 'BRL'
                                    }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        };

        // render init block
        const myChart = new Chart(
            ctx,
            chartConfig
        );

    </script>

    <script async defer>
        let urlParams = new URLSearchParams(window.location.search);
        setTimeout(() => {
            if (urlParams.has('page') || urlParams.has('filter[name]')) {
                console.log('scroll');
                $('html, body').animate({
                    scrollTop: $("#membersTableCard").offset().top
                }, 500);
            }
        }, 1000);
    </script>
@endsection
