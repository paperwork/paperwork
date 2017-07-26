<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Paperwork\Helpers\PaperworkHelpers;
use Paperwork\Helpers\PaperworkHelpersFacade;

class ApiCalendarController extends BaseController
{
    public $restful = true;

    public function index(Request $request)
    {
        $notes = DB::table('notes')
            ->join('note_user', function ($join) use ($request) {
                $join->on('notes.id', '=', 'note_user.note_id')
                    ->where('note_user.user_id', '=', $request->user()->id);
            })
            ->join('notebooks', function ($join) {
                $join->on('notes.notebook_id', '=', 'notebooks.id');
            })
            ->join('versions', function ($join) {
                $join->on('notes.version_id', '=', 'versions.id');
            })
            ->select('notes.id', 'versions.title', DB::raw('DATE(notes.updated_at) as updated_at'))
            ->whereNull('notes.deleted_at')
            ->whereNull('notebooks.deleted_at')
            ->get()
            ->all();

        $indexed = array_reduce($notes, function (&$array, $item) {
            if (!isset($array[$item->updated_at])) {
                $array[$item->updated_at] = array();
            }

            $array[$item->updated_at][] = $item;
            return $array;
        }, array());

        return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_SUCCESS, $indexed);
    }
}
