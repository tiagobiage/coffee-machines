@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cafés 

                  <ul class="navbar-nav float-right">
                    <li><a href="{{route('admin.coffee.add')}}">Novo</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  @if (session('status'))
                      <div class="alert alert-success" role="alert">
                          {{ session('status') }}
                      </div>
                  @endif
                  
                  @if (count($coffees) > 0)                  
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($coffees as $item)                          
                      <tr>
                        <th scope="row">{{$item->id}}</th>
                        <td>{{$item->name}}</td>
                        <td>{{$item->description}}</td>
                        <td width="150">
                          <a href="{{url('admin/coffee/edit/'.$item->id)}}" class="btn btn-primary btn-sm">editar</a>
                          <a href="{{url('admin/coffee/delete/'.$item->id)}}" class="btn btn-danger ml-2 btn-sm">excluir</a>
                        </td>
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