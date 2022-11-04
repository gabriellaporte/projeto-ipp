@extends('layouts/contentNavbarLayout')

@section('title', 'Pesquisa de Endereços - Minha Conta')


@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Pesquisar /</span> Endereços
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header d-flex flex-column pb-4">Resultados para a pesquisa</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Aniversário</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @forelse($users as $user)
                            <tr>
                                <td class="d-flex justify-content-center" style="display: table-cell !important;">
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
                                            @can('addresses.view')
                                                <a class="dropdown-item show-addresses" href="javascript:void(0);" data-user-id="{{ $user->id }}" data-user-name="{{ $user->getShortName() }}">
                                                    <i class="bx bx-id-card me-1"></i>
                                                    Endereços
                                                </a>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="999">Não conseguimos encontrar nenhum resultado para a busca feita :(</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex w-100 justify-content-center mt-4">
                    {!! $users->withQueryString()->links() !!}
                </div>

            </div>
        </div>
    </div>

    <!-- Modal de Endereços -->
    <div class="modal fade" id="addressModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addressModalTitle">Endereço De</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Voltar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>

        let userMaps = [];

        $(".show-addresses").click(e => {
            let userID = $(e.target).data('user-id');
            let userName = $(e.target).data('user-name');

            $.get('/api/addresses/' + userID).done(data => {
                if ($.isEmptyObject(data)) {
                    return toastr.warning(userName + ' ainda não tem nenhum endereço registrado!');
                }
                let searchParams = new URLSearchParams(window.location.search)
                let city = searchParams.get('search_city');
                let area = searchParams.get('search_area');

                $("#addressModal .modal-body").empty();
                $("#addressModal #addressModalTitle").text('Endereços de ' + userName);

                userMaps = [];

                data.forEach((currentAddress, index) => {
                    // Pular o loop caso a cidade não seja a mesma da busca
                    if(searchParams.has('search_city') && city) {
                        if(currentAddress.city !== city) {
                            return;
                        }
                    }

                    // Pular o loop caso o bairro não seja o mesmo da busca
                    if(searchParams.has('search_area') && area) {
                        if(currentAddress.area !== area) {
                            return;
                        }
                    }

                    console.log(currentAddress);

                    let html = `
                        <div class="row py-4">
                            <div class="col mb-3">
                                <span>
                                    <i class="bx bx-map-pin me-2"></i>${currentAddress.nice_name}
                                </span>
                            </div>
                            <div id="map-${currentAddress.id}" style="height: 250px;">
                            </div>
                        </div>
                    `;

                    $("#addressModal .modal-body").append(html);
                    $.get('https://nominatim.openstreetmap.org/search?format=json&q=' + currentAddress.address + ', ' + currentAddress.house_number + ', ' + currentAddress.area + ', ' + currentAddress.city + ', ' + currentAddress.state, function(data){
                        userMaps.push(L.map('map-' + currentAddress.id).setView([data[0].lat, data[0].lon], 16));
                        let addressInfo = currentAddress.address_complement == null ? currentAddress.address + ', ' + currentAddress.house_number + ', ' + currentAddress.area + ', ' + currentAddress.city : currentAddress.address + ', ' + currentAddress.house_number + ', ' + currentAddress.address_complement + ', ' + currentAddress.area + ', ' + currentAddress.city;

                        L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=xinj6wTWg04tHLy3VyQd',{
                            tileSize: 512,
                            zoomOffset: -1,
                            minZoom: 1,
                            crossOrigin: true
                        }).addTo(userMaps[index]);

                        L.marker([data[0].lat, data[0].lon])
                            .addTo(userMaps[index]).bindPopup(addressInfo);
                        L.circle([data[0].lat, data[0].lon], {color: '#696cff', fillColor: '#696cff', fillOpacity: 0.16, radius: 240})
                            .addTo(userMaps[index]).bindPopup("A precisão do mapa pode ter<br>sido afetada neste raio.");
                    });
                });

                $("#addressModal").modal('show');
            }).fail(() => {
                return toastr.error('Oops! Houve um erro!');
            });
        });

        $("#addressModal").on("shown.bs.modal", () => {
            setTimeout(function() {
                userMaps.forEach( currentMap => {
                    currentMap.invalidateSize();
                });
            }, 1);
        })
    </script>
@endsection
