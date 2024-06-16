@extends('layout.nav')


@section('content')
    <form action="{{ route('profileedit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5"
                            width="150px"
                            src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span
                            class="font-weight-bold">Edogaru</span><span
                            class="text-black-50">edogaru@mail.com.my</span><span> </span></div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6"><label class="labels">Frist name</label><input type="text" class="form-control" :value="$user->profile->frist_name"></div>
                            <div class="col-md-6"><label class="labels">Last name</label><input type="text" class="form-control" :value="$user->profile->last_name" ></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">Birthday</label><input type="date" class="form-control" :value="$user->profile->birthday"></div>
                            <div class="col-md-12"><label class="labels">Street Address</label><input type="text" class="form-control"  :value="$user->profile->street"></div>
                            <div class="col-md-12"><label class="labels">Postcode</label><input type="text" class="form-control":value="$user->profile->postal_code"></div>
                            <div class="col-md-12"><label class="labels">State</label><input type="text"  class="form-control" placeholder="enter address line 2" value=""></div>
                            <div class="col-md-12"><label class="labels">Area</label><input type="text" class="form-control" placeholder="enter address line 2" value=""></div>
                            <div class="col-md-12"><label class="labels">Email ID</label><input type="text" class="form-control" placeholder="enter email id" value=""></div>
                            <div class="col-md-12"><label class="labels">Education</label><input type="text"  class="form-control" placeholder="education" value=""></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6"><label class="labels">Country</label><input type="text" class="form-control" placeholder="country" value=""></div>
                            <div class="col-md-6"><label class="labels">State/Region</label><input type="text" class="form-control" value="" placeholder="state"></div>
                        </div>
                        <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit">Save Profile</button></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
