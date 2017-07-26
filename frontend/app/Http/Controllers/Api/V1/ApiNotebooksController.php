<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Models\Notebook;
use App\Models\Shortcut;
use App\Models\User;
use PaperworkDb;
use Paperwork\Helpers\PaperworkHelpers;
use Paperwork\Helpers\PaperworkHelpersFacade;

class ApiNotebooksController extends BaseController
{
    const NOTEBOOK_ALL_ID = '00000000-0000-0000-0000-000000000000';
    protected $dates = ['deleted_at'];
    public $restful = true;

    // private function getNotebookChildren($notebookId) {
    // 	$children = DB::table('notebooks')
    // 		->join('notebook_user', function($join) {
    // 			$join->on('notebooks.id', '=', 'notebook_user.notebook_id')
    // 				->where('notebook_user.user_id', '=', Auth::user()->id);
    // 		})
    // 		->select('notebooks.uuid AS id', 'notebooks.type', 'notebooks.title')
    // 		->where('notebooks.parent_id', '=', $notebookId)
    // 		->whereNull('notebooks.deleted_at')
    // 		->get();
    // 	return $children;
    // }

    public function index()
    {
        // $notebooks = DB::table('notebooks')
        // 	->join('notebook_user', function($join) {
        // 		$join->on('notebooks.id', '=', 'notebook_user.notebook_id')
        // 			->where('notebook_user.user_id', '=', Auth::user()->id);
        // 	})
        // 	->select('notebooks.uuid AS id', 'notebooks.type', 'notebooks.title')
        // 	->where('notebooks.parent_id', '=', null)
        // 	->whereNull('notebooks.deleted_at')
        // 	->get();

        // foreach($notebooks as $notebook) {
        // 	$notebook->children = $this->getNotebookChildren($notebook->id);
        // }

        $notebooks = PaperworkDb::notebook()->get()->toArray();
        array_unshift($notebooks, array('id' => PaperworkDb::DB_ALL_ID, 'type' => '2', 'title' => Lang::get('notebooks.all_notes')));
        return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_SUCCESS, $notebooks);
    }

    public function show($id = null)
    {
        // if (is_null($id ))
        // {
        // 	return index();
        // }
        // else
        // {
        // 	$notebook = DB::table('notebooks')
        // 		->join('notebook_user', function($join) {
        // 			$join->on('notebooks.id', '=', 'notebook_user.notebook_id')
        // 				->where('notebook_user.user_id', '=', Auth::user()->id);
        // 		})
        // 		->select('notebooks.uuid AS id', 'notebooks.type', 'notebooks.title')
        // 		->where('notebooks.uuid', '=', $id)
        // 		->whereNull('notebooks.deleted_at')
        // 		->first();

        // 	if(is_null($notebook)){
        // 		return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_NOTFOUND, array());
        // 	} else {
        // 		$notebook->children = $this->getNotebookChildren($id);
        // 		return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_SUCCESS, $notebook);
        // 	}
        // }
        $notebooks = PaperworkDb::notebook()->get(array('id' => explode(PaperworkHelpersFacade::MULTIPLE_REST_RESOURCE_DELIMITER, $id)))->toArray();
        if (empty($notebooks)) {
            return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_NOTFOUND, array());
        }
        return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_SUCCESS, $notebooks);
    }


    public function store()
    {
        $validator = $this->getNewNotebookValidator();
        if ($validator->passes()) {
            $newNotebook = Input::json();

            $notebook = Notebook::create(array('title' => $newNotebook->get('title'), 'type' => $newNotebook->get('type')));
            $notebook->save();

            $notebook->users()->attach(Auth::user()->id, array('umask' => PaperworkHelpersFacade::UMASK_OWNER));

            if ($newNotebook->get('shortcut')) {
                $shortcut = new Shortcut(array('sortkey' => 255, 'user_id' => Auth::user()->id));
                $notebook->shortcuts()->save($shortcut);
            }

            return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_SUCCESS, $notebook);
        } else {
            return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_ERROR, $validator->getMessageBag()->toArray());
        }
    }

    protected function getNewNotebookValidator()
    {
        return Validator::make(Input::all(), [ "title" => "required", "type" => "required"]);
    }


    public function update($notebookId)
    {
        $validator = $this->getNewNotebookValidator();
        if ($validator->passes()) {
            $updateNotebook = Input::json();

            $notebook = User::find(Auth::user()->id)->notebooks()->wherePivot('umask', '>', PaperworkHelpersFacade::UMASK_READONLY)->where('notebooks.id', '=', $notebookId)->whereNull('notebooks.deleted_at')->first();

            if (is_null($notebook)) {
                return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_NOTFOUND, array());
            }
            $notebook->title = $updateNotebook->get('title');
            $notebook->save();

            $shortcut = Shortcut::where('user_id', '=', Auth::user()->id)->where('notebook_id', '=', $notebook->id);

            if ($updateNotebook->get('shortcut') == true) {
                if ($shortcut->count()<1) {
                    $shortcut = new Shortcut(array('sortkey' => 255, 'user_id' => Auth::user()->id));
                    $notebook->shortcuts()->save($shortcut);
                }
            } else {
                if ($shortcut->count()>0) {
                    $shortcut->delete();
                }
            }

            return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_SUCCESS, $notebook);
        } else {
            return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_ERROR, $validator->getMessageBag()->toArray());
        }
    }

    public function destroy($notebookId)
    {
        $notebook = User::find(Auth::user()->id)->notebooks()->wherePivot('umask', '=', PaperworkHelpersFacade::UMASK_OWNER)->where('notebooks.id', '=', $notebookId)->whereNull('notebooks.deleted_at')->first();

        if (is_null($notebook)) {
            return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_NOTFOUND, array());
        }
        $deletedNotebook = $notebook;

        $shortcut = Shortcut::where('user_id', '=', Auth::user()->id)->where('notebook_id', '=', $notebook->id);
        if ($shortcut->count()>0) {
            $shortcut->delete();
        }

        //Check if notebook is a collection
        if ($notebook->type == 1) {
            $notebooks = User::find(Auth::user()->id)->notebooks()->wherePivot('umask', '=', PaperworkHelpersFacade::UMASK_OWNER)->where('notebooks.parent_id', '=', $notebook->id)->whereNull('notebooks.deleted_at')->get();
            foreach ($notebooks as $row) {
                $childNotebook = User::find(Auth::user()->id)->notebooks()->wherePivot('umask', '=', PaperworkHelpersFacade::UMASK_OWNER)->where('notebooks.id', '=', $row->id)->whereNull('notebooks.deleted_at')->first();
                $childNotebook->parent_id = null;
                $childNotebook->save();
            }
        }

        $notebook->delete();

        return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_SUCCESS, $deletedNotebook);
    }


    private function shareNotebook($notebookId, $toUserId, $toUMASK)
    {
        $notebook=User::find(Auth::user()->id)->notebooks()
                        ->wherePivot('umask', '=', PaperworkHelpersFacade::UMASK_OWNER)
                        ->where('notebooks.id', '=', $notebookId)
                        ->whereNull('notebooks.deleted_at')
                        ->first();
        if (is_null($notebook)) {
            return null;
        }
        $toUser=User::find($toUserId);
        if (is_null($toUser)) {
            return null;
        } //user with which we want to share the note doesn't exist
        $toUser=$notebook->users()->where('users.id', '=', $toUserId)->first();
        if (!is_null($toUser)) {
            if ($toUser->pivot->umask==PaperworkHelpersFacade::UMASK_OWNER) {
                return null;
            }
            if ($toUMASK==0) {//set UMASK to 0 to stop sharing
            $notebook->users()->detach($toUserId);
                $notebook->save();
                return $notebook;
            }
            if ($toUser->pivot->umask!=$toUMASK) {
                $notebook->users()->updateExistingPivot($toUserId, array('umask' => $toUMASK));
                $notebook->save();
                return $notebook;
            }
        }
        if (is_null($toUser)) {
            $notebook->users()->attach($toUserId, array('umask' => $toUMASK)); //add user
            // return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_NOTFOUND, array('item'=>'user'));
            $notebook->save();
            return $notebook;
        }
    }

    public function removeNotebookFromCollection($notebookId)
    {
        $notebook = Notebook::find($notebookId);
        $notebook->parent_id = null;
        if ($notebook->save()) {
            return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_SUCCESS, $notebook);
        } else {
            return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_NOTFOUND, $notebook);
        }
    }

    public function share($notebookId, $toUserId, $toUMASK)
    {
        $toUserIds = explode(PaperworkHelpersFacade::MULTIPLE_REST_RESOURCE_DELIMITER,
            $toUserId);
        $toUMASKs=explode(PaperworkHelpersFacade::MULTIPLE_REST_RESOURCE_DELIMITER,
            $toUMASK);
        if (count($toUserIds)!=count($toUMASKs)) {//as much toUsers as toUmasks, if not raise an Error.
            return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_ERROR, array('error_id' => $noteId));
        }
        $responses = array();
        $status    = PaperworkHelpersFacade::STATUS_SUCCESS;
        for ($i=0; $i<count($toUserIds); $i++) {//adding a loop to share with multiple users
            $tmp = $this->shareNotebook($notebookId, $toUserIds[$i], $toUMASKs[$i]);
            if (is_null($tmp)) {
                $status      = PaperworkHelpersFacade::STATUS_ERROR;
                $responses[] = array('error_id' => $notebookId);
            } else {
                $responses[] = $tmp;
            }
        }
        return PaperworkHelpers::apiResponse($status, $responses);
    }

    public function storeCollection()
    {
        $validator = $this->getNewCollectionValidator();
        if ($validator->passes()) {
            $data = Input::json();
            $collection = Notebook::create(array('title' => $data->get('title'), 'type' => 1));
            $collection->save();
            $collection->users()->attach(Auth::user()->id, array('umask' => PaperworkHelpersFacade::UMASK_OWNER));
            $notebooks = $data->get('notebooks');
            for ($i = 0; $i < count($notebooks); $i++) {
                $notebook = Notebook::find($notebooks[$i]);
                $notebook->parent_id = $collection->id;
                $notebook->save();
            }
            return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_SUCCESS, $collection);
        } else {
            return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_ERROR, $validator->getMessageBag()->toArray());
        }
    }

    protected function getNewCollectionValidator()
    {
        return Validator::make(Input::all(), ["title" => "required"]);
    }

    public function updateCollection($collectionId)
    {
        $idArray = [];
        $validator = $this->getNewCollectionValidator();
        if ($validator->passes()) {
            $updateCollection = Input::json();

            $collection = User::find(Auth::user()->id)->notebooks()->wherePivot('umask', '>', PaperworkHelpersFacade::UMASK_READONLY)->where('notebooks.id', '=', $collectionId)->whereNull('notebooks.deleted_at')->first();

            if (is_null($collection)) {
                return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_NOTFOUND, array());
            }
            $collection->title = $updateCollection->get('title');
            $collection->save();

            $children = User::find(Auth::user()->id)->notebooks()->wherePivot('umask', '>', PaperworkHelpersFacade::UMASK_READONLY)->where('notebooks.parent_id', '=', $collectionId)->whereNull('notebooks.deleted_at')->get()->toArray();
            $newChildren = $updateCollection->get('notebooks');

            foreach ($children as $child) {
                $idArray[] = $child["id"];
            }

            $addedChildren = array_diff($newChildren, $idArray);
            if (count($addedChildren) > 0) {
                foreach ($addedChildren as $addedChild) {
                    $addedChild = User::find(Auth::user()->id)->notebooks()->wherePivot('umask', '>', PaperworkHelpersFacade::UMASK_READONLY)->where('notebooks.id', '=', $addedChild)->whereNull('notebooks.deleted_at')->first();
                    $addedChild->parent_id = $collectionId;
                    $addedChild->save();
                }
            }

            $removedChildren = array_diff($idArray, $newChildren);
            if (count($removedChildren) > 0) {
                foreach ($removedChildren as $removedChild) {
                    $removedChild = User::find(Auth::user()->id)->notebooks()->wherePivot('umask', '>', PaperworkHelpersFacade::UMASK_READONLY)->where('notebooks.id', '=', $removedChild)->whereNull('notebooks.deleted_at')->first();
                    $removedChild->parent_id = null;
                    $removedChild->save();
                }
            }

            return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_SUCCESS, $collection);
        } else {
            return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_ERROR, $validator->getMessageBag()->toArray());
        }
    }
}
