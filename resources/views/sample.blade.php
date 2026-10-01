{{-- {{date_default_timezone_set('Asia/Karachi')}}
<h1>hello {{$name}} </h1>
time is {{ date('Y-M-D H-i-s',time())}}

{{ url()->current()}}
@php
  $url =url()->full();  

@endphp
{{ url()->full()}}
{{url()->previousPath()}}
{{urldecode($url)}}

{{route('user', ['user' => 2])}}


<h2>{{URL::signedRoute('user', ['user' => 12], absolute: false)}}</h2>

<h3>{{URL::signedRoute('sample')}}</h3>
<h4>{{URL::temporarySignedRoute('user', now()->plus(minutes:30),['user' =>13],absolute:false)}}</h4> --}}

@php
  print_r($errors->all());
  
@endphp

{{'sdfsadfasdasdasd'}}
@error('name')
  
@enderror