@extends('layouts.app')

@section('content')

<style>
    /* Scale down oversized SVG pagination arrows */
    {{-- .pagination-container svg,
    
    nav[role="navigation"] svg {
        width: 16px !important;
        height: 16px !important;
        display: inline-block;
    }

    /* Keep the pagination controls horizontal and clean */
    nav[role="navigation"] div:last-child {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    nav[role="navigation"] span,
    nav[role="navigation"] a {
        padding: 6px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        color: #333;
    } --}}
</style>
<div class="nav">
    <h2>Show Products List</h2>
    
    <a href="{{route('addproducts')}}" class="btn" style="">Add products</a>
    <a href="{{route('dashboard')}}" class="btn" style="">Dashboard</a>
   
</div>

<table>
    <thead>
        <tr>
            <th>Sr</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $index => $data)
        <tr>
            <td>{{$loop->index }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->description }}</td>
            <td>{{ $data->quantity }}</td>
            <td>{{ $data->price }}</td>
            <td>


                
            </td>
        </tr>
        @endforeach
       
    </tbody>
</table>

<div>
    {{ $products->links('pagination::bootstrap-5') }}
</div>
@endsection