<?php

namespace App\Http\Controllers;

use App\Horario;
use Illuminate\Http\Request;
use DataTables;
class HorariosController extends Controller
{
    public function index(Request $request)
    {   

        if ($request->ajax()) {
            
            $data = Horario::latest()->get();
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
      
        return view('horario');
    }


    public function store(Request $request)
    {

        /*$request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);*/
        //$imageName = time().'.'.$request->foto->extension(); 
        //$request->foto->move(public_path('images'), $imageName);
        Horario::updateOrCreate(['id' => $request->product_id],
                ['hora_inicio' => $request->hora_inicio, 'hora_fin' => $request->hora_fin, 'tolerancias' => $request->tolerancias]);        
   
        return response()->json(['success'=>'Horario guardado exitosamente.']);
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
