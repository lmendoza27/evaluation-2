<!DOCTYPE html>
<html>
<head>
    <title>Laravel 7 Ajax CRUD - Employee Registration</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>
    
<div class="container">
    <h1>Registro de Empleados</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewProduct"> Registrar Empleado</a>
    <table class="table table-bordered data-table" id="example">
        <br><br>
        <label ><b>Buscar por Cargo</b>
        <input type="text" id="myInputTextField">
        <br><br>
        <label ><b>Buscar por Área</b>
        <input type="text" id="myInputTextField2">
        </label>
        <br><br><br>
 
        <label><b>Rango Inicial</b>
            <input type="date" id="myInputDate1">
        </label> 

  
        <thead>
            <tr>
                <th>N°</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>DNI</th>
                <th>Correo Electrónico</th>
                <th>Fecha de Nacimiento</th>
                <th>Cargo</th>
                <th>Área</th>
                <th>Fecha de Inicio (Contrato)</th>
                <th>Fecha de Fin (Contrato)</th>
                <th>Tipo de Contrato</th>
                
                <th width="280px">Action</th>
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
                <form id="productForm" name="productForm" class="form-horizontal">
                   <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-12 control-label">Nombre (mínimo 4 dígitos)</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa Nombre" value="" maxlength="50" required="" id="nombre" onkeyup="guardar()">
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-12 control-label">Apellidos (mínimo 2 dígitos)</label>
                        <div class="col-sm-12">
                            <input id="apellidos" name="apellidos" required="" placeholder="Ingresa Apellidos" class="form-control" onkeyup="guardar()">
                        </div>
                    </div>

                    <div class="form-group" id="label_dni">
                        <label class="col-sm-12 control-label">DNI (8 dígitos)</label>
                        <div class="col-sm-12">
                            <input type="number" id="dni" name="dni" required="" placeholder="Ingresa tu DNI" class="form-control" onkeyup="guardar()">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-12 control-label">Correo Electrónico (mínimo 2 dígitos)</label>
                        <div class="col-sm-12">
                            <input type="email" id="email" name="email" required="" placeholder="Ingresa tu Correo Electrónico" class="form-control" onkeyup="guardar()">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-12 control-label">Fecha de Nacimiento (requerido)</label>
                        <div class="col-sm-12">
                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required="" placeholder="Ingresa tu Correo Electrónico" class="form-control" onChange="guardar()">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-12 control-label">Cargo (mínimo 4 dígitos)</label>
                        <div class="col-sm-12">
                            <input id="cargo" name="cargo" required="" placeholder="Ingresa tu Cargo" class="form-control" onkeyup="guardar()">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-12 control-label">Área (mínimo 3 dígitos)</label>
                        <div class="col-sm-12">
                            <input id="area" name="area" required="" placeholder="Ingresa tu Área" class="form-control" onkeyup="guardar()">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-12 control-label">Fecha Inicio de Contrato (requerido)</label>
                        <div class="col-sm-12">
                            <input type="date" id="fecha_inicio" name="fecha_inicio" required="" placeholder="Ingresa tu Correo Electrónico" class="form-control" onChange="guardar()">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-12 control-label">Fecha Fin de Contrato (requerido)</label>
                        <div class="col-sm-12">
                            <input type="date" id="fecha_fin" name="fecha_fin" required="" placeholder="Ingresa tu Correo Electrónico" class="form-control" onChange="guardar()">
                        </div>
                    </div> 


                    <div class="form-group">
                        <label class="col-sm-12 control-label">Tipo de Contacto (mínimo 3 dígitos)</label>
                        <div class="col-sm-12">
                            <input id="tipo_contacto" name="tipo_contacto" required="" placeholder="Ingresa tu Tipo de Contacto" class="form-control" onkeyup="guardar()">
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
    
<script type="text/javascript">

function guardar(){
if(document.getElementById("nombre").value.length>=4 && document.getElementById("apellidos").value.length>=2 && document.getElementById("dni").value.length>=8 && document.getElementById("dni").value.length<=8 && document.getElementById("email").value.length>=2 && document.getElementById("fecha_nacimiento").value.length>=1 && document.getElementById("cargo").value.length>=4 && document.getElementById("area").value.length>=3 && document.getElementById("fecha_inicio").value.length>=1 && document.getElementById("fecha_fin").value.length>=1 && document.getElementById("tipo_contacto").value.length>=3) { 
     document.getElementById('saveBtn').disabled = false;
}
else { 
  document.getElementById('saveBtn').disabled = true; 
}
}


  $(function () {
     
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    //$("#myInputDate1").datepicker();
    //$("#myInputDate1").datepicker("option", "dateFormat", 'yy-mm-dd');


    var table = $('.data-table').DataTable({
      
        processing: true,
        serverSide: true,
        ajax: "{{ route('ajaxemployees.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nombre', name: 'nombre'},
            {data: 'apellidos', name: 'apellidos'},
            {data: 'dni', name: 'dni'},
            {data: 'email', name: 'email'},
            {data: 'fecha_nacimiento', name: 'fecha_nacimiento'},
            {data: 'cargo', name: 'cargo'},
            {data: 'area', name: 'area'},
            {data: 'fecha_inicio', name: 'fecha_inicio'},
            {data: 'fecha_fin', name: 'fecha_fin'},
            {data: 'tipo_contacto', name: 'tipo_contacto'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
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
        //$( "#dni" ).prop( "disabled", false );
        $('#dni').show();
          $('#label_dni').show();
        $('#saveBtn').val("create-product");
        $('#product_id').val('');
        $('#productForm').trigger("reset");
        $('#modelHeading').html("Create New Product");
        $('#ajaxModel').modal('show');
    });
    
    $('body').on('click', '.editProduct', function () {
      var product_id = $(this).data('id');
      $.get("{{ route('ajaxemployees.index') }}" +'/' + product_id +'/edit', function (data) {
          $('#modelHeading').html("Editar Empleado");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#product_id').val(data.id);
          $('#nombre').val(data.nombre);
          $('#apellidos').val(data.apellidos);
          $('#dni').val(data.dni);
          $('#dni').hide();
          $('#label_dni').hide();
          //$( "#dni" ).prop( "disabled", true );
          $('#email').val(data.email);
          $('#fecha_nacimiento').val(data.fecha_nacimiento);
          $('#cargo').val(data.cargo);
          $('#area').val(data.area); 
          $('#fecha_inicio').val(data.fecha_inicio); 
          $('#fecha_fin').val(data.fecha_fin); 
          $('#tipo_contacto').val(data.tipo_contacto);  

      })
   });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        
        //$(this).html('Sending..');
    
        $.ajax({
          data: $('#productForm').serialize(),
          url: "{{ route('ajaxemployees.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#productForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
    
    $('body').on('click', '.deleteProduct', function () {
     
        var product_id = $(this).data("id");
        //confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('ajaxemployees.store') }}"+'/'+product_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });


     
});


</script>
</html>