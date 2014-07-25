<?php

class ApiNotebooksController extends BaseController {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	public $restful = true;

	private function getNotebookChildren($notebookId) {
		$children = DB::table('notebooks')
			->select('notebooks.id', 'notebooks.type', 'notebooks.title')
			->where('notebooks.parent_id', '=', $notebookId)
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
			->get();

		foreach($notebooks as $notebook) {
			$notebook->children = $this->getNotebookChildren($notebook->id);
		}

		array_unshift($notebooks, array('id' => '0', 'type' => '2', 'title' => Lang::get('notebooks.all_notes')));
		return Response::json($notebooks);
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
				->first();

			if(is_null($notebook)){
				return Response::json('Notebook not found', 404);
			} else {
				$notebook->children = $this->getNotebookChildren($id);
				return Response::json($notebook);
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
			$notebook->save();

			$notebook->users()->attach(Auth::user()->id);

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
		return Validator::make(Input::all(), [ "title" => "required"]);
	}


	public function update()
	{
		$updateNotebook = Input::json();

		$notebook = Notebook::find($updateNotebook->id);
		if(is_null($notebook)){
			return Response::json('Notebook not found', 404);
		}
		$notebook->title = $updateNotebook->title;
		$notebook->completed = $updateNotebook->completed;
		$notebook->save();
		return Response::json($notebook);
	}

	public function delete($id = null)
	{
		$notebook = Notebook::find($id);

		if(is_null($notebook))
		{
			return Response::json('Notebook not found', 404);
		}
		$deletedNotebook = $notebook;
		$notebook->delete();
		return Response::json($deletedNotebook);
	}
}

?>