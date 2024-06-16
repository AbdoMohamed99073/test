@extends('layout.nav')


@section('content')


<div class="md-5">
    <a href="{{route('productscreate')}}" class="btn btn-sm btn-outline-primary">Create</a>
    
</div>

<x-alerts />

<form action="{{URL::current()}}" method="get">
    <input name = "name" >
    <select name="status" calss="form-control">
        <option value="">ALL</option>
        <option value="active">active</option>
        <option value="archived">archived</option>
    </select>
    <button class="btn btn-dark">Filter</button>
</form>
<table class="table">
    <thead>
        <tr>
            <th>Image</th>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Store</th>
            <th>Status</th>
            <th>created AT</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
            <tr>
                <th><img src="{{asset('storage/' . $product->logo_image)}}" alt="" height="50"></th>
                <th>{{$product->id}}</th>
                <td>{{$product->name}}</td>
                <th>{{$product->category->name}}</th>
                <th>{{$product->store->Name}}</th>
                <th>{{$product->status}}</th>
                <th>{{$product->created_at}}</th>
                <th>
                    <a href="{{route('productsedit', $product->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
                </th>
                <th>
                    <form action="{{route('productsdelete', $product->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit">DELETE</button>
                    </form>
                </th>
            </tr>
        @empty
            <tr colspan="7">NO Data</tr>
        @endforelse
    </tbody>
</table>

{{$products->withQueryString()->links()}}
@endsection