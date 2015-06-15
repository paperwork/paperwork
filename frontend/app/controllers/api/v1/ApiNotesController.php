<?php

class ApiNotesController extends BaseController
{
    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
    public $restful = true;

    private function getNoteTags($noteId)
    {
        $note = Note::with(array('tags' => function($query){
                                                $query->where('visibility','=',1)
                                                ->orWhere('user_id','=',Auth::user()->id);
                                            }
                                )
                           )
                        ->where('notes.id', '=', $noteId)->first();
        $tags = array();
        foreach ($note->tags as $tag) {
            $tags[] = array(
                'id'         => $tag->id,
                'title'      => $tag->title,
                'visibility' => $tag->visibility
            );
        }
        return $tags;
    }

    private function getNoteVersionsBrief($noteId)
    {
        $note           =
            Note::with('version')->where('notes.id', '=', $noteId)->first();
        $versionsObject = $note->version()->first();
        if (is_null($versionsObject)) {
            return null;
        }

        $versionsArray = [];
        $tmp           = $versionsObject;
        $isLatest      = true;

        $versions = array();
        while (!is_null($tmp)) {
            $versionsArray[] = $tmp;
	    $user=$tmp->user()->first();
            $versions[] = array(
                'id'          => $tmp->id,
                'previous_id' => $tmp->previous_id,
                'next_id'     => $tmp->next_id,
                'latest'      => $isLatest,
                'timestamp'   => $tmp->created_at->getTimestamp(),
		'username'    => $user->firstname.' '.$user->lastname
            );
            $isLatest   = false;
            $tmp        = $tmp->previous()->first();
        }

        return $versions;
    }

    public function index($notebookId)
    {
        // $notes = null;

        // // $notes = DB::table('notes')
        // // 	->join('note_user', function($join) {
        // // 		$join->on('notes.id', '=', 'note_user.note_id')
        // // 			->where('note_user.user_id', '=', Auth::user()->id);
        // // 	})
        // // 	->join('notebooks', function($join) {
        // // 		$join->on('notes.notebook_id', '=', 'notebooks.id');
        // // 	})
        // // 	->join('versions', function($join) {
        // // 		$join->on('notes.version_id', '=', 'versions.id');
        // // 	})
        // // 	->select('notes.uuid AS id', 'notebooks.uuid AS notebook_id', 'notebooks.title as notebook_title', 'versions.title', 'versions.content_preview', 'versions.content', 'notes.created_at', 'notes.updated_at', 'note_user.umask')
        // // 	->whereNull('notes.deleted_at')
        // // 	->whereNull('notebooks.deleted_at');

        // $notebook = Notebook::where('uuid', '=', $notebookId)->get();
        // if(is_null($notebook)) {
        // 	return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
        // }

        // print_r($notebook);
        // exit(–1);

        // $notes = Note::with(
        // 	array(
        // 	'users' => function($query) {
        // 		$query->select('users.uuid AS id');
        // 		$query->where('note_user.user_id', '=', Auth::user()->id);
        // 	},
        // 	// 'notebook' => function($query) use(&$notebookId) {
        // 	// 	$query->select('notebooks.uuid AS notebook_id', 'notebooks.title as notebook_title');
        // 	// 	if($notebookId != PaperworkHelpers::NOTEBOOK_ALL_ID) {
        // 	// 		$query->where('notebooks.uuid', '=', $notebookId);
        // 	// 	}
        // 	// 	$query->whereNull('notebooks.deleted_at');
        // 	// },
        // 	'version' => function($query) {
        // 		$query->select('versions.title', 'versions.content_preview', 'versions.content');
        // 	},
        // 	'tags' => function($query) {

        // 	}
        // 	)
        // )->select('notes.uuid AS id', 'notes.created_at', 'notes.updated_at')
        // ->where('notes.notebook_id', '=', $notebook->id)
        // ->whereNull('deleted_at')->get();

        // if(is_null($notes)){
        // 	return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
        // } else {
        // 	// foreach($notes as $note) {
        // 	// 	$note->tags = $this->getNoteTags($note->id);
        // 	// 	$note->versions = $this->getNoteVersionsBrief($note->id);
        // 	// }
        // 	return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $notes);
        // }
        $notes = PaperworkDb::note()
                            ->get(array('notebookid' => $notebookId))
                            ->toArray();
        return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS,
            $notes);
    }

    public function search($queryBase64Encoded)
    {
        // Warning: For some reason the decoded value contains encoded signs?
        // How to fix?
        $searchQuery = urldecode(base64_decode($queryBase64Encoded));

        $notes = DB::table('notes')
                   ->join('note_user', function ($join) {
                       $join->on('notes.id', '=', 'note_user.note_id')
                            ->where('note_user.user_id', '=', Auth::user()->id);
                   })
                   ->join('notebooks', function ($join) {
                       $join->on('notes.notebook_id', '=', 'notebooks.id');
                   })
                   ->join('versions', function ($join) {
                       $join->on('notes.version_id', '=', 'versions.id');
                   });

        $dateFilter =
            preg_match_all("/\s*date:(?:(\d{4})(?:[-\/.](\d{2}))?(?:[\/.-](\d{2}))?)/",
                $searchQuery, $matches, PREG_SET_ORDER);

        if ($dateFilter !== false && $dateFilter > 0) {
            // Only use last date
            $date = end($matches);

            if ($date !== false) {

                $notes = $notes->where(DB::raw('YEAR(notes.updated_at)'), '=',
                    $date[1]);

                if (isset($date[2])) {
                    $notes =
                        $notes->where(DB::raw('MONTH(notes.updated_at)'), '=',
                            sprintf("%02s", $date[2]));
                }

                if (isset($date[3])) {
                    $notes =
                        $notes->where(DB::raw('DAY(notes.updated_at)'), '=',
                            sprintf("%02s", $date[3]));
                }
            }

            $searchQuery =
                PaperworkHelpers::cleanupMatches($searchQuery, $matches);
        }

        $filters =
            preg_match_all("/\s*(tagid|note(?:book)?id)\:([a-f\d]{8}(-[a-f\d]{4}){3}-[a-f\d]{12}?)/",
                $searchQuery, $matches, PREG_SET_ORDER);
        if ($filters !== false && $filters > 0) {
            foreach ($matches as $match) {
                switch ($match[1]) {
                    case "tagid" :
                        $notes = $notes->join('tag_note', function ($join) {
                            $join->on('notes.id', '=', 'tag_note.note_id');
                        })
                                       ->where('tag_note.tag_id', '=',
                                           $match[2]);

                        break;
                    case "noteid" :
                        $notes = $notes->where('notes.id', '=', $match[2]);

                        break;
                    case "notebookid" :
                        if ($match[2] !=
                            ApiNotebooksController::NOTEBOOK_ALL_ID
                        ) {
                            $notes = $notes->where('notes.notebook_id', '=',
                                $match[2]);
                        }

                        break;
                }
            }

            $searchQuery =
                PaperworkHelpers::cleanupMatches($searchQuery, $matches);
        }

        $notes = $notes->whereNull('notes.deleted_at')
                       ->whereNull('notebooks.deleted_at')
                       ->where(function ($query) use (&$searchQuery) {
                           $query->orWhere('versions.title', 'LIKE',
                               '%' . $searchQuery . '%')
                                 ->orWhere('versions.content', 'LIKE',
                                     '%' . $searchQuery . '%')
                                 ->orWhere('versions.content_preview', 'LIKE',
                                     '%' . $searchQuery . '%');
                           // ->orWhere('attachment.content', 'LIKE', '%' . $searchQuery . '%')
                       })
                       ->select(
                           'notes.id',
                           'notes.notebook_id',
                           'notebooks.title as notebook_title',
                           'versions.title',
                           'versions.content_preview',
                           'versions.content',
                           'notes.created_at',
                           'notes.updated_at',
                           'note_user.umask'
                       )->distinct()
            //->toSql();
                       ->get();

        if (is_null($notes)) {
            return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND,
                array());
        } else {
            foreach ($notes as $note) {
                $note->tags     = $this->getNoteTags($note->id);
                $note->versions = $this->getNoteVersionsBrief($note->id);
            }
            return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS,
                $notes);
        }
    }

    public function show($notebookId, $id = null)
    {
        // if (is_null($id ))
        // {
        // 	return index($notebookId);
        // }
        // else
        // {
        // 	$note = null;

        // 	// $note = DB::table('notes')
        // 	// 	->join('note_user', function($join) {
        // 	// 		$join->on('notes.id', '=', 'note_user.note_id')
        // 	// 			->where('note_user.user_id', '=', Auth::user()->id);
        // 	// 	})
        // 	// 	->join('notebooks', function($join) {
        // 	// 		$join->on('notes.notebook_id', '=', 'notebooks.id');
        // 	// 	})
        // 	// 	->join('versions', function($join) {
        // 	// 		$join->on('notes.version_id', '=', 'versions.id');
        // 	// 	})
        // 	// 	->select('notes.id', 'notes.notebook_id', 'notebooks.title as notebook_title', 'versions.title', 'versions.content_preview', 'versions.content', 'notes.created_at', 'notes.updated_at', 'note_user.umask')
        // 	// 	->where('notes.notebook_id', ($notebookId>0 ? '=' : '>'), ($notebookId>0 ? $notebookId : '0'))
        // 	// 	->where('notes.id', '=', $id)
        // 	// 	->whereNull('notes.deleted_at')
        // 	// 	->first();

        // 	$note = Note::with(
        // 		array(
        // 		'users' => function($query) {
        // 			$query->where('note_user.user_id', '=', Auth::user()->id);
        // 		},
        // 		'notebook' => function($query) use(&$notebookId) {
        // 			$query->where('uuid', '=', $notebookId);
        // 			$query->whereNull('notebooks.deleted_at');
        // 		},
        // 		'version' => function($query) {

        // 		},
        // 		'tags' => function($query) {

        // 		}
        // 		)
        // 	)->where('notes.uuid', '=', $id)->whereNull('deleted_at')->get();

        // 	if(is_null($note)){
        // 		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
        // 	} else {
        // 		// $note->tags = $this->getNoteTags($id);
        // 		// $note->versions = $this->getNoteVersionsBrief($id);
        // 		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $note);
        // 	}
        // }

        $notes = PaperworkDb::note()
                            ->get(array(
                                'id' => explode(PaperworkHelpers::MULTIPLE_REST_RESOURCE_DELIMITER,
                                    $id)
                            ));
        // print_r($notes[0]->version()->title);
        if (empty($notes)) {
            return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND,
                array());
        }

        $note = $notes->first();
        $note->versions = $this->getNoteVersionsBrief($note->id);
        return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $note);

    }

    public function store($notebookId)
    {
        $newNote = Input::json();

        $note = new Note();

        $notebook = User::find(Auth::user()->id)->notebooks()
                      ->select('notebooks.id', 'notebooks.type',
                          'notebooks.title')
                      ->where('notebooks.id', '=', $notebookId)
                      ->wherePivot('umask','>',PaperworkHelpers::UMASK_READONLY)
                      ->whereNull('notebooks.deleted_at')
                      ->first();

        if (is_null($notebook)) {
            return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND,
                []);
        }

        $version = new Version([
            'title'           => $newNote->get("title"),
            'content'         => $newNote->get("content"),
            'content_preview' => $newNote->get("content_preview"),
	    'user_id' => Auth::user()->id
        ]);

        $version->save();
        $note->version()->associate($version);
        $note->notebook_id = $notebookId;
        $version->save();

        $note->save();

        // TODO: Should we inherit the umask from the notebook?
        $note->users()
             ->attach(Auth::user()->id,
                 array('umask' => PaperworkHelpers::UMASK_OWNER));

        $tagIds = ApiTagsController::createOrGetTags($newNote->get('tags'),$note->id,PaperworkHelpers::UMASK_OWNER);

        if (!is_null($tagIds)) {
            $note->tags()->sync($tagIds);
        }

        return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS,
            $note);
    }

    public function update($notebookId, $noteId)
    {
        $validator = Validator::make(Input::all(), ["title" => "required"]);
        if (!$validator->passes()) {
            return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_ERROR,
                $validator->getMessageBag()->toArray());
        }

        $updateNote = Input::json();

       $user=User::find(Auth::user()->id);
        if (is_null($user)) {
            return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND,
                array('item' => 'user'));
        }
        //only a read-writer or owner of the note can update it. however the private tags can be saved whatever the status
        $note = $user->notes()
                    ->where('notes.id','=',$noteId)
                    ->first();

        if (is_null($note)) {
            return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND,
                array('item' => 'note', 'id' => $noteId));
        }
                    
                    
       $tagIds = ApiTagsController::createOrGetTags($updateNote->get('tags'),$noteId,$note->pivot->umask);

        if (!is_null($tagIds)) {
            $note->tags()->sync($tagIds);
        }
        
        if($note->pivot->umask<PaperworkHelpers::UMASK_READWRITE){
            return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_ERROR, array('message' => 'Permission error. The private tags have been saved though.'));
        }

        $previousVersion     = $note->version()->first();
        $previousAttachments = $previousVersion->attachments()->get();

        if ($previousVersion->title != $updateNote->get("title") ||
            $previousVersion->content != $updateNote->get("content")
        ) {

            $pureContent =
                PaperworkHelpers::purgeHtml($updateNote->get("content"));

            // TODO: This is a temporary workaround for the content_preview. We need to check, whether there is content or at least one attachment.
            // If there's no content, parse the attachment and set the result as content_preview. This should somehow be done within the DocumentParser, I guess.
            $version = new Version(array(
                'title'           => $updateNote->get("title"),
                'content'         => $pureContent,
                'content_preview' => substr(strip_tags($pureContent), 0, 255),
		'user_id' => $user->id
            ));

            $version->save();

            $previousVersion->next()->associate($version);
            $previousVersion->save();

            $version->previous()->associate($previousVersion);

            if (!is_null($previousAttachments) &&
                $previousAttachments->count() > 0
            ) {
                foreach ($previousAttachments as $previousAttachment) {
                    $version->attachments()->attach($previousAttachment);
                }
            }

            $version->save();

            $note->version_id = $version->id;

            $note->save();

        }

        return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS,
            $note);
    }

    private function destroyNote($notebookId, $noteId)
    {
        //only owner of the note can destroy it
        $note = User::find(Auth::user()->id)
                    ->notes()
                    ->wherePivot('umask','=',PaperworkHelpers::UMASK_OWNER)
                    ->where('notes.id', '=', $noteId)
                    ->whereNull('notes.deleted_at')
                    ->first();

        if (is_null($note)) {
            // return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array('item'=>'note', 'id'=>$noteId));
            return null;
        }

        $deletedNote = $note;
        $note->delete();
        // return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $deletedNote);
        return $deletedNote;
    }

    public function destroy($notebookId, $noteId)
    {
        $noteIds   =
            explode(PaperworkHelpers::MULTIPLE_REST_RESOURCE_DELIMITER,
                $noteId);
        $responses = array();
        $status    = PaperworkHelpers::STATUS_SUCCESS;

        foreach ($noteIds as $singleNoteId) {
            $tmp = $this->destroyNote($notebookId, $singleNoteId);
            if (is_null($tmp)) {
                $status      = PaperworkHelpers::STATUS_ERROR;
                $responses[] = array('error_id' => $singleNoteId);
            } else {
                $responses[] = $tmp;
            }
        }
        return PaperworkHelpers::apiResponse($status, $responses);
    }

    private function moveNote($notebookId, $noteId, $toNotebookId)
    {
        $user = User::find(Auth::user()->id);
        if (is_null($user)) {
            // return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array('item'=>'user'));
            return null;
        }
        //the user shall be owner of the note
        $note = $user->notes()
                    ->wherePivot('umask','=',PaperworkHelpers::UMASK_OWNER)
                    ->where('notes.id','=',$noteId)
                    ->whereNull('notes.deleted_at')
                    ->first();
        if (is_null($note)) {
            // return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array('item'=>'note', 'id'=>$noteId));
            return null;
        }

        //the user shall have the right to write into the destination notebook
        $toNotebook = $user->notebooks()
                        ->wherePivot('umask','>',PaperworkHelpers::UMASK_READONLY)
                        ->where('notebooks.id','=',$toNotebookId)
                        ->whereNull('notebooks.deleted_at')
                        ->first();
        if (is_null($toNotebook)) {
            // return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array('item'=>'notebook', 'id'=>$toNotebookId));
            return null;
        }
    
        $note->notebook()->associate($toNotebook);
        $note->save();

        return $note;
    }

    public function move($notebookId, $noteId, $toNotebookId)
    {
        $noteIds   =
            explode(PaperworkHelpers::MULTIPLE_REST_RESOURCE_DELIMITER,
                $noteId);
        $responses = array();
        $status    = PaperworkHelpers::STATUS_SUCCESS;

        foreach ($noteIds as $singleNoteId) {
            $tmp = $this->moveNote($notebookId, $singleNoteId, $toNotebookId);
            if (is_null($tmp)) {
                $status      = PaperworkHelpers::STATUS_ERROR;
                $responses[] = array('error_id' => $singleNoteId);
            } else {
                $responses[] = $tmp;
            }
        }
        return PaperworkHelpers::apiResponse($status, $responses);
    }

    public function tagNote($notebookId, $noteId, $toTagId)
    {
        Note::find($noteId)->tags()->attach($toTagId);
        return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS,
            $noteId);
    }
    private function shareNote($notebookId, $noteId, $toUserId, $toUMASK){
        //only owner of the note can share it
        $note=User::find(Auth::user()->id)->notes()
                        ->wherePivot('umask','=',PaperworkHelpers::UMASK_OWNER)
                        ->where('notes.id','=',$noteId)
                        ->whereNull('notes.deleted_at')
                        ->first();
        if(is_null($note)){
            return null;
        }
        $toUser=User::find($toUserId);
        if(is_null($toUser))
            return null; //user with whom we want to share the note doesn't exist
        $toUser=$note->users()->where('users.id', '=', $toUserId)->first();
        if (!is_null($toUser)){
            if($toUser->pivot->umask==PaperworkHelpers::UMASK_OWNER)
                return null;
            if($toUMASK==0){//set UMASK to 0 to stop sharing
                $note->users()->detach($toUserId);
                $note->save();
                return $note;
            }
            if($toUser->pivot->umask!=$toUMASK){
                $note->users()->updateExistingPivot($toUserId,array('umask' => $toUMASK));
                $note->save();
                return $note;
            }
            return $note;
        }
        if (is_null($toUser)) {
            $note->users()->attach($toUserId, array('umask' => $toUMASK)); //add user
            // return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array('item'=>'user'));
            $note->save();
            return $note;
        }
        
    }
    public function share($notebookId, $noteId, $toUserId, $toUMASK){
        $noteIds   =
            explode(PaperworkHelpers::MULTIPLE_REST_RESOURCE_DELIMITER,
                $noteId);
        $toUserIds = explode(PaperworkHelpers::MULTIPLE_REST_RESOURCE_DELIMITER,
                $toUserId);
        $toUMASKs=explode(PaperworkHelpers::MULTIPLE_REST_RESOURCE_DELIMITER,
                $toUMASK);
        if(count($toUserIds)!=count($toUMASKs))//as much toUsers as toUmasks, if not raise an Error.
            return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_ERROR, array('error_id' => $noteId));
        $responses = array();
        $status    = PaperworkHelpers::STATUS_SUCCESS;
        foreach ($noteIds as $singleNoteId) {
            for($i=0; $i<count($toUserIds); $i++){//adding a loop to share with multiple users
                $tmp = $this->shareNote($notebookId, $singleNoteId, $toUserIds[$i], $toUMASK[$i]);
                if (is_null($tmp)) {
                    $status      = PaperworkHelpers::STATUS_ERROR;
                    $responses[] = array('error_id' => $singleNoteId, 'error_user' => $toUserIds[$i]);
                } else {
                    $responses[] = $tmp;
                }
            }
        }
        return PaperworkHelpers::apiResponse($status, $responses);        
    }
}

?>
