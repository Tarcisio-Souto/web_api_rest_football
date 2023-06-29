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
        return $this->positions = $positions;
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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Positions  $positions
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Positions  $positions
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Positions  $positions
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
