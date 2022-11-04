@extends('layouts.contentNavbarLayout')

@section('title', 'Aniversário dos Membros')

@section('content')
    <div class="row">
        <div class="nav-align-left">
            <ul class="nav nav-tabs" role="tablist">
                @foreach($monthsNames as $i => $month)
                    <li class="nav-item">
                        <button type="button" class="nav-link {{ \Carbon\Carbon::now()->format('n') - 1 == $i ? 'active' : '' }}" role="tab" data-bs-toggle="tab" data-bs-target="#month-{{ $i }}">
                            {{ $month }}
                        </button>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content" style="width: 1%;">
                @foreach($userBirthdays as $i => $users)
                    <div class="tab-pane fade w-100 {{ \Carbon\Carbon::now()->format('n') - 1 == $i ? 'show active' : '' }}" id="month-{{ $i }}">
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
                                @forelse($users->sortBy(fn($e) => \Carbon\Carbon::parse($e->birth_date)->format('d')) as $user)
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
                                        <td colspan="999" class="text-center">Não existe nenhum membro com aniversário em {{ $monthsNames[$i]  }}.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@section('page-script')

@endsection
