<?php

namespace App\Http\Controllers;
use App\Empleado;
use Illuminate\Http\Request;
use DataTables;
//use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; 

class EmployeeController extends Controller
{
    public function index(Request $request)
    {   

        if ($request->ajax()) {
            
            $data = Empleado::latest()->get();
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

        /*$request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);*/
        //$imageName = time().'.'.$request->foto->extension(); 
        //$request->foto->move(public_path('images'), $imageName);
        /*Empleado::updateOrCreate(['id' => $request->product_id],
                ['nombre' => $request->nombre, 'apellidos' => $request->apellidos, 'dni' => $request->dni, 'email' => $request->email, 'fecha_nacimiento' => $request->fecha_nacimiento, 'foto' => $request->foto]);        
   
        return response()->json(['success'=>'Empleado guardado exitosamente.']);*/

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->file('foto')) {
            $imagePath = $request->file('foto');
            $imageName = $imagePath->getClientOriginalName();
            $path = $request->file('foto')->storeAs('uploads', $imageName, 'public');
        }

        //dd($request);
        Empleado::updateOrCreate(
            ['id' => $request->product_id],
            ['nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'dni' => $request->dni,
            'email' => $request->email,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'estado' => '1',
            'foto' => '/storage/'.$path,
            ]
        );

        return response()->json(['success' => 'Empleado guardado exitosamente.']);
    }

    public function edit($id)
    {
        $employee = Empleado::find($id);
        return response()->json($employee);
    }

    public function update($id)
    {
        //$employee = Employee::find($id);
        //dd($employee);
        //$employee = Employee::find($id)->value('estado');
        $employee = Empleado::where('id',$id)->value('estado');
        //dd($employee);
        if($employee == "1") {
            Empleado::where('id', $id)->update(array('estado' => '0'));

        return response()->json(['success'=>'Este empleado acaba de ser desactivado']);

        }else{
            Empleado::where('id', $id)->update(array('estado' => '1'));

            return response()->json(['success'=>'Este empleado acaba de ser activado']);
        }
    }


    public function destroy($id)
    {

      
        
         //$file_path = app_path().''.$destroy;
         //$file_path = storage_path($destroy);
         //$file_path = $destroy;
         //unlink($file_path);
         //$productImage = str_replace($destroy);
         //Storage::delete('/public' . $destroy);
         //$filename = '/public' . $destroy;
         //dd($filename);
         //File::delete($filename);
         
        // dd($file_path);
        //dd($destroy);
// unlink($file_path);
$destroy = Empleado::where('id',$id)->value('foto');
File::delete(public_path($destroy));
        Empleado::find($id)->delete();

        return response()->json(['success'=>'Empleado eliminado satisfactoriamente.']);
    }

}
