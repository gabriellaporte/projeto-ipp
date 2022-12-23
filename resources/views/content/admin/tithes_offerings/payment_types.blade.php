@extends('layouts.contentNavbarLayout')

@section('title', 'Tipos de Pagamento - Admin')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Admin / Dízimos e Ofertas /</span> Tipos de Pagamento
    </h4>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <div class="card-header d-flex flex-column flex-sm-row align-items-center justify-content-between">
                    <button type="button" class="btn btn-primary mb-3 mb-sm-0" data-bs-toggle="modal"
                            data-bs-target="#addPaymentTypeModal">Adicionar Tipo de Pagamento
                    </button>
                    <form id="searchForm" class="d-flex">
                        <input type="text" name="filter[name]" class="form-control border-0 shadow-none"
                               placeholder="Pesquisar..." aria-label="Search...">
                        <button type="submit" style="border: none; background-color: transparent; color: #697a8d;">
                            <i class="bx bx-search fs-4 lh-0"></i>
                        </button>
                    </form>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 150px">#</th>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach($paymentTypes as $paymentType)
                            <tr>
                                <td style="width: 150px;" class="text-center">{{ $paymentType->id }}</td>
                                <td><strong>{{ $paymentType->type_name }}</strong></td>
                                <td>
                                    @if($paymentType->is_in_cash)
                                        <span class="badge bg-label-success me-1">Em Dinheiro</span>
                                    @else
                                        <span class="badge bg-label-primary me-1">Pelo Banco</span>
                                    @endif
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="true"><i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu"
                                             style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(-145px, 27px);"
                                             data-popper-placement="bottom-end">
                                            <a class="dropdown-item edit-paymentType" href="javascript:void(0);"
                                               data-payment-type-id="{{ $paymentType->id }}">
                                                <i class="bx bx-edit-alt me-1"></i>Editar
                                            </a>
                                            <a class="dropdown-item delete-paymentType" data-payment-type-id="{{ $paymentType->id }}"
                                               href="javascript:void(0);" style="color: red;">
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
                    {!! $paymentTypes->links() !!}
                </div>
            </div>

        </div>
    </div>

    <!-- Modal de Add Tipo de Pagamento -->
    <div class="modal fade" id="addPaymentTypeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <form class="modal-content" method="POST" action="{{ route('admin.tithes.paymentType.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Novo Tipo de Pagamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="type_name" class="form-label">Nome</label><span
                                    class="fw-bold text-danger ms-1">*</span>
                                <input class="form-control" type="text" id="type_name" name="type_name" value="{{ old('type_name') }}"
                                       placeholder="..." autofocus/>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="name" class="form-label">Tipo</label><span
                                    class="fw-bold text-danger ms-1">*</span>
                                <select id="isInCash" name="is_in_cash" class="select2 form-select">
                                    <option value="1">Em dinheiro</option>
                                    <option value="0">Pelo Banco</option>
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

    <!-- Modal de edição -->
    <div class="modal fade" id="editPaymentTypeModal" data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <form class="modal-content" method="POST" action="{{ route('admin.families.update', 0) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Editar Tipo de Pagamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="type_name" class="form-label">Nome</label><span
                                    class="fw-bold text-danger ms-1">*</span>
                                <input class="form-control" type="text" id="typeName" name="type_name" value="{{ old('type_name') }}"
                                       placeholder="..." autofocus/>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="name" class="form-label">Tipo</label><span
                                    class="fw-bold text-danger ms-1">*</span>
                                <select id="isInCashEdit" name="is_in_cash" class="select2 form-select">
                                    <option value="1">Em Dinheiro</option>
                                    <option value="0">Pelo Banco</option>
                                </select>
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

    <form method="POST" id="deletePaymentTypeForm" action="{{ route('admin.tithes.paymentType.delete', 0) }}">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('page-script')
    <script>
        $(".delete-paymentType").click(function () {
            let paymentType = $(this).data("paymentType-id");

            let deleteCondition = window.confirm("Você tem certeza que gostaria de deletar este tipo de pagamento?");

            if (deleteCondition) {
                $("#deletePaymentTypeForm").attr('action', 'http://localhost:8000/admin/dizimos/payment-types/delete/' + paymentType);

                $("#deletePaymentTypeForm").submit();
            }
        });
    </script>

    <!-- Botão de abrir modal de edição -->
    <script>
        $(".edit-paymentType").click(function (e) {
            let paymentTypeID = $(this).data('paymentType-id');

            $.get('/api/payment-type/' + paymentTypeID).done(data => {
                $("#editPaymentTypeModal form").attr('action', 'http://localhost:8000/admin/dizimos/payment-types/update/' + paymentTypeID);
                $("#editPaymentTypeModal #typeName").val(data.type_name);

                console.log(data.is_in_cash);

                $("#editPaymentTypeModal #isInCashEdit").select2('val', data.is_in_cash.toString());

                $("#editPaymentTypeModal").modal('show');
            }).fail(() => {
                return toastr.error('Oops! Houve um erro!');
            });
        });
    </script>
@endsection
