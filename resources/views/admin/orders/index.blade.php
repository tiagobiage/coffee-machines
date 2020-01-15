@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Pedidos</div>

                <div class="card-body">
                  @if (session('status'))
                      <div class="alert alert-success" role="alert">
                          {{ session('status') }}
                      </div>
                  @endif                  
                  @if (count($orders) > 0)       
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Máquina</th>
                        <th scope="col">Café</th>
                        <th scope="col">Funcionário</th>
                        <th scope="col">Avaliação</th>
                        <th scope="col">Criando em</th>   
                        <th scope="col"></th>                     
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($orders as $item)                          
                      <tr>
                        <th scope="row">{{$item->id}}</th>
                        <td>{{$item->CoffeeMachine->name}}</td>
                        <td>{{$item->coffee->name}}</td>
                        <td>{{$item->employee->code}}</td>
                        <td>{{$item->rating}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>{{$item->expired ? 'expirou':''}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  @else
                  <div class="alert alert-info" role="alert">
                      Nenhum registro encontrado
                  </div>
                  @endif                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
