<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTeamsFormRequest;
use App\Models\Teams;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class TeamsController extends Controller
{

    private $teams;
    private $path = 'teams';

    public function __construct(Teams $teams)
    {
        $this->teams = $teams;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $teams = $this->teams->listTeams($req->name);
        return response()->json(['success' => $teams, 200]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateTeamsFormRequest $request)
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

        $team = $this->teams->create($request->all());
        return response()->json(['success' => $team, 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = $this->teams->getTeam($id);
        
        if (!$team) {
            return response()->json(['error' => 'Time não encontrado.', 404]);
        }

        return response()->json(['success' => $team, 200]);

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
        $team = $this->teams->find($id);
        
        if (!$team) {
            return response()->json(['error' => 'Time não encontrado.', 404]);
        }

        $team->update($request->all());
        return response()->json([$team, 'success' => 'Registro atualizado com sucesso', 200]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = $this->teams->find($id);
        
        if (!$team) {
            return response()->json(['error' => 'Time não encontrado.', 404]);
        }

        $team->delete();
        return response()->json(['success' => 'O registro do time foi deletado.', 200]);

    }
}
