@extends('layouts/contentNavbarLayout')

@section('title', 'Pesquisa de Membros - Minha Conta')


@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Pesquisar /</span> Membros
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header d-flex flex-column pb-4">Resultados para a pesquisa</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Aniversário</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @forelse($users as $user)
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
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="999">Não conseguimos encontrar nenhum resultado para a busca feita :(</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex w-100 justify-content-center mt-4">
                    {!! $users->withQueryString()->links() !!}
                </div>

            </div>
        </div>
    </div>
@endsection

@section('page-script')

@endsection
