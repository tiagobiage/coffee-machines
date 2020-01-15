@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul class="menu-dash">                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.coffee') }}">{{ __('Cafés') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.coffee-machine') }}">{{ __('Cafeteiras') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.employee') }}">{{ __('Funcionários') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.order') }}">{{ __('Pedidos') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.ranking') }}">{{ __('Ranking') }}</a>
                        </li>                    
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
