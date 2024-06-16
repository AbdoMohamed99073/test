@extends('layout.nav')


@section('content')

<form action="{{route('categoriesstore')}}" method="POST" enctype="multipart/form-data">
@csrf
    @include('dashboard.categories._form',[
        'button_lable' => 'Create'
        ])

</form>




@endsection