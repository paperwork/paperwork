<?php

App::setLocale(PaperworkHelpers::getUiLanguageFromSession());

// Route::any('notebook/{num?}', 'ApiNotebooksController@index')->where('num','([0-9]*)');
Route::resource('notebooks', 'Api\V1\ApiNotebooksController');
Route::get('/notebooks/{notebookId}/share/{toUserId}/{toUMASK}', 'Api\V1\ApiNotebooksController@share');
Route::get('/notebooks/{notebookId}/remove-collection', 'Api\V1\ApiNotebooksController@removeNotebookFromCollection');
Route::resource('tags', 'Api\V1\ApiTagsController');
Route::resource('notebooks.notes', 'Api\V1\ApiNotesController');
// I really don't know whether that's a great way to solve this...
Route::get('/notebooks/{notebookId}/notes/{noteId}/move/{toNotebookId}', 'Api\V1\ApiNotesController@move');
Route::get('/notebooks/{notebookId}/notes/{noteId}/tag/{toTagId}', 'Api\V1\ApiNotesController@tagNote');
Route::get('/notebooks/{notebookId}/notes/{noteId}/share/{toUserId}/{toUMASK}', 'Api\V1\ApiNotesController@share');
Route::resource('notebooks.notes.versions', 'Api\V1\ApiVersionsController');
Route::resource('notebooks.notes.versions.attachments', 'Api\V1\ApiAttachmentsController');
Route::get('/notebooks/{notebookId}/notes/{noteId}/versions/{versionId}/attachments/{attachmentId}/raw', 'Api\V1\ApiAttachmentsController@raw');
Route::resource('shortcuts', 'Api\V1\ApiShortcutsController');
Route::get('/tags/{tagId}/{parentTagId}', 'Api\V1\ApiTagsController@nest');
Route::resource('tags', 'Api\V1\ApiTagsController');
Route::resource('i18n', 'Api\V1\ApiI18nController');
Route::get('/users/notebooks/{notebookId}', 'Api\V1\ApiUsersController@showNotebook');
Route::resource('users', 'Api\V1\ApiUsersController');
Route::resource('settings', 'Api\V1\ApiSettingsController');
Route::resource('calendar', 'Api\V1\ApiCalendarController');
Route::post('/notebooks/collections', 'Api\V1\ApiNotebooksController@storeCollection');
Route::post('/notebooks/collections/{collectionId}/edit', 'Api\V1\ApiNotebooksController@updateCollection');

// Special routes
Route::get('/tagged/{num}', 'Api\V1\ApiNotesController@tagged');
Route::get('/search/{query}', 'Api\V1\ApiNotesController@search');

// Route::any('notebooks/(:num?)', array('as' => 'api.v1.notebooks', 'uses' => 'ApiNotebooksController@index'));
// Route::any('notes/(:num?)', array('as' => 'api.v1.notes', 'uses' => 'api.v1.notes@index'));
