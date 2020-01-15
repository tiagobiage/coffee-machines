@extends('layouts.app-device')
@section('content')
<div class="container">
    <device-index idcoffeemachine="{{$idCoffeeMachine}}" accesscode="{{$access_code}}"></device-index>
</div>
@endsection
