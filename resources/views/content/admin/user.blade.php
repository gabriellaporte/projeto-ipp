@extends('layouts/contentNavbarLayout')

@section('title', 'Membros - Admin')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Admin /</span> Membros
    </h4>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <div class="card-header d-flex flex-column flex-sm-row align-items-center justify-content-between">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal" @cannot('users.edit') disabled @endcannot>Adicionar Membro</button>
                    <form id="searchForm" class="d-flex">
                        <input type="text" name="filter[name]" class="form-control border-0 shadow-none" placeholder="Pesquisar..." aria-label="Search...">
                        <button type="submit" style="border: none; background-color: transparent; color: #697a8d;">
                            <i class="bx bx-search fs-4 lh-0"></i>
                        </button>
                    </form>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>
                                <a href="{{ route('admin.users', [] + (!request()->has('sort') || request()->get('sort') == 'name' ? ['sort' => '-name'] : ['sort' => 'name'])) }}">Nome
                                    <i class='bx bx-filter'></i>
                                </a>
                            </th>
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
                                            @can('addresses.view')
                                                <a class="dropdown-item show-addresses" href="javascript:void(0);" data-user-id="{{ $user->id }}" data-user-name="{{ $user->getShortName() }}">
                                                    <i class="bx bx-id-card me-1"></i>
                                                    Endereços
                                                </a>
                                            @endcan
                                            @can('users.edit')
                                                <a class="dropdown-item" href="{{ route('admin.user.show', $user->id) }}">
                                                    <i class="bx bx-edit-alt me-1"></i>
                                                    Editar
                                                </a>
                                                <a class="dropdown-item delete-user" data-user-id="{{ $user->id }}" href="javascript:void(0);" style="color: red;">
                                                    <i class="bx bx-trash-alt me-1"></i>
                                                    Excluir
                                                </a>
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

    <!-- Modal de Add User -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <form class="modal-content" method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserTitle">Adicionar Novo Membro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{asset('storage/img/avatars/no_avatar_male.png')}}" alt="user-avatar"
                                 class="d-block rounded" height="100" width="100" id="uploadedAvatar"
                                 style="border-radius: 999rem !important;"/>
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Usar nova foto</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" name="profilePicture" class="account-file-input"
                                           hidden accept="image/png, image/jpeg, image/gif"/>
                                </label>
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Resetar</span>
                                </button>

                                <p class="text-muted mb-0">JPG, GIF ou PNG.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="userName" class="form-label">Nome</label><span class="fw-bold text-danger ms-1">*</span>
                                <input class="form-control" type="text" id="userName" name="userName" value="{{ old('userName') }}" placeholder="..." autofocus/>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="emailAddress" class="form-label">E-mail</label><span class="fw-bold text-danger ms-1">*</span>
                                <input class="form-control" type="text" name="emailAddress" id="emailAddress" value="{{ old('emailAddress') }}" placeholder="..."/>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="mobilePhone" class="form-label">Celular</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text highlighted">BR +55</span>
                                    <input class="form-control phone-mask" type="text" id="mobilePhone" name="mobilePhone" value="{{ old('mobilePhone') }}" placeholder="(31) x xxxx-xxxx"/>
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="housePhone" class="form-label">Telefone Fixo</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text highlighted">BR +55</span>
                                    <input class="form-control housephone-mask" type="text" id="housePhone" name="housePhone" value="{{ old('housePhone') }}" placeholder="(31) xxxx-xxxx"/>
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label class="form-label" for="enrollmentOrigin">Igreja de Origem</label>
                                <input type="text" id="enrollmentOrigin" name="enrollmentOrigin" class="form-control" placeholder="..." value="{{ old('enrollmentOrigin') }}"/>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="enrollmentDate" class="form-label">Data de Arrolamento</label>
                                <input class="form-control date-mask" type="text" id="enrollmentDate" name="enrollmentDate" placeholder="xx/xx/xxxx"  value="{{ old('enrollmentDate') }}"/>
                            </div>
                            <div class="mb-3 col-12">
                                <label class="form-label" for="birthDate">Data de Nascimento</label><span class="fw-bold text-danger ms-1">*</span>
                                <input class="form-control date-mask" type="text" id="birthDate" name="birthDate" value="{{ old('birthDate') }}" placeholder="xx/xx/xxxx"/>
                            </div>

                            <div class="mb-3 col-12">
                                <label class="form-label" for="gender">Gênero</label><span class="fw-bold text-danger ms-1">*</span>
                                <select id="gender" name="gender" class="select2 form-select">
                                    <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Feminino</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Voltar</button>
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </div>
            </form>
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

                $("#addressModal .modal-body").empty();
                $("#addressModal #addressModalTitle").text('Endereços de ' + userName);

                userMaps = [];

                data.forEach((currentAddress, index) => {
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
                    console.log(currentAddress);
                    $.get('https://nominatim.openstreetmap.org/search?format=json&q=' + currentAddress.address + ', ' + currentAddress.house_number + ', ' + currentAddress.area + ', ' + currentAddress.city + ', ' + currentAddress.state, function(data){
                        userMaps.push(L.map('map-' + currentAddress.id).setView([data[0].lat, data[0].lon], 16));
                        let addressInfo = currentAddress.address_complement == null ? currentAddress.address + ', ' + currentAddress.house_number + ', ' + currentAddress.area + ', ' + currentAddress.city : currentAddress.address + ', ' + currentAddress.house_number + ', ' + currentAddress.address_complement + ', ' + currentAddress.area + ', ' + currentAddress.city;

                        L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=xinj6wTWg04tHLy3VyQd',{
                            tileSize: 512,
                            zoomOffset: -1,
                            minZoom: 1,
                            crossOrigin: true
                        }).addTo(userMaps[index]);

                        L.marker([data[0].lat, data[0].lon]).addTo(userMaps[index]).bindPopup(addressInfo);
                        L.circle([data[0].lat, data[0].lon], {color: '#696cff', fillColor: '#696cff',fillOpacity: 0.16, radius: 240
                        }).addTo(userMaps[index]).bindPopup("A precisão do mapa pode ter<br>sido afetada neste raio.");
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

    <script>
        $(".delete-user").click( function () {
            let user = $(this).data("user-id");

            let deleteCondition = window.confirm("Você tem certeza que gostaria de deletar este usuário?");

            if(deleteCondition) {
                window.location.href = 'http://localhost:8000/admin/membros/delete/' + user;
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function (e) {
            (function () {
                const deactivateAcc = document.querySelector('#formAccountDeactivation');

                // Update/reset user image of account page
                let accountUserImage = document.getElementById('uploadedAvatar');
                const fileInput = document.querySelector('.account-file-input'),
                    resetFileInput = document.querySelector('.account-image-reset');

                if (accountUserImage) {
                    const resetImage = accountUserImage.src;
                    fileInput.onchange = () => {
                        if (fileInput.files[0]) {
                            accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
                        }
                    };
                    resetFileInput.onclick = () => {
                        fileInput.value = '';
                        accountUserImage.src = resetImage;
                    };
                }
            })();
        });
    </script>

    <script>
        $(document).ready( () => {
            @if(count($errors))
                setTimeout( () => {
                    $("#addUserModal").modal('show');
                }, 1400);
            @endif
        });
    </script>
@endsection
