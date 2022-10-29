<div class="table-responsive text-nowrap">
    <table class="table table-hover">
        <thead>
        <tr>
            <th class="text-center">#</th>
            <th>
                <a href="{{ route('index', [] + (!request()->has('sort') || request()->get('sort') == 'name' ? ['sort' => '-name'] : ['sort' => 'name'])) }}">Nome
                    <i class='bx bx-filter'></i></a></th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Aniversário</th>
            <th>Status</th>
            @can('users.edit')<th>Ações</th>@endcan
        </tr>
        </thead>
        <tbody class="table-border-bottom-0">
        @foreach($users as $user)
            <tr>
                <td class="d-flex justify-content-center" style="display: table-cell !important;">
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                        class="avatar avatar-xs pull-up" title=""
                        data-bs-original-title="Foto de {{ explode(' ', $user->name)[0] }}"><img
                            src="{{asset('storage/' . $user->profile_picture )}}" alt="Avatar"
                            class="rounded-circle"></li>
                </td>
                <td><strong>{{ $user->name  }}</strong></td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->mobile_phone  }}</td>
                <td>{{ \Carbon\Carbon::parse($user->birth_date)->translatedFormat('d/m/Y')  }}</td>
                <td>
                    @if($user->hasRole(['Oficial']))
                        <span class="badge bg-label-info me-1">Oficial</span>
                    @else
                        <span class="badge bg-label-primary me-1">Membro</span>
                    @endif
                </td>
                @can('users.edit')
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="true"><i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu"
                                 style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(-145px, 27px);"
                                 data-popper-placement="bottom-end">
                                @can('users.edit')
                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                @endcan
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
    {!! $users->links() !!}
</div>
