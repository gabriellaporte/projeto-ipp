@extends('layouts/contentNavbarLayout')

@section('title', 'Notificações - Admin')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Admin /</span> Membros
    </h4>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <div class="card-header d-flex flex-column flex-sm-row align-items-center justify-content-between">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNotificationModal" @cannot('notifications.edit') disabled @endcannot>Adicionar Notificação</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Destinatário</th>
                                <th>Título</th>
                                <th>Conteúdo</th>
                                @can('notifications.edit')<th>Ações</th>@endcan
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @foreach($notifications as $notification)
                                <tr>
                                    <td style="width: 150px;">
                                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center justify-content-center">
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="{{ $notification->user->name }}">
                                                <img src="{{asset('storage/' . $notification->user->profile_picture )}}" alt="Avatar" class="rounded-circle">
                                            </li>
                                        </ul>
                                    </td>
                                    <td>{{ $notification->title() }}</td>
                                    <td>{{ $notification->content() }}</td>
                                    @can('notifications.edit')
                                        <td style="width: 150px;">
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="true"><i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu"
                                                     style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(-145px, 27px);"
                                                     data-popper-placement="bottom-end">
                                                    <a class="dropdown-item edit-notification" data-notification-id="{{ $notification->id }}" href="javascript:void(0);"><i
                                                            class="bx bx-edit-alt me-1"></i> Editar</a>
                                                    <a class="dropdown-item delete-notification" data-notification-id="{{ $notification->id }}" href="javascript:void(0);" style="color: red;">
                                                        <i class="bx bx-trash-alt me-1"></i> Excluir</a>
                                                </div>
                                            </div>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex w-100 justify-content-center mt-4">
                        {!! $notifications->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de adição de notificações -->
    <div class="modal fade" id="addNotificationModal" data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <form class="modal-content" method="POST" action="{{ route('admin.notifications.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Enviar uma Notificação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="title" class="form-label">Título da Notificação</label><span class="fw-bold text-danger ms-1">*</span>
                                <input class="form-control" type="text" id="title" name="title" value="{{ old('title') }}" placeholder="..." autofocus/>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="content" class="form-label">Conteúdo da Notificação</label><span class="fw-bold text-danger ms-1">*</span>
                                <textarea class="form-control" type="text" name="content" id="content" rows="3">{{ old('content') }}</textarea>
                            </div>
                            <div class="mb-3 col-12">
                                <div class="d-flex justify-content-between">
                                    <div class="label-wrapper">
                                        <label for="usersTagify" class="form-label">Destinatários</label><span class="fw-bold text-danger ms-1">*</span>
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
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de edição de notificações -->
    <div class="modal fade" id="editNotificationModal" data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <form class="modal-content" method="POST" action="{{ route('admin.notifications.update', 0) }}">
                @csrf
                @method("PATCH")
                <div class="modal-header">
                    <h5 class="modal-title">Editar Notificação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="id" id="notificationID">
                            <div class="mb-3 col-12">
                                <label for="title" class="form-label">Título da Notificação</label><span class="fw-bold text-danger ms-1">*</span>
                                <input class="form-control" type="text" id="title" name="title" value="{{ old('title') }}" placeholder="..." autofocus/>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="content" class="form-label">Conteúdo da Notificação</label><span class="fw-bold text-danger ms-1">*</span>
                                <textarea class="form-control" type="text" name="content" id="content" rows="3">{{ old('content') }}</textarea>
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

    <form method="POST" id="deleteNotificationForm" action="{{ route('admin.notifications.delete', 0) }}">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('page-script')
    <!-- Tagify de seleção de usuários (ADD) -->
    <script>
        const TagifyUserListEl = document.querySelector("#usersTagify");
        const usersList = [
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

    <!-- Modal de edição de notificação -->
    <script>
        $(".edit-notification").click( function(e) {
            let notificationID = $(this).data('notification-id');

            $.get('/api/notification/' + notificationID).done(data => {
                let info = JSON.parse(data.data);
                $("#editNotificationModal form").attr('action', 'http://localhost:8000/admin/notificacoes/update/' + notificationID);
                $("#editNotificationModal #title").val(info.title);
                $("#editNotificationModal #content").html(info.content);

                console.log(JSON.stringify(data.tagify_user));

                $("#editNotificationModal").modal('show');
            }).fail(() => {
                return toastr.error('Oops! Houve um erro!');
            });
        });
    </script>

    <script>
        $(".delete-notification").click( function () {
            let notification = $(this).data("notification-id");

            let deleteCondition = window.confirm("Você tem certeza que gostaria de deletar esta notificação?");

            if(deleteCondition) {
                $("#deleteNotificationForm").attr('action', 'http://localhost:8000/admin/notificacoes/delete/' + notification);

                $("#deleteNotificationForm").submit();
            }
        });
    </script>
@endsection
