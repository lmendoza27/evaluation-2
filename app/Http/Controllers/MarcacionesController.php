<?php

namespace App\Http\Controllers;

use App\Marcacione;
use App\Asignacion;
use Illuminate\Http\Request;
use DataTables;
use DB;

class MarcacionesController extends Controller
{
    public function index(Request $request)
    {   

        /*$data = Marcacione::latest()->get();
        dd($data);*/            
        /*$data = DB::table("marcaciones")
            ->join('asignaciones', 'asignaciones.id', '=', 'marcaciones.asignacion_id')
            ->join('empleados', 'empleados.id', '=', 'asignaciones.empleado_id')
            ->join('horarios', 'horarios.id', '=', 'asignaciones.horario_id')
            ->select('marcaciones.id','horarios.id as ho','empleados.id as em','asignaciones.id as as','empleados.nombre','empleados.apellidos','empleados.dni','empleados.foto','horarios.hora_inicio','horarios.hora_fin','horarios.tolerancias')
            //->select('asignaciones.id','empleados.id as emoo','empleados.nombre','empleados.apellidos','empleados.dni','empleados.email','horarios.id as ho','horarios.hora_inicio','horarios.hora_fin','horarios.tolerancias')
            ->get();
        dd($data);*/
        if ($request->ajax()) {
            
            //$data = Marcacione::latest()->get();
            $data = DB::table("marcaciones")
            ->join('asignaciones', 'asignaciones.id', '=', 'marcaciones.asignacion_id')
            ->join('empleados', 'empleados.id', '=', 'asignaciones.empleado_id')
            ->join('horarios', 'horarios.id', '=', 'asignaciones.horario_id')
            ->select('marcaciones.id','horarios.id as ho','empleados.id as em','fecha','asignaciones.id as as','empleados.nombre','empleados.apellidos','empleados.dni','empleados.foto','horarios.hora_inicio','horarios.hora_fin','horarios.tolerancias','entrada','salida')
             ->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                    
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct" >Marcar Entrada y Salida</a><br><br>';
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Borrar</a><br>';
                            return $btn;

                    })
                    ->rawColumns(['action'])
                    ->make(true);

                }
      
            //$asignacionData = Asignacion::select('hora_fin','hora_inicio','id')->get();
            $asignacionData = DB::table("asignaciones")
            ->join('empleados', 'empleados.id', '=', 'asignaciones.empleado_id')
            ->join('horarios', 'horarios.id', '=', 'asignaciones.horario_id')
            ->select('asignaciones.id','empleados.id as emoo','empleados.nombre','empleados.apellidos','empleados.dni','empleados.email','horarios.id as ho','horarios.hora_inicio','horarios.hora_fin','horarios.tolerancias')
            ->get();
               // dd($asignacionData);

        return view('marcacion',compact('asignacionData'));
    }


    public function store(Request $request)
    {

        Marcacione::updateOrCreate(
            ['id' => $request->product_id],
            ['fecha' => $request->fecha,
            'asignacion_id' => $request->asignacion_id,
            'entrada' => $request->entrada,
            'salida' => $request->salida,
            ]
        );

        return response()->json(['success' => 'Empleado guardado exitosamente.']);
    }

    public function edit($id)
    {
        $employee = Marcacione::find($id);
        return response()->json($employee);
    }

    public function update($id)
    {

    }


    public function destroy($id)
    {
        Marcacione::find($id)->delete();
     
        return response()->json(['success'=>'Empleado eliminado satisfactoriamente.']);
    }
}
