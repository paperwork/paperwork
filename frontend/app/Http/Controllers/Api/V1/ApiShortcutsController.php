<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Paperwork\Helpers\PaperworkHelpers;
use Paperwork\Helpers\PaperworkHelpersFacade;

class ApiShortcutsController extends BaseController
{
    public $restful = true;

    public function index()
    {
        $shortcuts = DB::table('notebooks')
            ->join('shortcuts', function ($join) {
                $join->on('notebooks.id', '=', 'shortcuts.notebook_id')
                    ->where('shortcuts.user_id', '=', Auth::user()->id);
            })
            ->select('notebooks.id', 'notebooks.parent_id', 'notebooks.type', 'notebooks.title', 'shortcuts.id as shortcut_id', 'shortcuts.sortkey')
            ->get();

        return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_SUCCESS, $shortcuts);
    }

    public function show($id = null)
    {
        if (is_null($id)) {
            return index();
        } else {
            $shortcuts = DB::table('notebooks')
                ->join('shortcuts', function ($join) {
                    $join->on('notebooks.id', '=', 'shortcuts.notebook_id')
                        ->where('shortcuts.user_id', '=', Auth::user()->id);
                })
                ->select('notebooks.id', 'notebooks.parent_id', 'notebooks.type', 'notebooks.title', 'shortcuts.id', 'shortcuts.sortkey')
                ->where('notebooks.id', '=', $id)
                ->first();

            if (is_null($shortcuts)) {
                return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_NOTFOUND, array());
            } else {
                return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_SUCCESS, $shortcuts);
            }
        }
    }
}
