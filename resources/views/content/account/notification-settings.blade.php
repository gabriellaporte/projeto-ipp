@extends('layouts/contentNavbarLayout')

@section('title', 'Configurações de Notificações - Minha Conta')


@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Conta /</span> Configurações de Notificações
</h4>

<div class="row">
  <div class="col-md-12">
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
      <li class="nav-item"><a class="nav-link" href="{{ route('account.settings') }}"><i class="bx bx-user me-1"></i> Configurações de Perfil</a></li>
      <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="bx bx-bell me-1"></i> Configurações de Notificações</a></li>
    </ul>
    <div class="card mb-4">
      <h5 class="card-header d-flex flex-column pb-4">Configurações de Notificações</h5>
        <div class="card-body" id="notificationSettings">
          <div class="nav-align-top">
            <ul class="nav nav-pills mb-3 flex-column flex-md-row" id="notificationSettingsNav" role="tablist">
              <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#nav-system" aria-controls="nav-system" aria-selected="true">Notificações via Sistema</button>
              </li>
              <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#nav-mail" aria-controls="nav-mail" aria-selected="false">Notificações via E-mail</button>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="nav-system" role="tabpanel">
                <div class="row row-bordered g-0">
                  <div class="col-sm-6 p-4 d-flex flex-column align-items-center">
                    <div class="text-light fw-semibold mb-3">Dízimo Registrado</div>
                    <label class="switch switch-lg">
                      <input type="checkbox" class="switch-input" checked />
                      <span class="switch-toggle-slider">
                        <span class="switch-on">
                          <i class="bx bx-check"></i>
                        </span>
                        <span class="switch-off">
                          <i class="bx bx-x"></i>
                        </span>
                      </span>
                    </label>
                  </div>

                  <div class="col-sm-6 p-4 d-flex flex-column align-items-center">
                    <div class="text-light fw-semibold mb-3">Oferta Registrada</div>
                    <label class="switch switch-lg">
                      <input type="checkbox" class="switch-input" checked />
                      <span class="switch-toggle-slider">
                        <span class="switch-on">
                          <i class="bx bx-check"></i>
                        </span>
                        <span class="switch-off">
                          <i class="bx bx-x"></i>
                        </span>
                      </span>
                    </label>
                  </div>

                  <div class="col-sm-6 p-4 d-flex flex-column align-items-center">
                    <div class="text-light fw-semibold mb-3">Aniversário de Membros</div>
                    <label class="switch switch-lg">
                      <input type="checkbox" class="switch-input" checked />
                      <span class="switch-toggle-slider">
                        <span class="switch-on">
                          <i class="bx bx-check"></i>
                        </span>
                        <span class="switch-off">
                          <i class="bx bx-x"></i>
                        </span>
                      </span>
                    </label>
                  </div>

                  <div class="col-sm-6 p-4 d-flex flex-column align-items-center">
                    <div class="text-light fw-semibold mb-3">Mensagens do Sistema</div>
                    <label class="switch switch-lg">
                      <input type="checkbox" class="switch-input" disabled />
                      <span class="switch-toggle-slider">
                        <span class="switch-on">
                          <i class="bx bx-check"></i>
                        </span>
                        <span class="switch-off">
                          <i class="bx bx-x"></i>
                        </span>
                      </span>
                    </label>
                  </div>


                </div>
              </div>
              <div class="tab-pane fade" id="nav-mail" role="tabpanel">
                <div class="row row-bordered g-0">
                  <div class="col-sm-6 p-4 d-flex flex-column align-items-center">
                    <div class="text-light fw-semibold mb-3">Dízimo Registrado</div>
                    <label class="switch switch-lg">
                      <input type="checkbox" class="switch-input" checked />
                      <span class="switch-toggle-slider">
                        <span class="switch-on">
                          <i class="bx bx-check"></i>
                        </span>
                        <span class="switch-off">
                          <i class="bx bx-x"></i>
                        </span>
                      </span>
                    </label>
                  </div>

                  <div class="col-sm-6 p-4 d-flex flex-column align-items-center">
                    <div class="text-light fw-semibold mb-3">Oferta Registrada</div>
                    <label class="switch switch-lg">
                      <input type="checkbox" class="switch-input" checked />
                      <span class="switch-toggle-slider">
                        <span class="switch-on">
                          <i class="bx bx-check"></i>
                        </span>
                        <span class="switch-off">
                          <i class="bx bx-x"></i>
                        </span>
                      </span>
                    </label>
                  </div>

                  <div class="col-sm-6 p-4 d-flex flex-column align-items-center">
                    <div class="text-light fw-semibold mb-3">Aniversário de Membros</div>
                    <label class="switch switch-lg">
                      <input type="checkbox" class="switch-input" checked />
                      <span class="switch-toggle-slider">
                        <span class="switch-on">
                          <i class="bx bx-check"></i>
                        </span>
                        <span class="switch-off">
                          <i class="bx bx-x"></i>
                        </span>
                      </span>
                    </label>
                  </div>

                  <div class="col-sm-6 p-4 d-flex flex-column align-items-center">
                    <div class="text-light fw-semibold mb-3">Mensagens do Sistema</div>
                    <label class="switch switch-lg">
                      <input type="checkbox" class="switch-input" checked />
                      <span class="switch-toggle-slider">
                        <span class="switch-on">
                          <i class="bx bx-check"></i>
                        </span>
                        <span class="switch-off">
                          <i class="bx bx-x"></i>
                        </span>
                      </span>
                    </label>
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>
@endsection
