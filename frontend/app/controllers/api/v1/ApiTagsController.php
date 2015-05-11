<?php

class ApiTagsController extends BaseController {
	public $restful = true;

	public static function createOrGetTags($tagsArray, $noteId, $noteUmask) {
		$tagsPublicPrefixCharacter = Config::get('paperwork.tagsPublicPrefixCharacter')[0];
		$createdOrFoundIds = array();

		if(is_null($tagsArray)) {
			return null;
		}

		$userId=Auth::user()->id;
		foreach($tagsArray as $tagItem) {
			$tagTitle = '';
			$tagVisibility = 0;

			if($tagItem[0] === $tagsPublicPrefixCharacter) {
				$tagTitle = strtolower(substr($tagItem, 1));
				$tagVisibility = 1;
				$tag = Tag::where('tags.title', '=', $tagTitle)->where('tags.visibility', '=', $tagVisibility)->first();
			} else {
				$tagTitle =  strtolower($tagItem);
				$tagVisibility = 0;
				$tag = Tag::where('tags.title', '=', $tagTitle)->where('tags.visibility', '=', $tagVisibility)->where('tags.user_id','=',$userId)->first();
			}
			
				// ->where('tags.title', '=', $tagTitle)
				// ->where('tags.visibility', '=', $tagVisibility)
				// ->select('tags.id')
				// ->first();

			if(is_null($tag) && ($tagVisibility == 0 || ($tagVisibility==1 && $noteUmask > PaperworkHelpers::UMASK_READONLY))) {
				$newTag = new Tag();
				$newTag->title = $tagTitle;
				$newTag->visibility = $tagVisibility;
				$newTag->user_id=$userId;
				$newTag->save();

				//$newTag->users()->attach(Auth::user()->id);

				$createdOrFoundIds[] = $newTag->id;
			} else {
				if($tagVisibility==0 || ($tagVisibility==1 && $noteUmask > PaperworkHelpers::UMASK_READONLY)){
					/*if(is_null($tag->users()->where('users.id', '=', Auth::user()->id)->first())) {
						$tag->users()->attach(Auth::user()->id);
					}*/
				$createdOrFoundIds[] = $tag->id;
				}
			}
		}
		//we need to add the other user's private tags to the list.
		$addtags=Note::find($noteId)->tags()->where('tags.visibility','=',0)->where('tags.user_id','!=',$userId)->get();
		foreach($addtags as $addtag){
			$createdOrFoundIds[]=$addtag->id;
		}
		//if the user is not writer, he cannot change public tags.
		if($noteUmask < PaperworkHelpers::UMASK_READWRITE){
			$addpubtags=Note::find($noteId)->tags()->where('tags.visibility','=',1)->get();
			foreach($addpubtags as $addtag){
				$createdOrFoundIds[]=$addtag->id;
			}
		}
		return $createdOrFoundIds;
	}

	public function index()
	{
		$tags = User::find(Auth::user()->id)->tags()->get();
		$tags = Tag::where('user_id','=',Auth::user()->id)
				->orWhereHas('notes', function($query) {
					$query-> whereHas('users', function($query){
						$query->where('note_user.user_id','=',Auth::user()->id);
						}
						);
					}
				      )
			->where('visibility','=',1)->get();
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $tags);
	}

	public function show($id = null)
	{
		if (is_null($id ))
		{
			return index();
		}
		else
		{
		$tags = User::find(Auth::user()->id)->tags()
			->where('tags.id', '=', $id)
			->first();

			if(is_null($tags)){
				return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
			} else {
				return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $tags);
			}
		}
	}

	public function store()
	{
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $notebook);
	}

	public function delete($id = null)
	{
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $notebook);
	}

    protected function getSaveTagValidator() {
        return Validator::make(Input::all(), [ "title" => "required|unique:tags"]);
    }

    public function update($tagId)
    {
        $validator = $this->getSaveTagValidator();
        if($validator->passes()) {

            $updateTag = Input::json();

            $tag = Tag::find($tagId);

            if(is_null($tag) || $tag->user_id !=  Auth::user()->id) {
                return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
            }

            $tag->title = $updateTag->get('title');
            $tag->save();

            return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $tagId);
        }
        else {
            return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_ERROR, $validator->getMessageBag()->toArray());
        }
    }

    public function destroy($tagId)
    {
        $tag = Tag::find($tagId);

        if(is_null($tag) || $tag->user_id != Auth::user()->id) {
            return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
        }

        $tag->delete();

        return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $tagId);
    }
}

?>
