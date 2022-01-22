<?php

namespace App\Http\Controllers;
use App\Asignacione;
use App\Horario;
use App\Empleado;
use Illuminate\Http\Request;
use DataTables;
use DB;
class AsignacionesController extends Controller
{
    public function index(Request $request)
    {   

        if ($request->ajax()) {
            
            //$data = Asignacione::latest()->get();
            $data = DB::table("asignaciones")
            ->join("empleados as em", "em.id","=","asignaciones.empleado_id")
            ->join("horarios as ho", "ho.id","=","asignaciones.horario_id")
            ->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                    
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct" >Editar</a><br>';
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Borrar</a><br>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);

                }
      //https://www.nicesnippets.com/blog/laravel-select-dropdown-from-database-example
       // $horarioData['horario'] = Horario::latest()->get();     
       //$horarioData = Horario::pluck('hora_fin', 'id'); 
       $horarioData = Horario::select('hora_fin','hora_inicio','id')->get();
       $empleadoData = Empleado::select('dni','nombre','apellidos','dni')->where("estado","=","1")->get();
       //$horarioData = Horario::select('hora_inicio','hora_fin', 'id')->get();

       //dd($horarioData);
                //dd($departmentData);
        return view('asignacion',compact('horarioData','empleadoData'));
    }


    public function store(Request $request)
    {

        /*$request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);*/
        //$imageName = time().'.'.$request->foto->extension(); 
        //$request->foto->move(public_path('images'), $imageName);
        Horario::updateOrCreate(['id' => $request->product_id],
                ['horario_id' => $request->horario_id, 'empleado_id' => $request->empleado_id]);        
   
        return response()->json(['success'=>'Asignación guardada exitosamente.']);
    }

    public function edit($id)
    {
        $employee = Horario::find($id);
        return response()->json($employee);
    }

    public function update($id)
    {

    }


    public function destroy($id)
    {
        Horario::find($id)->delete();
     
        return response()->json(['success'=>'Empleado eliminado satisfactoriamente.']);
    }
}
