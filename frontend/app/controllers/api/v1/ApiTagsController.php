<?php

class ApiTagsController extends BaseController {
	public $restful = true;

	public static function createOrGetTags($tagsArray) {
		$tagsPublicPrefixCharacter = Config::get('paperwork.tagsPublicPrefixCharacter')[0];
		$createdOrFoundIds = array();

		if(is_null($tagsArray)) {
			return null;
		}

		foreach($tagsArray as $tagItem) {
			$tagTitle = '';
			$tagVisibility = 0;

			if($tagItem[0] === $tagsPublicPrefixCharacter) {
				$tagTitle = strtolower(substr($tagItem, 1));
				$tagVisibility = 1;
			} else {
				$tagTitle =  strtolower($tagItem);
				$tagVisibility = 0;
			}

			$tag = Tag::where('tags.title', '=', $tagTitle)->where('tags.visibility', '=', $tagVisibility)->first();

				// ->where('tags.title', '=', $tagTitle)
				// ->where('tags.visibility', '=', $tagVisibility)
				// ->select('tags.id')
				// ->first();

			if(is_null($tag)) {
				$newTag = new Tag();
				$newTag->title = $tagTitle;
				$newTag->visibility = $tagVisibility;

				$newTag->save();

				$newTag->users()->attach(Auth::user()->id);

				$createdOrFoundIds[] = $newTag->id;
			} else {
				if(is_null($tag->users()->where('users.id', '=', Auth::user()->id)->first())) {
					$tag->users()->attach(Auth::user()->id);
				}
				$createdOrFoundIds[] = $tag->id;
			}
		}

		return $createdOrFoundIds;
	}

	public function index()
	{
		$tags = DB::table('tags')
			->join('tag_user', function($join) {
				$join->on('tags.id', '=', 'tag_user.tag_id')
					->where('tag_user.user_id', '=', Auth::user()->id);
			})
			->select('tags.id', 'tags.visibility', 'tags.title')
			->get();

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
		$tags = DB::table('tags')
			->join('tag_user', function($join) {
				$join->on('tags.id', '=', 'tag_user.tag_id')
					->where('tag_user.user_id', '=', Auth::user()->id);
			})
			->select('tags.id', 'tags.visibility', 'tags.title')
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
}

?>