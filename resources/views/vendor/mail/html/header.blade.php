@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;
    font-family: 'Newsreader', serif;
    font-weight: 400;
    font-size: 36px;
    letter-spacing: 0.1em;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
