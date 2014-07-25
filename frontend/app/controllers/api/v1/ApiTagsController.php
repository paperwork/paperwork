<?php

class ApiTagsController extends BaseController {
	public $restful = true;

	public function index()
	{
		$tags = DB::table('tags')
			->join('tag_user', function($join) {
				$join->on('tags.id', '=', 'tag_user.tag_id')
					->where('tag_user.user_id', '=', Auth::user()->id);
			})
			->select('tags.id', 'tags.title')
			->get();

		return Response::json($tags);
	}

	public function show($id = null)
	{
		if (is_null($id ))
		{
			return index();
		}
		else
		{
		$tags = DB::table('tags')
			->join('tag_user', function($join) {
				$join->on('tags.id', '=', 'tag_user.tag_id')
					->where('tag_user.user_id', '=', Auth::user()->id);
			})
			->select('tags.id', 'tags.title')
			->where('tags.id', '=', $id)
			->first();

			if(is_null($tags)){
				return Response::json('Tag not found', 404);
			} else {
				return Response::json($tags);
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

		return Response::json($notebook);
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