<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel App</title>
    <style>
        * { box-sizing: border-box; font-family: system-ui, -apple-system, sans-serif; }
        body { background: #f1f5f9; margin: 0; padding: 2rem; color: #334155; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; color: #0f172a; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; font-weight: 600; margin-bottom: .4rem; }
        input[type="text"], input[type="email"], input[type="password"], input[type="file"] { width: 100%; padding: .6rem; border: 1px solid #cbd5e1; border-radius: 6px; }
        .btn { display: inline-block; padding: .6rem 1.2rem; background: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: .9rem; }
        .btn-danger { background: #dc2626; }
        .btn-secondary { background: #64748b; }
        .alert { padding: .8rem; border-radius: 6px; margin-bottom: 1rem; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { text-align: left; padding: .75rem; border-bottom: 1px solid #e2e8f0; }
        .avatar { width: 45px; height: 45px; border-radius: 50%; object-fit: cover; }
        .nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
      
   
</style>
    </style>

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>
<body>
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        @yield('content')
    </div>

    {{-- <script type='module'>
console.log(window.Echo);
window.Echo.channel('test-channel').listen('TestListner',(event)=>{
    console.log(event);

});
</script> --}}
</body>
</html>