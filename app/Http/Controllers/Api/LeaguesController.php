<?php

namespace App\Http\Controllers\Api;

use App\League;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaguesController extends Controller
{
    public function show(Request $request, $id)
    {
        $league = League::findOrFail($id);

        $this->authorize('view', $league);

        return response()->json(['data' => ['id' => $id,'type' => 'league','attributes' => $league->toArray()]
        ]);
    }


}
