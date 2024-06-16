@extends('layout.nav')


@section('content')

<table class="table">
    <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Store</th>
            <th>Status</th>
            <th>created AT</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @php
        $products = $category->products()->with('store')->paginate();
        @endphp
        @forelse($products as $product)
            <tr>
                <th><img src="{{asset('storage/' . $product->logo_image)}}" alt="" height="50"></th>
                <td>{{$product->name}}</td>
                <th>{{$product->store->name}}</th>
                <th>{{$product->status}}</th>
                <th>{{$product->created_at}}</th>
            </tr>
        @empty
            <tr colspan="2">NO Data</tr>
        @endforelse
    </tbody>
</table>
{{$products->links()}}

@endsection