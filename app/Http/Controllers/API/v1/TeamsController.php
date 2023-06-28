<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTeamsFormRequest;
use App\Models\Teams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function employees($id) {

        $teams = $this->teams->find($id);

        if (!$teams) {
            return response()->json(['error' => 'Time não encontrado', 404]);
        }

        $employees = $teams->employees()->get();

        return response()->json([
            'teams' => $teams,
            'employees' => $employees
        ]);

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
    public function update(StoreUpdateTeamsFormRequest $request, $id)
    {
        $data = $request->all();
        $team = $this->teams->find($id);

        if (!$team) {
            return response()->json(['error' => 'Time não encontrado.', 404]);
        }

        if ($team->image) {

            if ($request->image) {
                if (Storage::exists("{$this->path}/{$team->image}"))
                    Storage::delete("{$this->path}/{$team->image}");
            }

            if (!$request->image) {

                $old_extension = explode(".", $team->image)[1];
                $new_name_img = Str::kebab($request->name);
                $old_name_img = $team->image;            
                
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

        $team->update($data);
        return response()->json([$team, 'success' => 'O registro foi atualizado com sucesso.', 200]);

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
