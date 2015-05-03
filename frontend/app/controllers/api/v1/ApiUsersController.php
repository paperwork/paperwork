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
		$tmp=User::where('users.id','!=',Auth::user()->id)->orWhereNull('users.id')->get();
		foreach($tmp as $user){
			$notes_u=User::find($user->id)->notes()->whereIn('notes.id',explode(PaperworkHelpers::MULTIPLE_REST_RESOURCE_DELIMITER,$noteId));
			$user->noteCount=count($notes_u->get());
			$user->umask=0;
			if($user->noteCount>0)
				$user->umask=intval($notes_u->first()->pivot->umask);
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