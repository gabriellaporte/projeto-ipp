@extends('layouts/contentNavbarLayout')

@section('title', 'Editar Usuário - Admin')


@section('content')
  <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Admin /</span> Editar Usuário
  </h4>

  <div class="row">
    <div class="col-md-12">

      <div class="card mb-4">
        <h5 class="card-header d-flex flex-column pb-2">Detalhes do Perfil <span class="text-muted mt-1 fw-semibold" style="font-size: 0.8rem;">(Atualizado em {{ \Carbon\Carbon::parse($user->updated_at)->translatedFormat('d/m/Y à\s H:m') }})</span></h5>
        <!-- Account -->
        <form id="formAccountSettings" method="POST" action="{{ route('admin.user.edit', $user->id) }}" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
              <img src="{{asset('storage/' . $user->profile_picture )}}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" style="border-radius: 999rem !important;" />
              <div class="button-wrapper">
                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                  <span class="d-none d-sm-block">Usar nova foto</span>
                  <i class="bx bx-upload d-block d-sm-none"></i>
                  <input type="file" id="upload" name="profilePicture" class="account-file-input" hidden accept="image/png, image/jpeg, image/gif" />
                </label>
                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4" >
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
                <input class="form-control" type="text" id="userName" name="userName" value="{{ $user->name }}" autofocus @cannot('users.edit') readonly @endcannot/>
              </div>
              <div class="mb-3 col-md-6">
                <label for="emailAddress" class="form-label">E-mail</label>
                <input class="form-control" type="text" name="emailAddress" id="emailAddress" value="{{ $user->email }}" />
              </div>
              <div class="mb-3 col-md-6">
                <label for="mobilePhone" class="form-label">Celular</label>
                <div class="input-group input-group-merge">
                  <span class="input-group-text highlighted">BR +55</span>
                  <input class="form-control phone-mask" type="text" id="mobilePhone" name="mobilePhone" value="{{ $user->mobile_phone }}" placeholder="(31) x xxxx-xxxx" />
                </div>
              </div>
              <div class="mb-3 col-md-6">
                <label for="housePhone" class="form-label">Telefone Fixo</label>
                <div class="input-group input-group-merge">
                  <span class="input-group-text highlighted">BR +55</span>
                  <input class="form-control housephone-mask" type="text" id="housePhone" name="housePhone" placeholder="(31) xxxx-xxxx" value="{{ $user->house_phone }}"/>
                </div>
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label" for="enrollmentOrigin">Igreja de Origem</label>
                <input type="text" id="enrollmentOrigin" name="enrollmentOrigin" class="form-control" placeholder="..." value="{{ $user->enrollment_origin }}" @cannot('users.edit') readonly @endcannot/>
              </div>
              <div class="mb-3 col-md-6">
                <label for="enrollmentDate" class="form-label">Data de Arrolamento</label>
                <input class="form-control date-mask" type="text" id="enrollmentDate" name="enrollmentDate" placeholder="xx/xx/xxxx" value="{{ !is_null($user->enrollment_date) ? \Carbon\Carbon::parse($user->enrollment_date)->format('d/m/Y') : ''}}" @cannot('users.edit') readonly @endcannot/>
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label" for="birthDate">Data de Nascimento</label>
                <input class="form-control date-mask" type="text" id="birthDate" name="birthDate" placeholder="xx/xx/xxxx" value="{{ \Carbon\Carbon::parse($user->birth_date)->format('d/m/Y') }}"/>
              </div>

              <div class="mb-3 col-md-6">
                <label class="form-label" for="gender">Gênero</label>
                <select id="gender" name="gender" class="select2 form-select" @cannot('users.edit') disabled @endcannot>
                  <option value="M" {{ $user->gender == 'M' ? 'selected' : '' }}>Masculino</option>
                  <option value="F" {{ $user->gender == 'F' ? 'selected' : '' }}>Feminino</option>
                </select>
              </div>
              <div class="mb-3 col-md-6">
                <label for="roles" class="form-label">Cargos</label>
                <select id="roles" name="roles[]" class="select2 form-select" multiple @cannot('roles.assign') disabled @endcannot>
                  <optgroup label="Selecione os cargos de {{ explode(' ', $user->name)[0] }}">
                    @foreach($roles as $role)
                      <option value="{{ $role->id }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                  </optgroup>
                </select>
              </div>
            </div>
            <div class="mt-2">
              <button type="submit" class="btn btn-primary me-2">Salvar</button>
              <button type="reset" class="btn btn-outline-secondary" onclick="document.location.reload(false)">Recarregar</button>
            </div>
          </div>
        </form>
        <!-- /Account -->
      </div>
      <div class="card">
        <h5 class="card-header">Endereços</h5>
        <div class="card-body">
          <button type="button" id="addAddress" class="btn btn-outline-primary mb-3">
            <span class="tf-icons bx bx-bookmark-alt-plus"></span>&nbsp; Adicionar
          </button>
          <div class="mb-3 col-12 d-flex justify-content-center">
            <div class="alert alert-primary d-inline-block mb-0 text-center" role="alert">
              <i class="bx bx-info-circle d-none d-sm-inline-block" style="margin-top: -2px;"></i>&nbsp; Os seus endereços são privados e somente oficiais conseguem vê-los!&nbsp;
              <button type="button" class="btn-close d-none d-sm-inline-block" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>
          <form id="formAddresses" method="POST" action="{{ route('admin.user.addresses.sync', $user->id) }}">
            @csrf
            <!-- Loop pelos endereços já existentes -->
            @if(is_null(old('niceName')))
              @forelse($addresses as $address)
                <div class="input-wrapper row" style="{{ ((!is_null(old('niceName')) && count(old('niceName'))) || count($addresses) > 1) && $loop->first ? 'box-shadow: rgb(9, 3, 104) 0px 24px 3px -24px; margin-bottom: 20px; padding-bottom: 10px;' : ''}}">
                  <div class="mb-3 col-md-6">
                    <label for="niceName" class="form-label">Apelido <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control" type="text" id="niceName" name="niceName[]" value="{{ $address->nice_name ?? ""}}" placeholder="Ex: Casa"/>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="cep" class="form-label">CEP <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control cep-mask" type="text" name="cep[]" id="cep" value="{{ $address->cep ?? "" }}" placeholder="xxxxx-xxx" />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="address" class="form-label">Endereço <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control" type="text" name="address[]" id="address" value="{{ $address->address ?? "" }}" placeholder="..." />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="area" class="form-label">Bairro <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control" type="text" name="area[]" id="area" value="{{ $address->area ?? "" }}" placeholder="..." />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="houseNumber" class="form-label">Número <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control" type="text" name="houseNumber[]" id="houseNumber" value="{{ $address->house_number ?? "" }}" placeholder="..." />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="addressComplement" class="form-label">Complemento</label>
                    <input class="form-control" type="text" name="addressComplement[]" id="addressComplement" value="{{ $address->address_complement ?? "" }}" placeholder="..." />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="city" class="form-label">Cidade <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control" type="text" name="city[]" id="city" value="{{ $address->city ?? "" }}" placeholder="..." />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="state" class="form-label">Estado <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control" type="text" name="state[]" id="state" value="{{ $address->state ?? "" }}" placeholder="..." />
                  </div>
                  <div class="mb-3 col-12 d-flex justify-content-end"><button type="button" class="btn rounded-pill btn-icon btn-danger remove-address"><span class="tf-icons bx bx-trash"></span></button></div>
                </div>
              @empty
                <div class="input-wrapper row" style="{{ ((!is_null(old('niceName')) && count(old('niceName'))) || count($addresses) > 1) && $loop->first ? 'box-shadow: rgb(9, 3, 104) 0px 24px 3px -24px; margin-bottom: 20px; padding-bottom: 10px;' : ''}}">
                  <div class="mb-3 col-md-6">
                    <label for="niceName" class="form-label">Apelido <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control" type="text" id="niceName" name="niceName[]" placeholder="Ex: Casa"/>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="cep" class="form-label">CEP <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control cep-mask" type="text" name="cep[]" id="cep" placeholder="xxxxx-xxx" />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="address" class="form-label">Endereço <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control" type="text" name="address[]" id="address" placeholder="..." />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="area" class="form-label">Bairro <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control" type="text" name="area[]" id="area" placeholder="..." />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="houseNumber" class="form-label">Número <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control" type="text" name="houseNumber[]" id="houseNumber" placeholder="..." />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="addressComplement" class="form-label">Complemento</label>
                    <input class="form-control" type="text" name="addressComplement[]" id="addressComplement" placeholder="..." />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="city" class="form-label">Cidade <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control" type="text" name="city[]" id="city" placeholder="..." />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="state" class="form-label">Estado <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control" type="text" name="state[]" id="state" placeholder="..." />
                  </div>
                  <div class="mb-3 col-12 d-flex justify-content-end"><button type="button" class="btn rounded-pill btn-icon btn-danger remove-address"><span class="tf-icons bx bx-trash"></span></button></div>
                </div>
              @endforelse
            @else

              <!-- Loop pelos old inputs -->
              @for($i = 0; $i < count(old('niceName')); $i++)
                <div class="input-wrapper row">
                  <div class="mb-3 col-md-6">
                    <label for="niceName" class="form-label">Apelido <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control" type="text" id="niceName" name="niceName[]" value="{{ old('niceName')[$i] ?? "" }}" placeholder="Ex: Casa"/>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="cep" class="form-label">CEP <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control cep-mask" type="text" name="cep[]" id="cep" value="{{ old('cep')[$i] ?? "" }}" placeholder="xxxxx-xxx" />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="address" class="form-label">Endereço <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control" type="text" name="address[]" id="address" value="{{ old('address')[$i] ?? "" }}" placeholder="..." />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="area" class="form-label">Bairro <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control" type="text" name="area[]" id="area" value="{{ old('area')[$i] ?? "" }}" placeholder="..." />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="houseNumber" class="form-label">Número <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control" type="text" name="houseNumber[]" id="houseNumber" value="{{ old('houseNumber')[$i] ?? "" }}" placeholder="..." />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="addressComplement" class="form-label">Complemento</label>
                    <input class="form-control" type="text" name="addressComplement[]" id="addressComplement" value="{{ old('addressComplement')[$i] ?? "" }}" placeholder="..." />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="city" class="form-label">Cidade <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control" type="text" name="city[]" id="city" value="{{ old('city')[$i] ?? "" }}" placeholder="..." />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="state" class="form-label">Estado <span class="fw-bold text-danger ms-1">*</span></label>
                    <input class="form-control" type="text" name="state[]" id="state" value="{{ old('state')[$i] ?? "" }}" placeholder="..." />
                  </div>
                  <div class="mb-3 col-12 d-flex justify-content-end"><button type="button" class="btn rounded-pill btn-icon btn-danger remove-address"><span class="tf-icons bx bx-trash"></span></button></div>
                </div>
              @endfor
            @endif
            <div class="mt-2">
              <button type="submit" class="btn btn-primary me-2">Salvar</button>
              <a href="{{ route('admin.user.addresses.flush', $user->id) }}"><button type="button" class="btn btn-outline-danger" >Remover Todos</button></a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>

  <script>
    $(document).ready( () => {
      if ($(".select2").length > 0) {
        $(".select2").select2();
      }
    });
  </script>

  <script>
    $(document).ready( ($) => {
      $(document).on('keyup', '#formAddresses .cep-mask', e => {
        let el = $(e.target);
        let elWrapper = el.closest('.input-wrapper');

        if(el.val().length !== 9) {
          return;
        }

        let cep = el.val().replace(/\D/g, '');
        let regexPattern = /^[0-9]{8}$/;

        if(!regexPattern.test(cep)) {
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
    $("#addAddress").click( () => {
      let hasEmptyInputs = false;

      $("#formAddresses .input-wrapper").each( (i, el) => {
        let emptyInputs = $(el).find('input').not('#addressComplement').filter(function () {
          return $.trim($(this).val()).length == 0
        }).length;

        if(emptyInputs) {
          hasEmptyInputs = true;
        }
      });

      if(hasEmptyInputs) {
        return toastr.warning('Preencha todos os campos obrigatórios antes de adicionar outro endereço.');
      }

      let lastForm = $("#formAddresses .input-wrapper").last();
      let newElement = $(lastForm.clone().insertAfter(lastForm));
      lastForm.css('box-shadow', '0px 24px 3px -24px #090368').css('margin-bottom', '20px').css('padding-bottom', '10px');

      newElement.find('input').val('');
      newElement.find('#niceName').focus();
      newElement.find('.cep-mask').mask('00000-000');


    });

    $(document).on('click', '.remove-address', e => {
      let el = $(e.target);
      let elWrapper = el.closest('.input-wrapper');

      if($('#formAddresses .input-wrapper').length > 1) {
        elWrapper.remove();
        $('#formAddresses .input-wrapper').last().css('margin-bottom', '0').css('padding-bottom', '0').css('box-shadow', 'none');
        toastr.success('Você removeu o endereço com sucesso! Salve as alterações.');
      } else {
        let filledInputs = elWrapper.find('input').filter(function () {
          return $.trim($(this).val()).length > 0
        }).length;

        elWrapper.last().css('margin-bottom', '0').css('padding-bottom', '0').css('box-shadow', 'none');

        if(filledInputs) {
          toastr.success('Você removeu o endereço com sucesso! Salve as alterações.');
        }

        elWrapper.find('input').val('');
      }



    });

  </script>
@endsection
