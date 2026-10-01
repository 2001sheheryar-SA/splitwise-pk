@extends('layouts.app')

@section('content')
<h2>Add Product</h2>
<form action="{{ route('products') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Product Name</label>
        <input type="text" name="name" required>
    </div>
    <div class="form-group">
        <label>Description</label>
        <input type="text" name="description" required>
    </div>
    <div class="form-group">
        <label>Price</label>
        <input type="text" name="price" required>
    </div>
    <div class="form-group">
        <label>Quantity</label>
        <input type="text" name="quantity" required>
    </div>

    <button type="submit" class="btn">Add</button>
    {{-- <a href="" style="margin-left: 10px;">Show Products</a> --}}

  <a href="{{route('showproducts')}}" style="margin-left: 10px;">Show Products</a> 
</form>
@endsection