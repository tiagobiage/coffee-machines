@extends('layouts.app-device')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Escolher qual máquina controlar') }}</div>

                <div class="card-body">
                    @if (session('status'))
                      <div class="alert alert-danger" role="alert">
                          {{ session('status') }}
                      </div>
                    @endif

                    <form method="POST" action="{{ route('device.register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="machine" class="col-md-4 col-form-label text-md-right">{{ __('Cafeteira') }}</label>

                            <div class="col-md-6">                                
                                <select name="machine" id="machine" class="form-control @error('machine') is-invalid @enderror" value="{{ old('machine') }}">
                                  @foreach ($coffeeMachines as $item)                                      
                                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                                  @endforeach
                                </select>
                                @error('machine')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('Código de acesso') }}</label>

                            <div class="col-md-6">
                                <input id="code" type="code" class="form-control @error('code') is-invalid @enderror" name="code" required autocomplete="code">

                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Entrar') }}
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
