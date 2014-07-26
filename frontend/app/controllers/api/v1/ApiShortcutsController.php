<?php


class ApiShortcutsController extends BaseController {
	public $restful = true;

	public function index()
	{
		$shortcuts = DB::table('notebooks')
			->join('shortcuts', function($join) {
				$join->on('notebooks.id', '=', 'shortcuts.notebook_id')
					->where('shortcuts.user_id', '=', Auth::user()->id);
			})
			->select('notebooks.id', 'notebooks.parent_id', 'notebooks.type', 'notebooks.title', 'shortcuts.id as shortcut_id', 'shortcuts.sortkey')
			->get();

		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $shortcuts);
	}

	public function show($id = null)
	{
		if (is_null($id ))
		{
			return index();
		}
		else
		{
			$shortcuts = DB::table('notebooks')
				->join('shortcuts', function($join) {
					$join->on('notebooks.id', '=', 'shortcuts.notebook_id')
						->where('shortcuts.user_id', '=', Auth::user()->id);
				})
				->select('notebooks.id', 'notebooks.parent_id', 'notebooks.type', 'notebooks.title', 'shortcuts.id', 'shortcuts.sortkey')
				->where('notebooks.id', '=', $id)
				->first();

			if(is_null($shortcuts)){
				return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
			} else {
				return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $shortcuts);
			}
		}
	}


	public function create()
	{
		$newNotebook = Input::json();

		$notebook = new Notebook();
		$notebook->title = $newNotebook->title;
		$notebook->completed = $newNotebook->completed;
		$notebook->save();

		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $notebook);
	}

	public function store()
	{
		$updateNotebook = Input::json();

		$notebook = Notebook::find($updateNotebook->id);
		if(is_null($notebook)){
			return Response::json('Notebook not found', 404);
		}
		$notebook->title = $updateNotebook->title;
		$notebook->completed = $updateNotebook->completed;
		$notebook->save();
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $notebook);
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
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $deletedNotebook);
	}
}

?>