@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cafeteiras 

                  <ul class="navbar-nav float-right">
                    <li><a href="{{route('admin.coffee-machine.add')}}">Novo</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  @if (session('status'))
                      <div class="alert alert-success" role="alert">
                          {{ session('status') }}
                      </div>
                  @endif
                  
                  @if (count($machines) > 0)                  
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Código de acesso</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($machines as $item)                          
                      <tr>
                        <th scope="row">{{$item->id}}</th>
                        <td>{{$item->name}}</td>
                        <td>{{$item->description}}</td>
                        <td>{{$item->access_code}}</td>
                        <td width="150">
                          <a href="{{url('admin/coffee-machine/edit/'.$item->id)}}" class="btn btn-primary btn-sm">editar</a>
                          <a href="{{url('admin/coffee-machine/delete/'.$item->id)}}" class="btn btn-danger ml-2 btn-sm">excluir</a>
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

            <div class="card mt-5 d-none">
              <div class="card-header">
                QR-codes
                <ul class="navbar-nav float-right">
                  <li><button class="btn btn-primary btn-sm" onclick="window.print()">Imprimir</button></li>
                </ul>
              </div>

              <div class="card-body">
                <div id="qr-codes"></div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
<style>
 @media print{
   *{
    visibility: hidden;
   }

   #qr-codes, #qr-codes *{
     visibility: visible !important;
   }
 }
</style>
@section('script-end-page')
<script>
  (function() {
    setTimeout(() => {      
      return false;
      var typeNumber = 20;
      var errorCorrectionLevel = "H";
      @foreach ($machines as $item) 
      var divEl = document.createElement("div");
      var qr = qrcode(typeNumber, errorCorrectionLevel);
      var dataCode = '{{$item->json}}';
      var txt = document.createElement('textarea');
      txt.innerHTML = dataCode;
      dataCode = txt.value;      
      qr.addData(dataCode);
      qr.make();
      divEl.innerHTML = qr.createImgTag();
      var hEl = document.createElement("h5");
      var t = document.createTextNode('{{$item->name}}');
      hEl.append(t);
      divEl.append(hEl);
      document.getElementById("qr-codes").append(divEl);
      @endforeach
    }, 1000);
  })();
</script>
@endsection