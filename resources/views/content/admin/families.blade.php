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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFamilyModal" >Adicionar Família</button>
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
                            <th class="text-center" style="width: 150px">#</th>
                            <th>Família</th>
                            <th>Criação</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach($families as $family)
                            <tr>
                                <td style="width: 150px;">
                                    <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center justify-content-center">
                                        @foreach($family->users as $key => $user)
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="{{ $user->name }}">
                                                <img src="{{asset('storage/' . $user->profile_picture )}}" alt="Avatar" class="rounded-circle">
                                            </li>
                                            @if($key >= 2 && count($family->users) - 3)
                                                <span class="ms-1">+{{ count($family->users) - 3 }}</span>
                                                @break
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                                <td><strong>{{ $family->name  }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($family->created_at)->translatedFormat('d/m/Y')  }}</td>
                                <td>
                                    @if(count($family->users))
                                        <span class="badge bg-label-primary me-1">Ativa</span>
                                    @else
                                        <span class="badge bg-label-danger me-1">Inativa</span>
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
                                            <a class="dropdown-item edit-family" href="javascript:void(0);" data-family-id="{{ $family->id }}">
                                                <i class="bx bx-edit-alt me-1"></i>Editar
                                            </a>
                                            <a class="dropdown-item delete-family" data-family-id="{{ $family->id }}" href="javascript:void(0);" style="color: red;">
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
                    {!! $families->links() !!}
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

    <!-- Modal de edição de notificações -->
    <div class="modal fade" id="editFamilyModal" data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <form class="modal-content" method="POST" action="{{ route('admin.families.edit') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Editar Família</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="id" id="familyID">
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
@endsection

@section('page-script')
    <script>
        $(".delete-family").click( function () {
            let family = $(this).data("family-id");

            let deleteCondition = window.confirm("Você tem certeza que gostaria de deletar esta família?");

            if(deleteCondition) {
                window.location.href = 'http://localhost:8000/admin/familias/delete/' + family;
            }
        });
    </script>

    <!-- Tagify de seleção de usuários (ADD) -->
    <script>
        const TagifyUserListEl = document.querySelector("#usersTagify");
        const usersList = [
                @foreach($unassignedUsers as $user)
            {
                value: {{ $user->id }},
                name: '{{ $user->name }}',
                avatar: '{{asset('storage/' . $user->profile_picture )}}',
                email: '{{ $user->email }}'
            }{{ !$loop->last ? ',' : '' }}
                @endforeach
        ];

        function tagTemplate(tagData) {
            return `
            <tag title="${tagData.title || tagData.email}"
              contenteditable='false'
              spellcheck='false'
              tabIndex="-1"
              class="${this.settings.classNames.tag} ${tagData.class ? tagData.class : ''}"
              ${this.getAttributes(tagData)}
            >
              <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
              <div>
                <div class='tagify__tag__avatar-wrap'>
                  <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
                </div>
                <span class='tagify__tag-text'>${tagData.name}</span>
              </div>
            </tag>
          `;
        }

        function suggestionItemTemplate(tagData) {
            return `
                <div ${this.getAttributes(tagData)}
                class='tagify__dropdown__item align-items-center ${tagData.class ? tagData.class : ''}'
                tabindex="0"
                role="option">
                    ${tagData.avatar ?
                `<div class='tagify__dropdown__item__avatar-wrap'>
                        <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
                        </div>`
                : ''
            }
                    <strong>${tagData.name}</strong>
                    <span>${tagData.email}</span>
                </div>`;
        }

        // initialize Tagify on the above input node reference
        let TagifyUserList = new Tagify(TagifyUserListEl, {
            tagTextProp: "name", // very important since a custom template is used with this property as text. allows typing a "value" or a "name" to match input with whitelist
            enforceWhitelist: true,
            skipInvalid: true, // do not remporarily add invalid tags
            dropdown: {
                closeOnSelect: false,
                enabled: 0,
                classname: "users-list",
                searchKeys: ["name", "email"] // very important to set by which keys to search for suggesttions when typing
            },
            templates: {
                tag: tagTemplate,
                dropdownItem: suggestionItemTemplate
            },
            whitelist: usersList
        });

        TagifyUserList.on("dropdown:show dropdown:updated", onDropdownShow);
        TagifyUserList.on("dropdown:select", onSelectSuggestion);

        let addAllSuggestionsEl;

        function onDropdownShow(e) {
            let dropdownContentEl = e.detail.tagify.DOM.dropdown.content;

            if (TagifyUserList.suggestedListItems.length > 1) {
                addAllSuggestionsEl = getAddAllSuggestionsEl();

                // insert "addAllSuggestionsEl" as the first element in the suggestions list
                dropdownContentEl.insertBefore(addAllSuggestionsEl, dropdownContentEl.firstChild);
            }
        }

        function onSelectSuggestion(e) {
            if (e.detail.elm == addAllSuggestionsEl) TagifyUserList.dropdown.selectAll.call(TagifyUserList);
        }

        // create an "add all" custom suggestion element every time the dropdown changes
        function getAddAllSuggestionsEl() {
            // suggestions items should be based on "dropdownItem" template
            return TagifyUserList.parseTemplate("dropdownItem", [
                {
                    class: "addAll",
                    name: "Adicionar Todos",
                    email:
                        TagifyUserList.settings.whitelist.reduce(function(remainingSuggestions, item) {
                            return TagifyUserList.isTagDuplicate(item.value) ? remainingSuggestions : remainingSuggestions + 1;
                        }, 0) + " Membros"
                }
            ]);
        }

        $("#addNotificationModal .remove-all-notifications").click( function() {
            $("#addNotificationModal #usersTagify").val('');
        });
    </script>

    <!-- Tagify de seleção de usuários (EDIT) -->
    <script>
        const TagifyUserListElEdit = document.querySelector("#editFamilyModal #usersTagify");
        const usersListEdit = [
                @foreach($users as $user)
            {
                value: {{ $user->id }},
                name: '{{ $user->name }}',
                avatar: '{{asset('storage/' . $user->profile_picture )}}',
                email: '{{ $user->email }}'
            }{{ !$loop->last ? ',' : '' }}
                @endforeach
        ];

        function tagTemplate(tagData) {
            return `
            <tag title="${tagData.title || tagData.email}"
              contenteditable='false'
              spellcheck='false'
              tabIndex="-1"
              class="${this.settings.classNames.tag} ${tagData.class ? tagData.class : ''}"
              ${this.getAttributes(tagData)}
            >
              <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
              <div>
                <div class='tagify__tag__avatar-wrap'>
                  <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
                </div>
                <span class='tagify__tag-text'>${tagData.name}</span>
              </div>
            </tag>
          `;
        }

        function suggestionItemTemplate(tagData) {
            return `
                <div ${this.getAttributes(tagData)}
                class='tagify__dropdown__item align-items-center ${tagData.class ? tagData.class : ''}'
                tabindex="0"
                role="option">
                    ${tagData.avatar ?
                `<div class='tagify__dropdown__item__avatar-wrap'>
                        <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
                        </div>`
                : ''
            }
                    <strong>${tagData.name}</strong>
                    <span>${tagData.email}</span>
                </div>`;
        }

        // initialize Tagify on the above input node reference
        let TagifyUserListEdit = new Tagify(TagifyUserListElEdit, {
            tagTextProp: "name", // very important since a custom template is used with this property as text. allows typing a "value" or a "name" to match input with whitelist
            enforceWhitelist: true,
            skipInvalid: true, // do not remporarily add invalid tags
            dropdown: {
                closeOnSelect: false,
                enabled: 0,
                classname: "users-list",
                searchKeys: ["name", "email"] // very important to set by which keys to search for suggesttions when typing
            },
            templates: {
                tag: tagTemplate,
                dropdownItem: suggestionItemTemplate
            },
            whitelist: usersListEdit
        });

        TagifyUserListEdit.on("dropdown:show dropdown:updated", onDropdownShowEdit);
        TagifyUserListEdit.on("dropdown:select", onSelectSuggestionEdit);

        let addAllSuggestionsElEdit;

        function onDropdownShowEdit(e) {
            let dropdownContentEl = e.detail.tagify.DOM.dropdown.content;

            if (TagifyUserListEdit.suggestedListItems.length > 1) {
                addAllSuggestionsElEdit = getAddAllSuggestionsElEdit();

                // insert "addAllSuggestionsEl" as the first element in the suggestions list
                dropdownContentEl.insertBefore(addAllSuggestionsElEdit, dropdownContentEl.firstChild);
            }
        }

        function onSelectSuggestionEdit(e) {
            if (e.detail.elm == addAllSuggestionsElEdit) TagifyUserListEdit.dropdown.selectAll.call(TagifyUserListEdit);
        }

        // create an "add all" custom suggestion element every time the dropdown changes
        function getAddAllSuggestionsElEdit() {
            // suggestions items should be based on "dropdownItem" template
            return TagifyUserListEdit.parseTemplate("dropdownItem", [
                {
                    class: "addAll",
                    name: "Adicionar Todos",
                    email:
                        TagifyUserListEdit.settings.whitelist.reduce(function(remainingSuggestions, item) {
                            return TagifyUserListEdit.isTagDuplicate(item.value) ? remainingSuggestions : remainingSuggestions + 1;
                        }, 0) + " Membros"
                }
            ]);
        }

        $("#editNotificationModal .remove-all-notifications").click( function() {
            $("#editNotificationModal #usersTagify").val('');
        });
    </script>

    <!-- Botão de abrir modal de edição -->
    <script>
        $(".edit-family").click( function(e) {
            let familyID = $(this).data('family-id');

            $.get('/api/family/' + familyID).done(data => {
                $("#editFamilyModal #familyID").val(familyID);
                $("#editFamilyModal #name").val(data.name);
                $("#editFamilyModal #usersTagify").val(JSON.stringify(data.users));

                $("#editFamilyModal").modal('show');
            }).fail(() => {
                return toastr.error('Oops! Houve um erro!');
            });
        });
    </script>
@endsection
