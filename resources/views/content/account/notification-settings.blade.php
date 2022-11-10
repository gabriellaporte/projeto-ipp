@extends('layouts/contentNavbarLayout')

@section('title', 'Configurações de Notificações - Minha Conta')


@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Conta /</span> Configurações de Notificações
    </h4>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item"><a class="nav-link" href="{{ route('account.settings') }}"><i
                            class="bx bx-user me-1"></i> Configurações de Perfil</a></li>
                <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i
                            class="bx bx-bell me-1"></i> Configurações de Notificações</a></li>
            </ul>
            <div class="card mb-4">
                <h5 class="card-header d-flex flex-column pb-4">Configurações de Notificações</h5>
                <form class="card-body" id="notificationSettings" method="POST"
                      action="{{ route('account.notifications.sync') }}">
                    @csrf
                    <div class="nav-align-top">
                        <ul class="nav nav-pills mb-3 flex-column flex-md-row" id="notificationSettingsNav"
                            role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-system" aria-controls="nav-system" aria-selected="true">
                                    Notificações via Sistema
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-mail" aria-controls="nav-mail" aria-selected="false">
                                    Notificações via E-mail
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="nav-system" role="tabpanel">
                                <div class="row row-bordered g-0">
                                    <div class="col-sm-6 p-4 d-flex flex-column align-items-center">
                                        <div class="text-light fw-semibold mb-3">Dízimo Registrado</div>
                                        <label class="switch switch-lg">
                                            <input type="checkbox" name="system_tithes_notification"
                                                   class="switch-input" {{ $notSettings->where('name', 'system_tithes_notification')->first()->value ? 'checked' : '' }} />
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
                                            <input type="checkbox" name="system_offers_notification"
                                                   class="switch-input" {{ $notSettings->where('name', 'system_offers_notification')->first()->value ? 'checked' : '' }} />
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
                                            <input type="checkbox" name="system_birthdate_notification"
                                                   class="switch-input" {{ $notSettings->where('name', 'system_birthdate_notification')->first()->value ? 'checked' : '' }} />
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
                                            <input type="checkbox" class="switch-input" checked disabled/>
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
                                            <input type="checkbox" name="email_tithes_notification"
                                                   class="switch-input" {{ $notSettings->where('name', 'email_tithes_notification')->first()->value ? 'checked' : '' }} />
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
                                            <input type="checkbox" name="email_offers_notification"
                                                   class="switch-input" {{ $notSettings->where('name', 'email_offers_notification')->first()->value ? 'checked' : '' }} />
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
                                            <input type="checkbox" name="email_birthday_notification"
                                                   class="switch-input" {{ $notSettings->where('name', 'email_birthday_notification')->first()->value ? 'checked' : '' }} />
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
                                            <input type="checkbox" name="email_system_notification" class="switch-input" {{ $notSettings->where('name', 'email_system_notification')->first()->value ? 'checked' : '' }} />
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
                    <div class="pt-3 d-flex w-100 justify-content-end">
                        <button type="submit" class="btn btn-outline-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
        @endsection

        @section('page-script')
            <script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>
@endsection
