@extends('layouts/contentNavbarLayout')

@section('title', 'Notificações - Minha Conta')


@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Conta /</span> Notificações
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header d-flex flex-column pb-4">Minhas Notificações</h5>
                <ul class="list-group list-group-flush">
                    @forelse($notifications as $notification)
                    <li class="list-group-item list-group-item-action dropdown-notifications-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar">
                                    <img src="{{ $notification->sender_id ? asset('/storage/' . $notification->sender->profile_picture) : asset('/assets/img/avatars/bot.png') }}" alt="" class="w-px-40 h-auto rounded-circle">
                                </div>
                            </div>
                            <div class="flex-grow-1" style="{{ $notification->read ? 'opacity: .75;' : '' }}">
                                <h6 class="mb-1">{{ $notification->title() }}</h6>
                                <p class="mb-0">{{ $notification->content() }}</p>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                            </div>
                            @if(!$notification->read_at)
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                <a href="javascript:void(0)" class="dropdown-notifications-archive mark-read" data-notification-id="{{ $notification->id }}" title="Marcar como lida"><span class="bx bxs-circle" style="font-size: 12px;"></span></a>
                            </div>
                            @endif
                        </div>
                    </li>
                    @empty
                        <p class="text-center">Não foi possível encontrar nenhuma notificação para você ainda. Fique de olho! 👀</p>
                    @endforelse
                </ul>
                <div class="w-100 d-flex justify-content-center mt-4">
                    {!! $notifications->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $(".mark-read").click( function() {
            let id = $(this).data("notification-id");

            $.ajax({
                url: '/minha-conta/notificacoes/read/' + id,
                type: 'PATCH',
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "PATCH"
                }
            }).done(data => {
                if(data.status == 400) {
                    return toastr.error(data.message);
                }

                if(data.status == 200) {

                    $(this).parent().siblings('.flex-grow-1').css("opacity", ".75");
                    $(this).parent().remove();
                    return toastr.success(data.message);
                }
            }).fail(() => {
                return toastr.error("Oops! Houve um erro!");
            });
        });
    </script>
@endsection
