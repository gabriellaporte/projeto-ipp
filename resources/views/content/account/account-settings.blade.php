@extends('layouts/contentNavbarLayout')

@section('title', 'Configurações do Perfil - Minha Conta')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        @if($editing === true)
            <span class="text-muted fw-light">Admin / Membros / </span> {{ $user->name }}
        @else
            <span class="text-muted fw-light">Conta /</span> Configurações de Perfil
        @endif
    </h4>

    <div class="row">
        <div class="col-md-12">
            @if($editing === false)
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Configurações de Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('account.notifications.config.edit') }}"><i class="bx bx-bell me-1"></i> Configurações de Notificações</a>
                </li>
            </ul>
            @endif
            <div class="card mb-4">
                <h5 class="card-header d-flex flex-column pb-2">Detalhes do Perfil
                    <span class="text-muted mt-1 fw-semibold" style="font-size: 0.8rem;">(Atualizado em {{ \Carbon\Carbon::parse($user->updated_at)->translatedFormat('d/m/Y à\s H:m') }})</span>
                </h5>
                <!-- Account -->
                <form id="formAccountSettings" method="POST"  action="{{ $editing ? route('admin.members.update', $user->id) : route('account.settings.update', $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{asset('storage/' . $user->profile_picture )}}" alt="user-avatar"
                                 class="d-block rounded" height="100" width="100" id="uploadedAvatar"
                                 style="border-radius: 999rem !important;"/>
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Usar nova foto</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" name="profile_picture" class="account-file-input"
                                           hidden accept="image/png, image/jpeg, image/gif"/>
                                </label>
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Resetar</span>
                                </button>

                                <p class="text-muted mb-0">Permitido formatos JPG, GIF ou PNG. Tamanho máximo de 4MB</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="userName" class="form-label">Nome</label>
                                <input class="form-control" type="text" id="userName" name="name"
                                       value="{{ $user->name }}" autofocus @cannot('users.edit') readonly @endcannot/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="emailAddress" class="form-label">E-mail</label>
                                <input class="form-control" type="text" name="email" id="emailAddress"
                                       value="{{ $user->email }}"/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="mobilePhone" class="form-label">Celular</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text highlighted">BR +55</span>
                                    <input class="form-control phone-mask" type="text" id="mobilePhone"
                                           name="mobile_phone" value="{{ $user->mobile_phone }}"
                                           placeholder="(31) x xxxx-xxxx"/>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="housePhone" class="form-label">Telefone Fixo</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text highlighted">BR +55</span>
                                    <input class="form-control housephone-mask" type="text" id="housePhone"
                                           name="house_phone" placeholder="(31) xxxx-xxxx"
                                           value="{{ $user->house_phone }}"/>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="enrollmentOrigin">Igreja de Origem</label>
                                <input type="text" id="enrollmentOrigin" name="enrollment_origin" class="form-control"
                                       placeholder="..." value="{{ $user->enrollment_origin }}"
                                       @cannot('users.edit') readonly @endcannot/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="enrollmentDate" class="form-label">Data de Arrolamento</label>
                                <input class="form-control date-mask" type="text" id="enrollmentDate"
                                       name="enrollment_date" placeholder="xx/xx/xxxx"
                                       value="{{ !is_null($user->enrollment_date) ? \Carbon\Carbon::parse($user->enrollment_date)->format('d/m/Y') : ''}}"
                                       @cannot('users.edit') readonly @endcannot/>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="birthDate">Data de Nascimento</label>
                                <input class="form-control date-mask" type="text" id="birthDate" name="birth_date"
                                       placeholder="xx/xx/xxxx"
                                       value="{{ \Carbon\Carbon::parse($user->birth_date)->format('d/m/Y') }}"/>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="gender">Gênero</label>
                                <select id="gender" name="gender" class="select2 form-select"
                                        @cannot('users.edit') disabled @endcannot>
                                    <option value="M" {{ $user->gender == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ $user->gender == 'F' ? 'selected' : '' }}>Feminino</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="roles" class="form-label">Cargos</label>
                                <select id="roles" name="roles[]" class="select2 form-select" multiple
                                        @cannot('roles.assign') disabled @endcannot>
                                    <optgroup label="Seus cargos">
                                        @foreach($roles as $role)
                                            <option
                                                value="{{ $role->id }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="family" class="form-label">Família</label>
                                <select id="family" name="family_id" class="select2 form-select" @cannot('user.edit') disabled @endcannot>
                                    <optgroup label="Selecione a família de {{ explode(' ', $user->name)[0] }}">
                                        <option {{ is_null($user->family_id) ? 'selected' : '' }} value="">Nenhuma</option>
                                        @foreach($families as $family)
                                            <option
                                                value="{{ $family->id }}" {{ $user->family_id == $family->id ? 'selected' : '' }}>{{ $family->name }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Salvar</button>
                            <button type="reset" class="btn btn-outline-secondary"
                                    onclick="document.location.reload(false)">Recarregar
                            </button>
                        </div>
                    </div>
                </form>
                <!-- /Account -->
            </div>
            <div class="card">
                <h5 class="card-header">{{ $editing ? 'Endereços de ' . $user->getShortName() : 'Meus Endereços' }}</h5>
                <div class="card-body">
                    <button type="button" id="addAddress" class="btn btn-outline-primary mb-3">
                        <span class="tf-icons bx bx-bookmark-alt-plus"></span>&nbsp; Adicionar
                    </button>
                    @if(!$editing)
                        <div class="mb-3 col-12 d-flex justify-content-center">
                            <div class="alert alert-primary d-inline-block mb-0 text-center" role="alert">
                                <i class="bx bx-info-circle d-none d-sm-inline-block" style="margin-top: -2px;"></i>&nbsp;
                                Os seus endereços são privados e somente oficiais conseguem vê-los!&nbsp;
                                <button type="button" class="btn-close d-none d-sm-inline-block" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    <form id="formAddresses" method="POST" action="{{ route('account.addresses.sync') }}">
                        @csrf

                        @if(is_null(old('nice_name')))
                            <!-- Se não tiver nenhum endereço em edição, irá puxar do banco de dados -->
                            @forelse($addresses as $address)
                                <div class="input-wrapper row"
                                     style="{{ ((!is_null(old('niceName')) && count(old('niceName'))) || count($addresses) > 1) && !$loop->last ? 'box-shadow: rgb(9, 3, 104) 0px 24px 3px -24px; margin-bottom: 20px; padding-bottom: 10px;' : ''}}">
                                    <div class="mb-3 col-md-6">
                                            <label for="niceName" class="form-label">Apelido <span class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control" type="text" id="niceName" name="nice_name[]"
                                               value="{{ $address->nice_name ?? ""}}" placeholder="Ex: Casa"/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="cep" class="form-label">CEP <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control cep-mask" type="text" name="cep[]" id="cep"
                                               value="{{ $address->cep ?? "" }}" placeholder="xxxxx-xxx"/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="address" class="form-label">Endereço <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control" type="text" name="address[]" id="address"
                                               value="{{ $address->address ?? "" }}" placeholder="..."/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="area" class="form-label">Bairro <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control" type="text" name="area[]" id="area"
                                               value="{{ $address->area ?? "" }}" placeholder="..."/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="houseNumber" class="form-label">Número <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control" type="text" name="house_number[]" id="houseNumber"
                                               value="{{ $address->house_number ?? "" }}" placeholder="..."/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="addressComplement" class="form-label">Complemento</label>
                                        <input class="form-control" type="text" name="address_complement[]"
                                               id="addressComplement" value="{{ $address->address_complement ?? "" }}"
                                               placeholder="..."/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="city" class="form-label">Cidade <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control" type="text" name="city[]" id="city"
                                               value="{{ $address->city ?? "" }}" placeholder="..."/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="state" class="form-label">Estado <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control" type="text" name="state[]" id="state"
                                               value="{{ $address->state ?? "" }}" placeholder="..."/>
                                    </div>
                                    <div class="mb-3 col-12 d-flex justify-content-end">
                                        <a class="destroy-address" href="{{ route('account.addresses.destroy', $address->id) }}">
                                            <button type="button"
                                                    class="btn rounded-pill btn-icon btn-danger remove-btn"><span
                                                    class="tf-icons bx bx-trash"></span></button>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <!-- Caso não tenha nem em edição e nem no banco de dados -->
                                <div class="input-wrapper row"
                                     style="{{ ((!is_null(old('niceName')) && count(old('niceName'))) || count($addresses) > 1) && $loop->first ? 'box-shadow: rgb(9, 3, 104) 0px 24px 3px -24px; margin-bottom: 20px; padding-bottom: 10px;' : ''}}">
                                    <div class="mb-3 col-md-6">
                                        <label for="niceName" class="form-label">Apelido <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control" type="text" id="niceName" name="nice_name[]"
                                               placeholder="Ex: Casa"/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="cep" class="form-label">CEP <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control cep-mask" type="text" name="cep[]" id="cep"
                                               placeholder="xxxxx-xxx"/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="address" class="form-label">Endereço <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control" type="text" name="address[]" id="address"
                                               placeholder="..."/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="area" class="form-label">Bairro <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control" type="text" name="area[]" id="area"
                                               placeholder="..."/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="houseNumber" class="form-label">Número <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control" type="text" name="house_number[]" id="houseNumber"
                                               placeholder="..."/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="addressComplement" class="form-label">Complemento</label>
                                        <input class="form-control" type="text" name="address_complement[]"
                                               id="addressComplement" placeholder="..."/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="city" class="form-label">Cidade <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control" type="text" name="city[]" id="city"
                                               placeholder="..."/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="state" class="form-label">Estado <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control" type="text" name="state[]" id="state"
                                               placeholder="..."/>
                                    </div>
                                    <div class="mb-3 col-12 d-flex justify-content-end">
                                        <button type="button"
                                                class="btn rounded-pill btn-icon btn-danger remove-address"><span
                                                class="tf-icons bx bx-trash"></span></button>
                                    </div>
                                </div>
                            @endforelse
                        @else

                            <!-- Mostrar os inputs caso o usuário já esteja editando -->
                            @for($i = 0; $i < count(old('niceName')); $i++)
                                <div class="input-wrapper row"
                                     style="{{ $i < count(old('niceName')) - 1 ? 'box-shadow: rgb(9, 3, 104) 0px 24px 3px -24px; margin-bottom: 20px; padding-bottom: 10px;' : ''}}">
                                    <div class="mb-3 col-md-6">
                                        <label for="niceName" class="form-label">Apelido <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control" type="text" id="niceName" name="nice_name[]"
                                               value="{{ old('nice_name')[$i] ?? "" }}" placeholder="Ex: Casa"/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="cep" class="form-label">CEP <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control cep-mask" type="text" name="cep[]" id="cep"
                                               value="{{ old('cep')[$i] ?? "" }}" placeholder="xxxxx-xxx"/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="address" class="form-label">Endereço <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control" type="text" name="address[]" id="address"
                                               value="{{ old('address')[$i] ?? "" }}" placeholder="..."/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="area" class="form-label">Bairro <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control" type="text" name="area[]" id="area"
                                               value="{{ old('area')[$i] ?? "" }}" placeholder="..."/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="houseNumber" class="form-label">Número <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control" type="text" name="house_number[]" id="houseNumber"
                                               value="{{ old('house_number')[$i] ?? "" }}" placeholder="..."/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="addressComplement" class="form-label">Complemento</label>
                                        <input class="form-control" type="text" name="address_complement[]"
                                               id="addressComplement" value="{{ old('address_complement')[$i] ?? "" }}"
                                               placeholder="..."/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="city" class="form-label">Cidade <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control" type="text" name="city[]" id="city"
                                               value="{{ old('city')[$i] ?? "" }}" placeholder="..."/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="state" class="form-label">Estado <span
                                                class="fw-bold text-danger ms-1">*</span></label>
                                        <input class="form-control" type="text" name="state[]" id="state"
                                               value="{{ old('state')[$i] ?? "" }}" placeholder="..."/>
                                    </div>
                                    <div class="mb-3 col-12 d-flex justify-content-end">
                                        <button type="button"
                                                class="btn rounded-pill btn-icon btn-danger remove-address"><span
                                                class="tf-icons bx bx-trash"></span></button>
                                    </div>
                                </div>
                            @endfor

                        @endif
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Salvar</button>
                            <button type="submit" form="flushAddressesForm" class="btn btn-outline-danger">Remover Todos</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <form id="flushAddressesForm" method="POST" action="{{ route('account.addresses.flush') }}">
        @method('DELETE')
        @csrf
    </form>
    @endsection

@section('page-script')
    <script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>

    <script>
        $(document).ready(($) => {
            $(document).on('keyup', '#formAddresses .cep-mask', e => {
                let el = $(e.target);
                let elWrapper = el.closest('.input-wrapper');

                if (el.val().length !== 9) {
                    return;
                }

                let cep = el.val().replace(/\D/g, '');
                let regexPattern = /^[0-9]{8}$/;

                if (!regexPattern.test(cep)) {
                    return;
                }

                $.ajax({
                    url: 'https://viacep.com.br/ws/' + cep + '/json',
                    dataType: 'jsonp',
                    crossDomain: true,
                    contentType: 'application/json',
                    success: (data) => {
                        elWrapper.find('#address').val(data.logradouro);
                        elWrapper.find('#area').val(data.bairro);
                        elWrapper.find('#city').val(data.localidade);
                        elWrapper.find('#state').val(data.uf);

                        elWrapper.find('#houseNumber').focus();
                    }
                });
            });
        });
    </script>

    <script>
        $("#addAddress").click(() => {
            let hasEmptyInputs = false;

            $("#formAddresses .input-wrapper").each((i, el) => {
                let emptyInputs = $(el).find('input').not('#addressComplement').filter(function () {
                    return $.trim($(this).val()).length == 0
                }).length;

                if (emptyInputs) {
                    hasEmptyInputs = true;
                }
            });

            if (hasEmptyInputs) {
                return toastr.warning('Preencha todos os campos obrigatórios antes de adicionar outro endereço.');
            }

            let lastForm = $("#formAddresses .input-wrapper").last();
            let newElement = $(lastForm.clone().insertAfter(lastForm));

            let deleteBtn = newElement.find('.destroy-address').contents();
            newElement.find('.destroy-address').replaceWith(deleteBtn);
            newElement.find('.remove-btn').addClass('remove-address');


            lastForm.css('box-shadow', '0px 24px 3px -24px #090368').css('margin-bottom', '20px').css('padding-bottom', '10px');

            newElement.find('input').val('');
            newElement.find('#niceName').focus();
            newElement.find('.cep-mask').mask('00000-000');


        });

        $(document).on('click', '.remove-address', e => {
            let el = $(e.target);
            let elWrapper = el.closest('.input-wrapper');

            if ($('#formAddresses .input-wrapper').length > 1) {
                elWrapper.remove();
                $('#formAddresses .input-wrapper').last().css('margin-bottom', '0').css('padding-bottom', '0').css('box-shadow', 'none');
                toastr.success('Você removeu o endereço com sucesso!');
            } else {
                let filledInputs = elWrapper.find('input').filter(function () {
                    return $.trim($(this).val()).length > 0
                }).length;

                elWrapper.last().css('margin-bottom', '0').css('padding-bottom', '0').css('box-shadow', 'none');

                if (filledInputs) {
                    toastr.success('Você removeu o endereço com sucesso!');
                }

                elWrapper.find('input').val('');
            }


        });

    </script>

    <script>

    </script>
@endsection
