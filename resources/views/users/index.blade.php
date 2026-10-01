@extends('layouts.app')

@section('content')
<div class="nav">
    <h2>User Dashboard</h2>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-secondary">Logout</button>
    </form>
    @can('create', App\Models\Products::class)
    <a href="{{route('addproducts')}}" class="btn" style="">Add products</a>
   
    @endcan

    <a href="{{route('showproducts')}}" class="btn" style="">Show products </a>
    <a href="{{route('message')}}" class="btn" style="">Message </a>
</div>

<table>
    <thead>
        <tr>
            <th>Profile</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>
                @if($user->profile_pic)
                    <img src="{{ asset('storage/' . $user->profile_pic) }}" class="avatar">
                @else
                    <div class="avatar" style="background:#cbd5e1; display:flex; align-items:center; justify-content:center; font-weight:bold;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
            </td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>


                {{-- <a href="{{ route('users.edit', $user->id) }}" class="btn" style="padding: .3rem .6rem; font-size: .8rem;">Edit</a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="padding: .3rem .6rem; font-size: .8rem;" onclick="return confirm('Delete user?')">Delete</button>
                </form> --}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection