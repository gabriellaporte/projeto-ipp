@extends('layouts/commonMaster' )

@php
    /* Display elements */
    $contentNavbar = true;
    $containerNav = ($containerNav ?? 'container-xxl');
    $isNavbar = ($isNavbar ?? true);
    $isMenu = ($isMenu ?? true);
    $isFlex = ($isFlex ?? false);
    $isFooter = ($isFooter ?? true);
    $customizerHidden = ($customizerHidden ?? '');
    $pricingModal = ($pricingModal ?? false);

    /* HTML Classes */
    $navbarDetached = 'navbar-detached';

    /* Content classes */
    $container = ($container ?? 'container-xxl');

	/* Cidades existentes*/
	$cities = \App\Http\Controllers\AddressController::getExistingCities();

	/* Bairros existentes */
	$areas = \App\Http\Controllers\AddressController::getExistingAreas();

	/* Famílias existentes */
	$families = \App\Models\Family::orderBy('name', 'asc')->get();
@endphp

@section('layoutContent')
    <div class="loader">Carregando...</div>

    <div class="layout-wrapper layout-content-navbar {{ $isMenu ? '' : 'layout-without-menu' }}">
        <div class="layout-container">

            @if ($isMenu)
                @include('layouts/sections/menu/verticalMenu')
            @endif


            <!-- Layout page -->
            <div class="layout-page">
                <!-- BEGIN: Navbar-->
                @if ($isNavbar)
                    @include('layouts/sections/navbar/navbar')
                @endif
                <!-- END: Navbar-->


                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->
                    @if ($isFlex)
                        <div class="{{$container}} d-flex align-items-stretch flex-grow-1 p-0">
                            @else
                                <div class="{{$container}} flex-grow-1 container-p-y">
                                    @endif

                                    @yield('content')

                                </div>
                                <!-- / Content -->

                                <!-- Footer -->
                                @include('layouts/sections/footer/footer')
                                <!-- / Footer -->
                                <div class="content-backdrop fade"></div>
                        </div>
                        <!--/ Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>

            @if ($isMenu)
                <!-- Overlay -->
                <div class="layout-overlay layout-menu-toggle"></div>
            @endif
            <!-- Drag Target Area To SlideIn Menu On Small Screens -->
            <div class="drag-target"></div>

            <!-- Modal de adição de notificações -->
            <div class="modal fade" id="advancedSearchModal" data-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pesquisa Avançada</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="my-2 d-flex justify-content-center">
                                <ul class="nav nav-pills mb-3" role="tablist">
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#userSearch">Membros</button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" @cannot('addresses.read') disabled title="Somente oficias podem acessar aqui!" style="cursor: not-allowed;" @endcan class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#addressSearch">Endereço</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content pt-0">
                                <form class="tab-pane fade show active" id="userSearch" method="GET" action="{{ route('search.members') }}">
                                    @csrf
                                    <div class="modal-body py-3">
                                        <div class="row">
                                            <div class="mb-4 col-12">
                                                <label for="search_name" class="form-label">Nome ou parte do nome</label>
                                                <input class="form-control" type="text" id="search_name" name="search_name" value="{{ request()->get('search_name') }}" placeholder="..."/>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label for="search_family" class="form-label">Família</label>
                                                <select name="search_family" id="search_family" class="form-control select2">
                                                    <option selected value="">Todas</option>
                                                    @foreach($families as $family)
                                                        <option value="{{ $family->id }}" {{ request()->get('search_family') == $family->id ? 'selected' : '' }}>{{ $family->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="row mb-4 pe-sm-0">
                                                <strong class="text-center mb-1">NASCIMENTO</strong>
                                                <div class="col-12 col-sm-6">
                                                    <label for="search_since" class="form-label">De</label>
                                                    <input class="form-control" type="date" id="search_since" name="search_since" value="{{ request()->get('search_since') }}" placeholder="..."/>
                                                </div>
                                                <div class="col-12 col-sm-6 pe-sm-0">
                                                    <label for="search_to" class="form-label">Até</label>
                                                    <input class="form-control" type="date" id="search_to" name="search_to" value="{{ request()->get('search_to') }}" placeholder="..."/>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label for="search_gender" class="form-label">Gênero</label>
                                                <select name="search_gender" id="search_gender" class="form-control">
                                                    <option selected value="">Ambos</option>
                                                    <option {{ request()->get('search_gender') == 'M' ? 'selected' : '' }} value="M">Masculino</option>
                                                    <option {{ request()->get('search_gender') == 'F' ? 'selected' : '' }} value="F">Feminino</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Voltar</button>
                                        <button type="submit" class="btn btn-primary">Pesquisar Membro</button>
                                    </div>
                                </form>
                                <form class="tab-pane fade" id="addressSearch" method="GET" action="{{ route('search.addresses') }}">
                                    @csrf
                                    <div class="modal-body py-3">
                                        <div class="row">
                                            <div class="mb-3 col-12">
                                                <label for="search_city" class="form-label">Cidade</label>
                                                <select name="search_city" id="search_city" class="form-control select2">
                                                    <option disabled selected value="">Selecione uma cidade</option>
                                                    <option value="">Todas as cidades</option>
                                                    @foreach($cities as $cities)
                                                        <option value="{{ $cities }}">{{ $cities }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label for="search_area" class="form-label">Bairro</label>
                                                <select name="search_area" id="search_area" class="form-control select2">
                                                    <option disabled selected value="">Selecione um bairro</option>
                                                    <option value="">Todos os bairros</option>
                                                    @foreach($areas as $area)
                                                        <option value="{{ $area }}">{{ $area }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <p class="text-center">Deseja ver o mapa completo? <a href="{{ route('search.addresses.map') }}" class="cursor-pointer">Clique aqui!</a></p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Voltar</button>
                                        <button type="submit" class="btn btn-primary">Pesquisar Endereço</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <!-- / Layout wrapper -->
@endsection
