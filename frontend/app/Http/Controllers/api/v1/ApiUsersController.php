<?php

class ApiUsersController extends BaseController {
	public $restful = true;

	public function index()
	{
		$tmp=User::where('users.id','!=',Auth::user()->id)->orWhereNull('users.id')->get();
		$users=$tmp;
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $users);
	}

	public function show($noteId)
	{
		$current_userId=Auth::user()->id;
		$tmp=User::get();
		foreach($tmp as $user){
			$notes_u=User::find($user->id)->notes()->whereIn('notes.id',explode(PaperworkHelpers::MULTIPLE_REST_RESOURCE_DELIMITER,$noteId));
			$gotten_notes_u=$notes_u->get()->toArray();
			$user->noteCount=count($gotten_notes_u);
			$user->umask=0;
			$user->owner=false;
			$user->is_current_user=($user->id==$current_userId);
			if($user->noteCount>0){
				$user->owner=(count($notes_u->where('note_user.umask','=',PaperworkHelpers::UMASK_OWNER)->get())>0);
				$user->umask=min(intval($gotten_notes_u[0]['pivot']['umask']),PaperworkHelpers::UMASK_READWRITE);
			}
		}
		$users=$tmp;
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $users);
		//return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, array());
	}
	
	public function showNotebook($notebookId)
	{
		$current_userId=Auth::user()->id;
		$tmp=User::get();
		foreach($tmp as $user){
			$notebooks_u=User::find($user->id)->notebooks()->whereIn('notebooks.id',explode(PaperworkHelpers::MULTIPLE_REST_RESOURCE_DELIMITER,$notebookId));
			$gotten_notebooks_u=$notebooks_u->get()->toArray();
			$user->notebookCount=count($gotten_notebooks_u);
			$user->umask=0;
			$user->owner=false;
			$user->is_current_user=($user->id==$current_userId);
			if($user->notebookCount>0){
				$user->owner=(count($notebooks_u->where('notebook_user.umask','=',PaperworkHelpers::UMASK_OWNER)->get())>0);
				$user->umask=min(intval($gotten_notebooks_u[0]['pivot']['umask']),PaperworkHelpers::UMASK_READWRITE);
			}
		}
		$users=$tmp;
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $users);
		//return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, array());
	}

	public function store()
	{
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, array());
	}

	public function delete()
	{
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, array());
	}
}

?>