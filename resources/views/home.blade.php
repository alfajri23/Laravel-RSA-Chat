@extends('layouts.app')

@section('content')
<style type="text/css">

    a{
        color: #3d607c !important;
    }

    a:link{
        text-decoration: none;
        margin: 10px 0;
    }

    .card{
        width: 100% !important;
        border-radius: 20px;
        background-color: #cde9e0;
    }

</style>

<div class="container py-3">
    <div class="row justify-content-center my-3">
        <h3>Pilih Teman Chatmu</h3>
    </div>

    <div class="row flex-column justify-content-center px-4">
        @foreach($users as $user)
        <a href="{{route('main-chat',$user["id"])}}">
            <div class="card my-0" style="width: 90%;">
              <div class="card-body">
                <h5 class="card-title font-weight-bold">{{$user["name"]}}</h5>
              </div>
            </div>
        </a>
        @endforeach
    </div>

</div>
@endsection
