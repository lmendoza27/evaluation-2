<!DOCTYPE html>
<html>
<head>
    <title>Laravel 7 Ajax CRUD - Employee Registration</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

</head>
<body>
    
<div class="container">
    <h1>Mantenimiento de Marcaciones de Empleados</h1>

    
    <a class="btn btn-success" href="javascript:void(0)" id="createNewProduct"> Fijar horario a empleado</a><br><br>
    <a class="btn btn-warning" href="ajaxemployees"> <b>Empleados</b></a>
    <a class="btn btn-warning" href="ajaxhorarios"> <b> Horarios</b></a>
    <a class="btn btn-warning" href="ajaxasignaciones" id="createNewMarcacion"> <b>Asignación de Horarios</b></a><br><br>
    <table class="table table-bordered data-table">
        <br><br>

        <p>Este es el último proceso, habiendo creado al empleado su horario y la asignación del mismo se procede a registrarlo para marcar su hora de entrada y salida desde este apartado del sitio</p>
    
        <thead>
            <tr>
                <th>N°</th>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>DNI</th>
                <th>Foto</th>
                <th>Hora de Inicio</th>
                <th>Hora de Fin</th>
                <th>Tolerancias</th>
                <th>Entrada</th>
                <th>Salida</th>

                <th width="280px">Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
   
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal" >
                   <input type="hidden" name="product_id" id="product_id">

                   <div class="form-group" id="fecha_form">
                    <label>Fecha</label>
                    <div class="col-sm-12">
                        <input type="date" id="fecha" name="fecha" class="form-control" onChange="guardar()">
                    </div>
                </div>

                   <div class="form-group" id="empleado_form">
                    <label>Empleado</label>
                    <div class="col-sm-12">
                        <select class="form-control" name="asignacion_id" id="asignacion_id" onChange="guardar()">
                            <option value="">Escoge un empleado</option>
                            @foreach ($asignacionData as $empleadote)
                          
                                <option value="{{ $empleadote->id }}"> 

                                DNI: {{ $empleadote->dni }} - Nombre: {{ $empleadote->nombre }} {{ $empleadote->apellidos }} ({{ $empleadote->hora_inicio }} - {{ $empleadote->hora_fin }})
                                </option>
                            @endforeach    
                        </select>
                    </div>
                </div>

                <div class="form-group" id="entrada_form">
                    <label>Marcar Horario de Entrada</label>
                    <div class="col-sm-12">
                        <input type="time" id="entrada" name="entrada" value="00:00"  class="form-control">
                    </div>
                </div>

                <div class="form-group" id="salida_form">
                    <label>Marcar Horario de Salida</label>
                    <div class="col-sm-12">
                        <input type="time" id="salida" name="salida" value="00:00" class="form-control">
                    </div>
                </div>


                    <div class="col-sm-offset-12 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create" disabled>Guardar Cambios
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


</body>
<script>
    function guardar(){
        //alert(document.getElementById("empleado_id").value);
        //alert(document.getElementById("horario_id").value);
         if(document.getElementById("fecha").value.length>=1 && document.getElementById("asignacion_id").value.length>=1) {
            document.getElementById('saveBtn').disabled = false;
            //alert("Hola");
        }
        else { 
          document.getElementById('saveBtn').disabled = true; 
        }
        }
        
          $(function () {
            
            $("#Date_search").val("");
        
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
            });
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "oLanguage": {
                "sSearch": "Búsqueda General",
                "sLengthMenu": "Mostrar _MENU_ registros por página",
                "sInfo": "Mostrando página _PAGE_ de _PAGES_ en total"
                },
                ajax: "{{ route('ajaxmarcaciones.index') }}",
                
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'fecha', name: 'fecha'},
                    {data: 'nombre', name: 'nombre'},
                    {data: 'apellidos', name: 'apellidos'},
                    {data: 'dni', name: 'dni'},
                    {data: 'foto', name: 'foto'},
                    {data: 'hora_inicio', name: 'hora_inicio'},
                    {data: 'hora_fin', name: 'hora_fin'},
                    {data: 'tolerancias', name: 'tolerancias'},
                    {data: 'entrada', name: 'entrada'},
                    {data: 'salida', name: 'salida'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],      columnDefs:
                [{
                    "targets": 5,
                    "data": 'foto',
                    "render": function (data, type, row, meta) {
                        return '<img src="' + data + '" alt="' + data + '"height="90" width="90"/>';
                    }
                }],
            });
        
        
                $('#myInputTextField').on('keyup change', function () {
                table.column(6).search($(this).val()).draw();
                });
                $('#myInputTextField2').on('keyup change', function () {
                table.column(7).search($(this).val()).draw();
                });
                $('#myInputDate1').on('keyup change', function () {
                table.column(8).search($(this).val()).draw();
                });
            $('#createNewProduct').click(function () {
        
                $( "#saveBtn" ).prop( "disabled", true );
                $("#fecha_form").show();
                $("#empleado_form").show();
                $("#entrada_form").hide();
                //$("#entrada").val("10:20:00");
                $("#salida_form").hide();
                $('#saveBtn').val("create-product");
                $('#product_id').val('');
                $('#productForm').trigger("reset");
                $('#modelHeading').html("Crear nueva Marcación");
                $('#ajaxModel').modal('show');
            });
            
            $('body').on('click', '.editProduct', function () {
                $( "#saveBtn" ).prop( "disabled", false );
                //$('#hora_inicio').click();
                $("#fecha_form").hide();
                $("#empleado_form").hide();
                $("#entrada_form").show();
                $("#salida_form").show();
    
              var product_id = $(this).data('id');
              $.get("{{ route('ajaxmarcaciones.index') }}" +'/' + product_id +'/edit', function (data) {
                  $('#modelHeading').html("Editar Marcación");
                  $('#saveBtn').val("edit-user");
                  $('#ajaxModel').modal('show');
                  $('#product_id').val(data.id);
                  $('#fecha').val(data.fecha);
                  $('#asignacion_id').val(data.asignacion_id);
                  $('#hora_inicio').val(data.hora_inicio);
                  $('#hora_fin').val(data.hora_fin);
                  //$('#tolerancias').val(data.tolerancias);
  
  
        
              })
           });
            


            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $.ajax({
                  data: $('#productForm').serialize(),
                  url: "{{ route('ajaxmarcaciones.store') }}",
                  type: "POST",
                  dataType: 'json',
                  success: function (data) {
             
                      $('#productForm').trigger("reset");
                      $('#ajaxModel').modal('hide');
                      table.draw();
                      Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Horario actualizado satisfactoriamente',
                        showConfirmButton: false,
                        timer: 1500
                        })
                  },
                  error: function (data) {
                      console.log('Error:', data);
                      $('#saveBtn').html('Guardar Cambios');
                      Swal.fire('Disculpa, ocurrió un error');
                  }
              });
            });
            
            $('body').on('click', '.deleteProduct', function () {
             
                Swal.fire({
                title: '¿Deseas Eliminar este horario?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Sí',
                
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire('Eliminado!', '', 'success')
                    var product_id = $(this).data("id");
              
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('ajaxmarcaciones.store') }}"+'/'+product_id,
                    success: function (data) {
                        table.draw();
                        Swal.fire({
                        icon: 'error',
                        title: 'Horario Eliminado...',
                        })
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
                } else if (result.isDenied) {
                    Swal.fire('Confirmado, no se eliminó', '', 'info')
                }
                })
        
            });
        

        
        
             
        });


        


    
    </script>

<style>

    .container {
        max-width: 1540px;
        margin-top: 30px;
    }
</style>

</html>