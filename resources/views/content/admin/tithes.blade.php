@extends('layouts/contentNavbarLayout')

@section('title', 'Famílias - Admin')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Admin /</span> Famílias
    </h4>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <div class="card-header d-flex flex-column flex-sm-row align-items-center justify-content-between">
                    <button type="button" class="btn btn-primary mb-3 mb-sm-0" data-bs-toggle="modal" data-bs-target="#addFamilyModal" >Adicionar Família</button>
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
                            <th class="text-center" style="width: 150px">Membro</th>
                            <th>Valor</th>
                            <th>Tipo de Pagamento</th>
                            <th>Diáconos</th>
                            <th>Registrado Em</th>
                            <th>Descrição</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach($tithes as $tithe)
                            <tr>
                                <td style="width: 150px;">
                                    <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center justify-content-center">
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="{{ $tithe->user->name }}">
                                            <img src="{{asset('storage/' . $tithe->user->profile_picture )}}" alt="Avatar" class="rounded-circle">
                                        </li>
                                    </ul>
                                </td>
                                <td><strong>R$ {{ number_format($tithe->amount, 2, ',', '.')  }}</strong></td>
                                <td>{{ $tithe->payment_type }} {{ $tithe->payed_at ? '(' . Carbon\Carbon::parse($tithe->payed_at)->format('d/m/Y') . ')' : '' }}</td>
                                <td style="width: 150px;">
                                    <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center justify-content-center">
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="{{ $tithe->firstChecker->name }}">
                                            <img src="{{asset('storage/' . $tithe->firstChecker->profile_picture )}}" alt="Avatar" class="rounded-circle">
                                        </li>
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="{{ $tithe->secondChecker->name }}">
                                            <img src="{{asset('storage/' . $tithe->secondChecker->profile_picture )}}" alt="Avatar" class="rounded-circle">
                                        </li>
                                    </ul>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($tithe->created_at)->translatedFormat('d/m/Y')  }}</td>
                                <td>
                                        <span class="badge bg-label-primary me-1">Dízimo</span>
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
                                            <a class="dropdown-item edit-family" href="javascript:void(0);" data-family-id="{{ $tithe->id }}">
                                                <i class="bx bx-edit-alt me-1"></i>Editar
                                            </a>
                                            <a class="dropdown-item delete-family" data-family-id="{{ $tithe->id }}" href="javascript:void(0);" style="color: red;">
                                                <i class="bx bx-trash-alt me-1"></i>Excluir
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex w-100 justify-content-center mt-4">
                    {!! $tithes->links() !!}
                </div>
            </div>

        </div>
    </div>

    <!-- Modal de Add Família -->
    <div class="modal fade" id="addFamilyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <form class="modal-content" method="POST" action="{{ route('admin.families.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Nova Família</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="name" class="form-label">Sobrenome</label><span class="fw-bold text-danger ms-1">*</span>
                                <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="..." autofocus/>
                            </div>
                            <div class="mb-3 col-12">
                                <div class="d-flex justify-content-between">
                                    <div class="label-wrapper">
                                        <label for="usersTagify" class="form-label">Membros</label>
                                    </div>
                                    <span class="remove-all-notifications form-label text-danger mb-0 pt-1 cursor-pointer">Remover Todos</span>
                                </div>
                                <input id="usersTagify" name="users" class="form-control" />
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

    <!-- Modal de edição de família -->
    <div class="modal fade" id="editFamilyModal" data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <form class="modal-content" method="POST" action="{{ route('admin.families.update', 0) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Editar Família</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="name" class="form-label">Sobrenome</label><span class="fw-bold text-danger ms-1">*</span>
                                <input class="form-control" type="text" id="name" name="name" value="" placeholder="..." autofocus/>
                            </div>
                            <div class="mb-3 col-12">
                                <div class="d-flex justify-content-between">
                                    <div class="label-wrapper">
                                        <label for="usersTagify" class="form-label">Membros</label>
                                    </div>
                                    <span class="remove-all-notifications form-label text-danger mb-0 pt-1 cursor-pointer">Remover Todos</span>
                                </div>
                                <input id="usersTagify" name="users" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Voltar</button>
                    <button type="submit" class="btn btn-primary">Alterar</button>
                </div>
            </form>
        </div>
    </div>

    <form method="POST" id="deleteFamilyForm" action="{{ route('admin.families.delete', 0) }}">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('page-script')
    <script>
        $(".delete-family").click( function () {
            let family = $(this).data("family-id");

            let deleteCondition = window.confirm("Você tem certeza que gostaria de deletar esta família?");

            if(deleteCondition) {
                $("#deleteFamilyForm").attr('action', 'http://localhost:8000/admin/familias/delete/' + family);

                $("#deleteFamilyForm").submit();
            }
        });
    </script>

    <!-- Botão de abrir modal de edição -->
    <script>
        $(".edit-family").click( function(e) {
            let familyID = $(this).data('family-id');

            $.get('/api/family/' + familyID).done(data => {
                $("#editFamilyModal form").attr('action', 'http://localhost:8000/admin/familias/update/' + familyID);
                $("#editFamilyModal #name").val(data.name);
                $("#editFamilyModal #usersTagify").val(JSON.stringify(data.users));

                $("#editFamilyModal").modal('show');
            }).fail(() => {
                return toastr.error('Oops! Houve um erro!');
            });
        });
    </script>
@endsection
