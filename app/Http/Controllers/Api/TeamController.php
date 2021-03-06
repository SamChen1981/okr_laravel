<?php

namespace App\Http\Controllers\Api;

use App\Models\Individual;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $individualId = $request->input('individualId');

        return Team::withJoined($individualId)->get();
    }

    public function store(Request $request)
    {
        $individual = \Auth::user()->individual;

        $team = new Team([
            'name' => $request->input('name'),
            'organization_id' => $individual->organization->id,
        ]);
        \DB::transaction(function () use ($individual, $team) {
            $team->save();
            $individual->teams()->save($team);
        });

        return $team;
    }

    public function join(Request $request)
    {
        $team = Team::findOrFail($request->input('teamId'));
        $individual = Individual::where('user_id', \Auth::id())->firstOrFail();

        try {
            $team->individuals()->save($individual);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return ['status' => 'already joined'];
            }
        }
        return ['status' => 'ok'];
    }
}
