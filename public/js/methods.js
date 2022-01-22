function guardar(){

    var form = document.getElementById('productForm');
    var text = document.getElementById('warning');
    var email = document.getElementById('email').value;
    var pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
     if(document.getElementById("nombre").value.length>=4 && document.getElementById("apellidos").value.length>=2 && document.getElementById("dni").value.length>=8 && document.getElementById("dni").value.length<=8 && email.match(pattern) && document.getElementById("fecha_nacimiento").value.length>=1 && document.getElementById("cargo").value.length>=4 && document.getElementById("area").value.length>=3 && document.getElementById("fecha_inicio").value.length>=1 && document.getElementById("fecha_fin").value.length>=1 && document.getElementById("tipo_contacto").value.length>=3) {
        document.getElementById('saveBtn').disabled = false;
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
            var form = document.getElementById('productForm');
            var text = document.getElementById('warning');
            var email = document.getElementById('email').value;
            var pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    
            form.classList.remove('valid');
            form.classList.add('invalid');
            text.innerHTML = "Por favor, ingresa el formato válido para correo";
            text.style.color = "#ff0000";
    
            $( "#saveBtn" ).prop( "disabled", true );
            $('#dni').show();
              $('#label_dni').show();
            $('#saveBtn').val("create-product");
            $('#product_id').val('');
            $('#productForm').trigger("reset");
            $('#modelHeading').html("Create New Product");
            $('#ajaxModel').modal('show');
        });
        
        $('body').on('click', '.editProduct', function () {
            $( "#saveBtn" ).prop( "disabled", false );
            var form = document.getElementById('productForm');
            var text = document.getElementById('warning');
            var email = document.getElementById('email').value;
            var pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    
            form.classList.add('valid');
            form.classList.remove('invalid');
            text.innerHTML = "Tu Correo Electrónico es válido";
            text.style.color = "#00ff00";
    
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
      
        
            $.ajax({
              data: $('#productForm').serialize(),
              url: "{{ route('ajaxemployees.store') }}",
              type: "POST",
              dataType: 'json',
              success: function (data) {
         
                  $('#productForm').trigger("reset");
                  $('#ajaxModel').modal('hide');
                  table.draw();
                  Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Empleado actualizado satisfactoriamente',
                    showConfirmButton: false,
                    timer: 1500
                    })
              },
              error: function (data) {
                  console.log('Error:', data);
                  $('#saveBtn').html('Guardar Cambios');
                  Swal.fire('Disculpa, el DNI introducido ya existe');
              }
          });
        });
        
        $('body').on('click', '.deleteProduct', function () {
         
            Swal.fire({
            title: '¿Deseas Eliminar a este empleado?',
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
                url: "{{ route('ajaxemployees.store') }}"+'/'+product_id,
                success: function (data) {
                    table.draw();
                    Swal.fire({
                    icon: 'error',
                    title: 'Eliminado...',
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
    
        $('body').on('click', '.inactiveProduct', function () {
         
         var product_id = $(this).data("id");
       
         $.ajax({
             type: "PUT",
             url: "{{ route('ajaxemployees.store') }}"+'/'+product_id,
             success: function (data) {
                $.get("{{ route('ajaxemployees.index') }}" +'/' + product_id +'/edit', function (data) {
                if(data.estado == "1") {
                    Swal.fire({
                icon: 'success',
                title: 'Empleado Activado',
                showConfirmButton: false,
                timer: 1500
                })
                }else {
                    Swal.fire({
                icon: 'error',
                title: 'Empleado Desactivado',
                showConfirmButton: false,
                timer: 1500
                })
                }
    
          })
                 table.draw();
             },
             error: function (data) {
                 console.log('Error:', data);
             }
         });
     });
    
    
         
    });
    
    var start = document.getElementById('fecha_inicio');
    var end = document.getElementById('fecha_fin');
    
    start.addEventListener('change', function() {
        if (start.value)
            end.min = start.value;
    }, false);
    end.addEventLiseter('change', function() {
        if (end.value)
            start.max = end.value;
    }, false);
    
    function validation() {
    var form = document.getElementById('productForm');
    var text = document.getElementById('warning');
    var email = document.getElementById('email').value;
    var pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    
    if(email.match(pattern)){
        //form.
        form.classList.add('valid');
        form.classList.remove('invalid');
        text.innerHTML = "Tu Correo Electrónico es válido";
        text.style.color = "#00ff00";
    }else{
        form.classList.remove('valid');
        form.classList.add('invalid');
        text.innerHTML = "Por favor, ingresa el formato válido para correo";
        text.style.color = "#ff0000";
    }
    
    }


