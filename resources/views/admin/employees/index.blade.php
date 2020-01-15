@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Funcionários</div>

                <div class="card-body">
                  @if (session('status'))
                      <div class="alert alert-success" role="alert">
                          {{ session('status') }}
                      </div>
                  @endif
                  
                  @if (count($employees) > 0)                  
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Criando em</th>                        
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($employees as $item)                          
                      <tr>
                        <th scope="row">{{$item->code}}</th>
                        <td>{{$item->name}}</td>
                        <td>{{$item->created_at}}</td>
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
