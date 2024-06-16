@extends('layout.nav')


@section('content')


<div class="md-5">
    <a href="{{route('categoriesindex')}}" class="btn btn-sm btn-outline-primary">Back</a>
</div>

<x-alerts />

<form action="{{URL::current()}}" method="get">
    <input name = "name" >
    <select name="status" calss="form-control">
        <option value="*">ALL</option>
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
            <th>Status</th>
            <th>Deleted AT</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
            <tr>
                <th><img src="{{asset('storage/' . $category->logo_image)}}" alt="" height="50"></th>
                <th>{{$category->id}}</th>
                <td>{{$category->name}}</td>
                <th>{{$category->status}}</th>
                <th>{{$category->deleted_at}}</th>
                <th>
                <form action="{{route('categoriesrestore', $category->id)}}" method="post">
                        @csrf
                        @method('put')
                        <button type="submit">Restore</button>
                    </form>
                <th>
                    <form action="{{route('categoriesforceDelete', $category->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit">DELETE forever</button>
                    </form>
                </th>
            </tr>
        @empty
            <tr colspan="7">NO Data</tr>
        @endforelse
    </tbody>
</table>

{{$categories->withQueryString()->links()}}
@endsection