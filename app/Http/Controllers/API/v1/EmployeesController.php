<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEmployeesFormRequest;
use Illuminate\Http\Request;
use App\Models\Employees;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployeesController extends Controller
{

    private $employees;
    private $path = 'employees';

    public function __construct(Employees $employees)
    {
        $this->employees = $employees;
    }

    public function team($id) {

        $employees = $this->employees->find($id);

        if (!$employees) {
            return response()->json(['error' => 'Funcionário não encontrado', 404]);
        }

        $team = $employees->teams()->get();

        return response()->json([
            'employees' => $employees,
            'team' => $team
        ]);

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = $this->employees->listEmployees($request->name);
        return response()->json(['success' => $employees, 200]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateEmployeesFormRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $name = Str::kebab($request->name);

            $extension = $request->image->extension();
            
            $nameFile = "{$name}.{$extension}";
            $data['image'] = $nameFile;

            $upload = $request->image->storeAs($this->path, $nameFile);

            if (!$upload)
                return response()->json(['error' => 'Fail_Upload'], 500);
        }

        $employee = $this->employees->create($request->all());
        return response()->json(['success' => $employee, 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = $this->employees->find($id);

        if (!$employee) {
            return response()->json(['error' => 'Funcionário não encontrado.', 404]);
        }

        $employee = $this->employees->find($id);
        return response()->json(['success' => $employee, 200]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateEmployeesFormRequest $request, $id)
    {
        $data = $request->all();
        $employee = $this->employees->find($id);

        if (!$employee) {
            return response()->json(['error' => 'Funcionário não encontrado.', 404]);
        }

        if ($employee->image) {

            if ($request->image) {
                if (Storage::exists("{$this->path}/{$employee->image}"))
                    Storage::delete("{$this->path}/{$employee->image}");
            }

            if (!$request->image) {

                $old_extension = explode(".", $employee->image)[1];
                $new_name_img = Str::kebab($request->name);
                $old_name_img = $employee->image;            
                
                $nameFile = "{$new_name_img}.{$old_extension}";
                $data['image'] = $nameFile;

                Storage::move("{$this->path}/{$old_name_img}", "{$this->path}/{$nameFile}");

            }
            
        }

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $name = Str::kebab($request->name);

            $extension = $request->image->extension();
            
            $nameFile = "{$name}.{$extension}";
            $data['image'] = $nameFile;

            $upload = $request->image->storeAs($this->path, $nameFile);

            if (!$upload)
                return response()->json(['error' => 'Fail_Upload'], 500);
        }

        $employee->update($data);
        return response()->json([$employee, 'success' => 'O registro foi atualizado com sucesso.', 200]);        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = $this->employees->find($id);

        if (!$employee) {
            return response()->json(['error' => 'Funcionário não encontrado.', 404]);
        }

        $employee->delete();
        return response()->json(['success' => 'Registro deletado com sucesso.', 200]);

    }
}
