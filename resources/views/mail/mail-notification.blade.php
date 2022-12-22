<x-mail::message>
# Olá, {{ $user->getShortName() }}!

Você recebeu uma nova notificação no nosso sistema, enviada por um oficial.

Veja:

<x-mail::panel>
    <strong>{{ $title }}</strong>
    <br>
    {{ $content }}
    <br>
    <p style="text-align: right"><i>- {{$sender->name}}</i></p>
</x-mail::panel>

<x-mail::button :url="$url">
Ver Todas Notificações
</x-mail::button>

Até a próxima!
<table class="subcopy" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; border-top: 1px solid #e8e5ef; margin-top: 25px; padding-top: 25px;">
    <tbody><tr>
        <td style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
            <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; line-height: 1.5em; margin-top: 0; text-align: left; font-size: 14px;">Se você não quiser receber mais notificações por e-mail, acesse as <span class="break-all" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; word-break: break-all;"><a href="{{ route('account.notifications.config.edit') }}" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; color: #3869d4;">Configurações de Notificações</a></span> e remova as opções por e-mail. :)</p>
        </td>
        </tr>
    </tbody>
</table>
</x-mail::message>
