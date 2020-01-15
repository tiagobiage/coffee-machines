@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                  {{ __('Cafeteiras | Novo') }}
                  <ul class="navbar-nav float-right">
                    <li><a href="{{route('admin.coffee-machine')}}"><< voltar</a></li>
                  </ul>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.coffee-machine.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="url" class="col-md-4 col-form-label text-md-right">{{ __('URL') }}</label>

                            <div class="col-md-6">
                                <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url') }}"  autocomplete="url" autofocus>
                                <small>O ip da máquina. Ex: http://192.168.1.10</small>
                                @error('url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Descrição') }}</label>

                            <div class="col-md-6">
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                <small class="d-none">ex: {"url" : "http://192.168.1.10", "coffees":  {"1": "Expresso", "2": "Longo", "3": "Cappuccino"}}</small>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="coffees" class="col-md-4 col-form-label text-md-right">{{ __('Cafés') }}</label>
                                <div class="col-md-6">
                                <select multiple name="coffees[]" id="coffees" class="form-control">
                                @foreach ($coffees as $item) 
                                    <option value="{{$item->id}}">{{$item->name}} | {{$item->description}}</option>
                                @endforeach
                                </select>                        
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-success float-right">
                                    {{ __('Salvar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
