<?php

namespace App\Http\Controllers;
use App\Employee;
use Illuminate\Http\Request;
use DataTables;


class EmployeeController extends Controller
{
    public function index(Request $request)
    {   

        if ($request->ajax()) {
            
            $data = Employee::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                    
                        if($row->estado == "1"){

                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct" >Editar</a><br>';
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Borrar</a><br>';
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Update" class="btn btn-secondary btn-sm inactiveProduct">Desactivar</a>';

                            return $btn;

                        }else{
                            $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Update" class="btn btn-success btn-sm inactiveProduct">Activar</a>';
 
                             return $btn;  
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);

                }
      
        return view('employee');
    }


    public function store(Request $request)
    {
        Employee::updateOrCreate(['id' => $request->product_id],
                ['nombre' => $request->nombre, 'apellidos' => $request->apellidos, 'dni' => $request->dni, 'email' => $request->email, 'fecha_nacimiento' => $request->fecha_nacimiento, 'cargo' => $request->cargo, 'area' => $request->area, 'fecha_inicio' => $request->fecha_inicio, 'fecha_fin' => $request->fecha_fin, 'tipo_contacto' => $request->tipo_contacto, 'estado' => '1']);        
   
        return response()->json(['success'=>'Empleado guardado exitosamente.']);
    }

    public function edit($id)
    {
        $employee = Employee::find($id);
        return response()->json($employee);
    }

    public function update($id)
    {
        //$employee = Employee::find($id);
        //dd($employee);
        //$employee = Employee::find($id)->value('estado');
        $employee = Employee::where('id',$id)->value('estado');
        //dd($employee);
        if($employee == "1") {
        Employee::where('id', $id)->update(array('estado' => '0'));

        return response()->json(['success'=>'Este empleado acaba de ser desactivado']);

        }else{
            Employee::where('id', $id)->update(array('estado' => '1'));

            return response()->json(['success'=>'Este empleado acaba de ser activado']);
        }
    }


    public function destroy($id)
    {
        Employee::find($id)->delete();
     
        return response()->json(['success'=>'Empleado eliminado satisfactoriamente.']);
    }

}
