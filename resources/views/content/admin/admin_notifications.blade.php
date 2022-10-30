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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNotificationModal" @cannot('notifications.edit') disabled @endcannot>Adicionar Notificação</button>
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
                    <h5 class="modal-title" id="addUserTitle">Enviar uma Notificação</h5>
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
                                <textarea class="form-control" type="text" name="message" id="content" rows="3">{{ old('content') }}</textarea>
                            </div>
                            <div class="mb-3 col-12">
                                <div class="d-flex justify-content-between">
                                    <div class="label-wrapper">
                                        <label for="usersTagify" class="form-label">Destinatários</label><span class="fw-bold text-danger ms-1">*</span>
                                    </div>
                                    <!--<span class="remove-all-notifications form-label text-danger mb-0 pt-1 cursor-pointer">Remover Todos</span>-->
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
@endsection

@section('page-script')
    <!-- Tagify de seleção de usuários -->
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

        $(".remove-all-notifications").click( function() {
            console.log(TagifyUserList);
            TagifyUserList.removeAllTags.bind(TagifyUserList);
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
@endsection
