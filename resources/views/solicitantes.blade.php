<?php
    use App\Solicitud;
    use App\Beca;
    $beca     = Beca::where('id',$id_beca)->first();
    $records  = Solicitud::where('id_beca',$id_beca)->Paginate(5);
    $contador = 1;
    if ($beca->ganador == 0) {
        $llave = 0;
    } else {
        $llave = 1;
    }
    
?>
@extends('layouts.app')
@section('content')
<style type="text/css">
.alert {
  padding: 15px;
  margin-bottom: 20px;
  border: 1px solid transparent;
  border-radius: 4px;
}
.alert h4 {
  margin-top: 0;
  color: inherit;
}
.alert .alert-link {
  font-weight: bold;
}
.alert > p,
.alert > ul {
  margin-bottom: 0;
}
.alert > p + p {
  margin-top: 5px;
}
.alert-dismissable,
.alert-dismissible {
  padding-right: 35px;
}
.alert-dismissable .close,
.alert-dismissible .close {
  position: relative;
  top: -2px;
  right: -21px;
  color: inherit;
}
.alert-success {
  color: #3c763d;
  background-color: #dff0d8;
  border-color: #d6e9c6;
}
.alert-success hr {
  border-top-color: #c9e2b3;
}
.alert-success .alert-link {
  color: #2b542c;
}
.alert-info {
  color: #31708f;
  background-color: #d9edf7;
  border-color: #bce8f1;
}
.alert-info hr {
  border-top-color: #a6e1ec;
}
.alert-info .alert-link {
  color: #245269;
}
.alert-warning {
  color: #8a6d3b;
  background-color: #fcf8e3;
  border-color: #faebcc;
}
.alert-warning hr {
  border-top-color: #f7e1b5;
}
.alert-warning .alert-link {
  color: #66512c;
}
.alert-danger {
  color: #a94442;
  background-color: #f2dede;
  border-color: #ebccd1;
}
.alert-danger hr {
  border-top-color: #e4b9c0;
}
.alert-danger .alert-link {
  color: #843534;
}
    #myInput {
    background-image: url('/css/searchicon.png'); /* Add a search icon to input */
    background-position: 10px 12px; /* Position the search icon */
    background-repeat: no-repeat; /* Do not repeat the icon image */
    width: 100%; /* Full-width */
    font-size: 16px; /* Increase font-size */
    padding: 12px 20px 12px 40px; /* Add some padding */
    border: 1px solid #ddd; /* Add a grey border */
    margin-bottom: 12px; /* Add some space below the input */
}
#myTable {
    border-collapse: collapse; /* Collapse borders */
    width: 100%; /* Full-width */
    border: 1px solid #ddd; /* Add a grey border */
    font-size: 18px; /* Increase font-size */
}
#myTable th, #myTable td {
    text-align: left; /* Left-align text */
    padding: 12px; /* Add padding */
}
#myTable tr {
    /* Add a bottom border to all table rows */
    border-bottom: 1px solid #ddd; 
}
#myTable tr.header, #myTable tr:hover {
    /* Add a grey background color to the table header and on hover */
    background-color: #f1f1f1;
}
</style>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="padding: 20px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Selecionar beneficiario</h4>
                </div>
                <form class="form-horizontal" action="{{url('api/crear/beca')}}" method="post" data-toggle="validator">
                <div class="modal-body">
                        <div class="form-group has-feedback" >
                            <label for="grado">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre">
                        </div>
                          <div class="form-group has-feedback" >
                            <label for="grado">Descripcion</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group has-feedback" >
                            <label for="grado">Ubicacion</label>
                            <input type="text" class="form-control" name="ubicacion" id="ubicacion">
                        </div>
                        <div class="form-group has-feedback" >
                            <label for="grado">Fecha inicio</label>
                            <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio">
                        </div>
                        <div class="form-group has-feedback" >
                            <label for="grado">Fecha fin</label>
                            <input type="date" class="form-control" name="fecha_fin" id="fecha_fin">
                        </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

<div class="container">
    <div class="row">
        <div class="">
            <div class="panel panel-default" style="padding-left: 50px;padding-right: 50px;">
                <div class="panel-heading">Lista de solicitantes - {{ $beca->nombre }}</div><br>
                <form class="form-horizontal" action="{{ url('/home') }}" method="get" data-toggle="validator">
                    <button type="submit" class="btn btn-warning bnt-rounded">
                        <i class="fa fa-plus"></i> <- Regresar
                    </button>
                </form>
                @if(Session::has('message'))
                    <div class="alert alert-dismissible alert-success" class="col-md-10">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <i class="fa fa-check-square"></i>{{Session::get('message')}}
                    </div>
                @endif
                <div style="overflow-x:scroll;">
                    <div align="right" style="margin-top: 20px;margin-right: 20px">
                        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Buscar .."> 
                    </div>
                    <br>
                     <table id="myTable" class="table table-striped">
                        <!-- <thead> -->
                            <tr class="header">
                                <th style="margin-left: 10px;padding-left: 10px;margin-right: 10px;padding-right: 10px;">#</th>
                                <th style="margin-left: 10px;padding-left: 10px;margin-right: 10px;padding-right: 10px;">Nombre</th>
                                <th style="margin-left: 10px;padding-left: 10px;margin-right: 10px;padding-right: 10px;">Identificacion</th>
                                <th style="margin-left: 10px;padding-left: 10px;margin-right: 10px;padding-right: 10px;">Telefono</th>
                                <th style="margin-left: 10px;padding-left: 10px;margin-right: 10px;padding-right: 10px;">Email</th>
                                <th style="margin-left: 10px;padding-left: 10px;margin-right: 10px;padding-right: 10px;">Nombre padre</th>
                                <th style="margin-left: 10px;padding-left: 10px;margin-right: 10px;padding-right: 10px;">Nombre madre</th>
                                <th style="margin-left: 10px;padding-left: 10px;margin-right: 10px;padding-right: 10px;">Comentario</th>
                                <th style="margin-left: 10px;padding-left: 10px;margin-right: 10px;padding-right: 10px;">Fecha nacimiento</th>
                                <th style="margin-left: 10px;padding-left: 10px;margin-right: 10px;padding-right: 10px;">Beneficiar</th>
                            </tr>
                        <!-- </thead> -->
                        <tbody>
                            @foreach($solicitantes as $index => $item)
                            <tr>    
                                <td>{{ $index + $records->firstItem() }}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->identificacion }}</td>
                                <td>{{ $item->telefono }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->nombre_padre }}</td>
                                <td>{{ $item->nombre_madre }}</td>
                                <td>{{ $item->comentario }}</td>
                                <td>{{ $item->fecha_nacimiento }}</td>
                               
                                <td>
                                    @if($llave == 0)
                                    <form class="form-horizontal" action="{{url('api/selecionar/beneficiario')}}" method="post" data-toggle="validator">
                                        <input type="text" value="{{$id_beca}}" hidden="true" id="id_beca" name="id_beca">
                                        <input type="text" value="{{$item->id}}" hidden="true" id="id_solicitante" name="id_solicitante">
                                        <button class="btn btn-primary" type="submit">Seleccionar</button>
                                    </form>
                                    @else
                                        <button class="btn btn-primary" type="submit" disabled="true">Seleccionar</button>
                                    @endif
                                </td>
                            </tr>
                            @php
                                $contador = $contador + 1
                            @endphp
                            @endforeach
                        </tbody>
                </table>
                <h5>Mostrando {{ $records->firstItem() }} - {{ $records->lastItem() }}</h5>
                {!! $records->render() !!}
                </div>
               
                
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery-1.11.2.min.js"></script>
<script>
function myFunction() {
  // Declare variables 
 var $rows = $('#myTable tr');
$('#myInput').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
    $('.header').show();
});
}
</script>
@endsection