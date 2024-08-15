@php
$color = $color ?? '#9055FD';
$height = $height ?? 120;
@endphp
<span style="color:{{ $color }};">
  <img style="height: {{$height}}px" src="{{asset('assets/img/logo-v2.svg')}}" alt="">
</span>
