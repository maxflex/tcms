<?php
use App\Http\Middleware\LogUrlOpen;

URL::forceSchema('https');

# Login
Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout');


Route::group(['middleware' => ['login', LogUrlOpen::class]], function () {
    # Variables
    Route::get('/', 'VariablesController@index');
    Route::resource('variables', 'VariablesController');

    # Pages
    Route::get('pages/export', 'PagesController@export')->name('pages.export');
    Route::post('pages/import', 'PagesController@import')->name('pages.import');
    Route::resource('pages', 'PagesController');
    Route::get('search', 'PagesController@search');

    Route::resource('logs', 'LogsController');

    Route::resource('programs', 'ProgramsController');

    Route::get('sass/{file}', 'SassController@edit')->where('file', '.*.scss$');
    Route::get('sass/{directory?}', 'SassController@index')->where('directory', '.*');

    Route::resource('photos', 'PhotosController');

    Route::post('uploadPageitem', 'UploadController@pageItem');
    Route::post('upload', 'UploadController@original');
    Route::post('upload/cropped', 'UploadController@cropped');

    Route::resource('faq', 'FaqController');
    Route::resource('masters', 'MastersController');
    Route::resource('equipment', 'EquipmentController');
    Route::resource('tags', 'TagsController');
    Route::resource('users', 'UsersController');
    Route::resource('reviews', 'ReviewsController');

    Route::get('prices/{id}/create', 'PricesController@create');
    Route::resource('prices', 'PricesController');
    Route::get('prices/positions/{id}/edit', 'PricePositionsController@edit');
    Route::resource('prices/{id}/positions', 'PricePositionsController');

    Route::get('gallery/folder/{folder_id}', 'GalleryController@index');
    Route::resource('gallery', 'GalleryController');
});

# Templates for angular directives
Route::get('directives/{directive}', function($directive) {
    return view("directives.{$directive}");
});
