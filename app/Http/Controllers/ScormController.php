<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Peopleaps\Scorm\Manager\ScormManager;
use Peopleaps\Scorm\Model\ScormModel;

class ScormController extends Controller
{
    /** @var ScormManager $scormManager */
    private $scormManager;
    /**
     * ScormController constructor.
     * @param ScormManager $scormManager
     */
    public function __construct(ScormManager $scormManager)
    {
        $this->scormManager = $scormManager;
    }

    public function show($id)
    {
        $item = ScormModel::with('scos')->findOrFail($id);
        // dd($item);
        // response helper function from base controller reponse json.
        $html = file_get_contents(storage_path("app/".$item['uuid'].'/'.$item['entry_url']));
        // storage_path('app/public')
        return view('scorm-view')
            ->with('item', $html );
    }

    public function store(Request $request)
    {
        $request->resource_type = null;
        $request->resource_id   = null;

        try {
            $scorm = $this->scormManager->uploadScormArchive($request->file('file'));
            // handle scorm runtime error msg
        } catch (InvalidScormArchiveException | StorageNotFoundException $ex) {
            return $this->respondCouldNotCreateResource(trans('scorm.' .  $ex->getMessage()));
        }

        // response helper function from base controller reponse json.
        return response()->json([ScormModel::with('scos')->whereUuid($scorm['uuid'])->first()]);
    }

    public function saveProgress(Request $request)
    {
        // TODO save user progress...
    }
    public function create() {
        return view('scorm');
    }
}
