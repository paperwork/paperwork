<?php

class ApiNotebooksController extends BaseController {
	use SoftDeletingTrait;

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

			$notebook = User::find(Auth::user()->id)->notebooks()->where('notebooks.uuid', '=', $notebookId)->whereNull('notebooks.deleted_at')->first();

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
		$notebook = User::find(Auth::user()->id)->notebooks()->where('notebooks.uuid', '=', $notebookId)->whereNull('notebooks.deleted_at')->first();

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
}

?>