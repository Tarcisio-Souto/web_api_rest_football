<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\States;
use Illuminate\Http\Request;

class StatesController extends Controller
{

    private $states;

    public function __construct(States $states)
    {
        $this->states = $states;
    }

    public function teams($id) {

        $states = $this->states->find($id);

        if (!$states) {
            return response()->json(['error' => 'Estado não encontrado', 404]);
        }

        $teams = $states->teams()->get();

        return response()->json([
            'states' => $states,
            'teams' => $teams
        ]);

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $states = $this->states->listPositions($request->name);
        return response()->json(['success' => $states, 200]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $state = $this->states->create($request->all());
        return response()->json(['success' => 'Estado registrado com sucesso.', $state, 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $state = $this->states->find($id);

        if (!$state) {
            return response()->json(['error' => 'Estado não encontrado.', 404]);
        }
        
        return response()->json(['success' => $state, 200]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $state = $this->states->find($id);

        if (!$state) {
            return response()->json(['error' => 'Estado não encontrado.', 404]);
        }

        $state->update($request->all());
        return response()->json(['success' => 'Estado atualizado com sucesso.', $state, 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $state = $this->states->find($id);

        if (!$state) {
            return response()->json(['error' => 'Estado não encontrado.', 404]);
        }

        $state->delete();
        return response()->json(['success' => 'Estado deletado com sucesso.', 200]);
    }
}
