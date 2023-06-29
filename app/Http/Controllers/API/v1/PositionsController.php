<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Positions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PositionsController extends Controller
{

    private $positions;
    private $totalRows = 10;

    public function __construct(Positions $positions)
    {
        $this->positions = $positions;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $positions = $this->positions->listPositions($request->name);
        return response()->json(['success' => $positions, 200]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $position = $this->positions->create($request->all());
        return response()->json(['success' => 'Cargo registrado com sucesso.', $position, 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Positions  $positions
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $position = $this->positions->find($id);

        if (!$position) {
            return response()->json(['error' => 'Cargo não encontrado.', 404]);
        }
        
        return response()->json(['success' => $position, 200]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Positions  $positions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $position = $this->positions->find($id);

        if (!$position) {
            return response()->json(['error' => 'Cargo não encontrado.', 404]);
        }

        $position->update($request->all());
        return response()->json(['success' => 'Cargo atualizado com sucesso.', $position, 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Positions  $positions
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $position = $this->positions->find($id);

        if (!$position) {
            return response()->json(['error' => 'Cargo não encontrado.', 404]);
        }

        $position->delete();
        return response()->json(['success' => 'Cargo deletado com sucesso.', 200]);
    }


    public function employees($id) {

        $position = $this->positions->find($id);

        if (!$position) {
            return response()->json(['error' => 'Cargo não encontrado', 404]);
        }

        $employees = $position->employees()->paginate($this->totalRows);
        
        return response()->json([
            'position' => $position,
            'employees' => $employees
        ]);

    }

}
