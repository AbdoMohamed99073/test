@extends('layout.nav')


@section('content')

<form action="{{route('categoriesupdate',$category->id)}}" method="POST" enctype="multipart/form-data">
@csrf
    @method('put')
    @include('dashboard.categories._form',[
        'button_lable' => 'Update'
        ])

</form>




@endsection