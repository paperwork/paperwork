<?php

class ApiNotebooksController extends BaseController {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	public $restful = true;

	private function getNotebookChildren($notebookId) {
		$children = DB::table('notebooks')
			->join('notebook_user', function($join) {
				$join->on('notebooks.id', '=', 'notebook_user.notebook_id')
					->where('notebook_user.user_id', '=', Auth::user()->id);
			})
			->select('notebooks.id', 'notebooks.type', 'notebooks.title')
			->where('notebooks.parent_id', '=', $notebookId)
			->whereNull('notebooks.deleted_at')
			->get();
		return $children;
	}

	public function index()
	{
		$notebooks = DB::table('notebooks')
			->join('notebook_user', function($join) {
				$join->on('notebooks.id', '=', 'notebook_user.notebook_id')
					->where('notebook_user.user_id', '=', Auth::user()->id);
			})
			->select('notebooks.id', 'notebooks.type', 'notebooks.title')
			->where('notebooks.parent_id', '=', null)
			->whereNull('notebooks.deleted_at')
			->get();

		foreach($notebooks as $notebook) {
			$notebook->children = $this->getNotebookChildren($notebook->id);
		}

		array_unshift($notebooks, array('id' => '0', 'type' => '2', 'title' => Lang::get('notebooks.all_notes')));
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $notebooks);
	}

	public function show($id = null)
	{
		if (is_null($id ))
		{
			return index();
		}
		else
		{
			$notebook = DB::table('notebooks')
				->join('notebook_user', function($join) {
					$join->on('notebooks.id', '=', 'notebook_user.notebook_id')
						->where('notebook_user.user_id', '=', Auth::user()->id);
				})
				->select('notebooks.id', 'notebooks.type', 'notebooks.title')
				->where('notebooks.id', '=', $id)
				->whereNull('notebooks.deleted_at')
				->first();

			if(is_null($notebook)){
				return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
			} else {
				$notebook->children = $this->getNotebookChildren($id);
				return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $notebook);
			}
		}
	}


	public function store()
	{
		$validator = $this->getNewNotebookValidator();
		if($validator->passes()) {
			$newNotebook = Input::json();

			$notebook = new Notebook();
			$notebook->title = $newNotebook->get('title');
			$notebook->type = $newNotebook->get('type');
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

			$notebook = User::find(Auth::user()->id)->notebooks()->where('notebooks.id', '=', $notebookId)->whereNull('notebooks.deleted_at')->first();

			if(is_null($notebook)){
				return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
			}
			$notebook->title = $updateNotebook->get('title');
			$notebook->type = $updateNotebook->get('type');
			$notebook->save();

			$shortcut = Shortcut::where('user_id', '=', Auth::user()->id)->where('notebook_id', '=', $notebookId);

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
		$notebook = User::find(Auth::user()->id)->notebooks()->where('notebooks.id', '=', $notebookId)->whereNull('notebooks.deleted_at')->first();

		if(is_null($notebook))
		{
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
		}
		$deletedNotebook = $notebook;

		$shortcut = Shortcut::where('user_id', '=', Auth::user()->id)->where('notebook_id', '=', $notebookId);
		if($shortcut->count()>0) {
			$shortcut->delete();
		}

		$notebook->delete();

		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $deletedNotebook);
	}
}

?>