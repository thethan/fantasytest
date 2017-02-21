<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\GetUserDraftsPreDraftStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DraftController extends Controller
{
    protected $job;

    public function __construct()
    {
        $this->job = new GetUserDraftsPreDraftStatus();
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function index(Request $request)
    {
        return response()->json(
            ['data' =>
                [   'id' => $request->user('api')->id,
                    'type' => 'games',
                    'attributes' => ['games' =>
                        $this->job->handle($request->user('api'))]
            ]]
        );
    }

}
