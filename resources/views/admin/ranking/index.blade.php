@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Ranking</div>

                <div class="card-body">
                  @if (session('status'))
                      <div class="alert alert-success" role="alert">
                          {{ session('status') }}
                      </div>
                  @endif                  
                  @if (count($ranking) > 0)       
                  <table class="table table-striped">
                    <thead>
                      <tr>                        
                        <th scope="col">Café</th>
                        <th scope="col">Avaliação</th>                      
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($ranking as $item)                          
                      <tr>                                                
                        <td>{{$item->coffee}}</td>                        
                        <td>{{$item->ratingAverage}}</td>
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
