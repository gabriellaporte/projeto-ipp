@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
<span class="app-brand-logo demo">@include('_partials.macros',['width'=>25,'withbg' => "#696cff"])</span>
<span class="app-brand-text demo text-body fw-bolder">{{ config('variables.templateName') }}</span>
</a>
</td>
</tr>
