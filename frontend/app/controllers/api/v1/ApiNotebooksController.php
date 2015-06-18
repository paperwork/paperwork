<?php

class ApiNotebooksController extends BaseController {
	use SoftDeletingTrait;

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
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $notebooks);
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
		// 		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
		// 	} else {
		// 		$notebook->children = $this->getNotebookChildren($id);
		// 		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $notebook);
		// 	}
		// }
		$notebooks = PaperworkDb::notebook()->get(array('id' => explode(PaperworkHelpers::MULTIPLE_REST_RESOURCE_DELIMITER, $id)))->toArray();
		if(empty($notebooks)) {
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
		}
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $notebooks);
	}


	public function store()
	{
		$validator = $this->getNewNotebookValidator();
		if($validator->passes()) {
			$newNotebook = Input::json();

			$notebook = Notebook::create(array('title' => $newNotebook->get('title'), 'type' => $newNotebook->get('type')));
			$notebook->save();

			$notebook->users()->attach(Auth::user()->id, array('umask' => PaperworkHelpers::UMASK_OWNER));

			if($newNotebook->get('shortcut')) {
				$shortcut = new Shortcut(array('sortkey' => 255, 'user_id' => Auth::user()->id));
				$notebook->shortcuts()->save($shortcut);
			}

			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $notebook);
		} else {
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_ERROR, $validator->getMessageBag()->toArray());
		}
	}

	protected function getNewNotebookValidator() {
		return Validator::make(Input::all(), [ "title" => "required", "type" => "required"]);
	}


	public function update($notebookId)
	{
		$validator = $this->getNewNotebookValidator();
		if($validator->passes()) {
			$updateNotebook = Input::json();

			$notebook = User::find(Auth::user()->id)->notebooks()->wherePivot('umask','>',PaperworkHelpers::UMASK_READONLY)->where('notebooks.id', '=', $notebookId)->whereNull('notebooks.deleted_at')->first();

			if(is_null($notebook)){
				return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
			}
			$notebook->title = $updateNotebook->get('title');
			$notebook->type = $updateNotebook->get('type');
			$notebook->save();

			$shortcut = Shortcut::where('user_id', '=', Auth::user()->id)->where('notebook_id', '=', $notebook->id);

			if($updateNotebook->get('shortcut') == true) {
				if($shortcut->count()<1) {
					$shortcut = new Shortcut(array('sortkey' => 255, 'user_id' => Auth::user()->id));
					$notebook->shortcuts()->save($shortcut);
				}
			} else {
				if($shortcut->count()>0) {
					$shortcut->delete();
				}
			}

			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $notebook);
		}
		else {
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_ERROR, $validator->getMessageBag()->toArray());
		}
	}

	public function destroy($notebookId)
	{
		$notebook = User::find(Auth::user()->id)->notebooks()->wherePivot('umask','=', PaperworkHelpers::UMASK_OWNER)->where('notebooks.id', '=', $notebookId)->whereNull('notebooks.deleted_at')->first();

		if(is_null($notebook))
		{
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
		}
		$deletedNotebook = $notebook;

		$shortcut = Shortcut::where('user_id', '=', Auth::user()->id)->where('notebook_id', '=', $notebook->id);
		if($shortcut->count()>0) {
			$shortcut->delete();
		}

		$notebook->delete();

		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $deletedNotebook);
	}
	
	
	private function shareNotebook($notebookId,$toUserId,$toUMASK){
		$notebook=User::find(Auth::user()->id)->notebooks()
						->wherePivot('umask','=',PaperworkHelpers::UMASK_OWNER)
						->where('notebooks.id', '=', $notebookId)
						->whereNull('notebooks.deleted_at')
						->first();
		if(is_null($notebook)){
		    return null;
		}
		$toUser=User::find($toUserId);
		if(is_null($toUser))
		    return null; //user with which we want to share the note doesn't exist
		$toUser=$notebook->users()->where('users.id', '=', $toUserId)->first();
		if (!is_null($toUser)){
		    if($toUser->pivot->umask==PaperworkHelpers::UMASK_OWNER)
			return null;
		    if($toUMASK==0){//set UMASK to 0 to stop sharing
			$notebook->users()->detach($toUserId);
			$notebook->save();
			return $notebook;
		    }
		    if($toUser->pivot->umask!=$toUMASK){
			$notebook->users()->updateExistingPivot($toUserId,array('umask' => $toUMASK));
			$notebook->save();
			return $notebook;
		    }
		}
		if (is_null($toUser)) {
		    $notebook->users()->attach($toUserId, array('umask' => $toUMASK)); //add user
		    // return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array('item'=>'user'));
		    $notebook->save();
		    return $notebook;
		}
	}
	
	public function share($notebookId,$toUserId,$toUMASK){
		$toUserIds = explode(PaperworkHelpers::MULTIPLE_REST_RESOURCE_DELIMITER,
			$toUserId);
		$toUMASKs=explode(PaperworkHelpers::MULTIPLE_REST_RESOURCE_DELIMITER,
			$toUMASK);
		if(count($toUserIds)!=count($toUMASKs))//as much toUsers as toUmasks, if not raise an Error.
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_ERROR, array('error_id' => $noteId));
		$responses = array();
		$status    = PaperworkHelpers::STATUS_SUCCESS;
		for($i=0; $i<count($toUserIds); $i++){//adding a loop to share with multiple users
			$tmp = $this->shareNotebook($notebookId, $toUserIds[$i], $toUMASK[$i]);
			if (is_null($tmp)) {
				$status      = PaperworkHelpers::STATUS_ERROR;
				$responses[] = array('error_id' => $notebookId);
			} else {
				$responses[] = $tmp;
			}
		}
        return PaperworkHelpers::apiResponse($status, $responses);
	}
}

?>
