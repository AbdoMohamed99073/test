@extends('layout.nav')


@section('content')


<div class="md-5">
    <a href="{{route('categoriescreate')}}" class="btn btn-sm btn-outline-primary">Create</a>
    <a href="{{route('categoriestrashed')}}" class="btn btn-sm btn-outline-primary">Trashed</a>
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
            <th>Products Number</th>
            <th>Parent</th>
            <th>Status</th>
            <th>created AT</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
            <tr>
                <th><img src="{{asset('storage/' . $category->logo_image)}}" alt="" height="50"></th>
                <th>{{$category->id}}</th>
                <td><a href="{{route('categoriesshow',$category->id)}}">{{$category->name}}</a></td>
                <td>{{$category->products_count}}</td>
                <th>{{$category->parent->name}}</th>
                <th>{{$category->status}}</th>
                <th>{{$category->created_at}}</th>
                <th>
                    <a href="{{route('categoriesedit', $category->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
                </th>
                <th>
                    <form action="{{route('categoriesdelete', $category->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit">DELETE</button>
                    </form>
                </th>
            </tr>
        @empty
            <tr colspan="9">NO Data</tr>
        @endforelse
    </tbody>
</table>

{{$categories->withQueryString()->links()}}
@endsection