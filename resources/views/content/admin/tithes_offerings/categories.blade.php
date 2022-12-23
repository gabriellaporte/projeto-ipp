@extends('layouts.contentNavbarLayout')

@section('title', 'Categorias - Admin')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Admin / Dízimos e Ofertas /</span> Categorias
    </h4>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <div class="card-header d-flex flex-column flex-sm-row align-items-center justify-content-between">
                    <button type="button" class="btn btn-primary mb-3 mb-sm-0" data-bs-toggle="modal"
                            data-bs-target="#addCategoryModal">Adicionar Categoria
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
                        @foreach($categories as $category)
                            <tr>
                                <td style="width: 150px;" class="text-center">{{ $category->id }}</td>
                                <td><strong>{{ $category->type_name }}</strong></td>
                                <td>
                                    @if($category->is_offering)
                                        <span class="badge bg-label-success me-1">Oferta</span>
                                    @else
                                        <span class="badge bg-label-primary me-1">Dízimo</span>
                                    @endif
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="true"><i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu"
                                             style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(-145px, 27px);"
                                             data-popper-placement="bottom-end">
                                            <a class="dropdown-item edit-category" href="javascript:void(0);"
                                               data-category-id="{{ $category->id }}">
                                                <i class="bx bx-edit-alt me-1"></i>Editar
                                            </a>
                                            <a class="dropdown-item delete-category" data-category-id="{{ $category->id }}"
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
                    {!! $categories->links() !!}
                </div>
            </div>

        </div>
    </div>

    <!-- Modal de Add Categoria -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <form class="modal-content" method="POST" action="{{ route('admin.tithes.category.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Nova Categoria</h5>
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
                                <select id="isOffering" name="is_offering" class="select2 form-select">
                                    <option value="1">Oferta</option>
                                    <option value="0">Dízimo</option>
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

    <!-- Modal de edição de categoria -->
    <div class="modal fade" id="editCategoryModal" data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <form class="modal-content" method="POST" action="{{ route('admin.families.update', 0) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Editar Categoria</h5>
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
                                <select id="isOfferingEdit" name="is_offering" class="select2 form-select">
                                    <option value="1">Oferta</option>
                                    <option value="0">Dízimo</option>
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

    <form method="POST" id="deleteCategoryForm" action="{{ route('admin.tithes.category.delete', 0) }}">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('page-script')
    <script>
        $(".delete-category").click(function () {
            let category = $(this).data("category-id");

            let deleteCondition = window.confirm("Você tem certeza que gostaria de deletar esta categoria?");

            if (deleteCondition) {
                $("#deleteCategoryForm").attr('action', 'http://localhost:8000/admin/dizimos/categorias/delete/' + category);

                $("#deleteCategoryForm").submit();
            }
        });
    </script>

    <!-- Botão de abrir modal de edição -->
    <script>
        $(".edit-category").click(function (e) {
            let categoryID = $(this).data('category-id');

            $.get('/api/category/' + categoryID).done(data => {
                $("#editCategoryModal form").attr('action', 'http://localhost:8000/admin/dizimos/categorias/update/' + categoryID);
                $("#editCategoryModal #typeName").val(data.type_name);

                console.log(data.is_offering);

                $("#editCategoryModal #isOfferingEdit").select2('val', data.is_offering.toString());

                $("#editCategoryModal").modal('show');
            }).fail(() => {
                return toastr.error('Oops! Houve um erro!');
            });
        });
    </script>
@endsection
