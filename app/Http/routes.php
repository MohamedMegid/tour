<?php
use App\Language;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

#setting of language
$currentLocale = Language::where('main', '=', '1')->first()->code;
$listCodes = Language::lists('code');
$defaultLocale = $currentLocale;
$localeCode = Request::segment(1);
	if($listCodes->contains($localeCode)) {
	      App::setLocale($localeCode);
	}
   else {
        App::setLocale($defaultLocale);
    }

$locale = App::getLocale();
#end setting of language

Route::group(['middleware' => ['web']], function () use($locale) {
	#frontend multi langual
	Route::group([
			'prefix' => $locale,
			'middleware' => 'App\Http\Middleware\AdminMiddleware'
			],function() use($locale)
	{
		App::setLocale($locale);
		//Route::get('/', 'Auth\AuthController@getadmin');
		Route::get('/', function()
		{
			return redirect('/admin');
		});

	});


	#Admin Routes
	Route::group([
				'prefix' => $locale,
		      	'middleware' => 'App\Http\Middleware\AdminMiddleware'
			],function()
	{	
		#System Home
		Route::get('/admin', 'DashboardController@index');
		Route::get('/dashboard', 'DashboardController@index');

		
		#Contact Us
		Route::get('admin/contacts', 'ContactsController@index');
		Route::get('admin/contacts/replied', 'ContactsController@index_replied');
		Route::get('admin/contacts/{id}', 'ContactsController@show');
		Route::get('admin/contacts/{id}/reply', 'ContactsController@reply');
		Route::post('admin/contacts/{id}', 'ContactsController@store_reply');
		Route::post('admin/destroy-contacts', 'ContactsController@destroy');
		Route::post('admin/contacts-bulk', 'ContactsController@bulk_destroy_confirm');
		Route::post('admin/contacts-bulk-destroy', 'ContactsController@bulk_destroy');
		Route::get('admin/contacts/single/{status}/contact/{id}', 'ContactsController@single_status');
		Route::post('admin/contacts/bulk/{status}', 'ContactsController@bulk_status');
		Route::get('admin/contacts-info', 'ContactsController@edit_contact_info');
		Route::post('admin/contacts-info', 'ContactsController@update_contact_info');
		Route::get('admin/contacts-gmap', 'ContactsController@edit');
		Route::post('admin/contacts-gmap', 'ContactsController@update');

		#Complains Sections
		Route::get('admin/complains-sections', 'ComplainSections@index');
		Route::post('admin/destroy-complains-sections', 'ComplainSections@destroy');
		Route::post('admin/complains-sections-bulk', 'ComplainSections@bulk_destroy_confirm');
		Route::post('admin/complains-sections-bulk-destroy', 'ComplainSections@bulk_destroy');
		Route::get('admin/complains-sections/{id}/edit', 'ComplainSections@edit');
		Route::patch('admin/complains-sections/{id}', 'ComplainSections@update');
		Route::get('admin/complains-sections/create', 'ComplainSections@create');
		Route::post('admin/complains-sections', 'ComplainSections@store');
		
		#Complains
		Route::get('admin/complains', 'ComplainController@index');
		Route::get('admin/complains/replied', 'ComplainController@index_replied');
		Route::get('admin/complains/{id}', 'ComplainController@show');
		Route::get('admin/complains/{id}/reply', 'ComplainController@reply');
		Route::post('admin/complains/{id}', 'ComplainController@store_reply');
		Route::post('admin/destroy-complains', 'ComplainController@destroy');
		Route::post('admin/complains-bulk', 'ComplainController@bulk_destroy_confirm');
		Route::post('admin/complains-bulk-destroy', 'ComplainController@bulk_destroy');
		Route::get('admin/complains/single/{status}/contact/{id}', 'ComplainController@single_status');
		Route::post('admin/complains/bulk/{status}', 'ComplainController@bulk_status');
			
	    # Settings
		Route::get('admin/settings/email', 'SettingsController@edit_mail');
		Route::PATCH('admin/settings/email', 'SettingsController@update_mail');
		Route::get('admin/settings/social-media', 'SettingsController@edit_social_media');
		Route::PATCH('admin/settings/social-media', 'SettingsController@update_social_media');
		Route::get('admin/settings/app-links', 'SettingsController@edit_app_links');
		Route::PATCH('admin/settings/app-links', 'SettingsController@update_app_links');

		# Sections
		Route::get('admin/sections/{type}', 'SectionsController@index');
		Route::get('admin/sections/{type}/create', 'SectionsController@create');
		Route::post('admin/sections/{type}', 'SectionsController@store');
		Route::get('admin/sections/{type}/{id}/edit', 'SectionsController@edit');
		Route::patch('admin/sections/{type}/{id}', 'SectionsController@update');
		Route::post('admin/sections', 'SectionsController@destroy');
		Route::post('admin/sections-bulk', 'SectionsController@bulk_destroy_confirm');
		Route::post('admin/sections-bulk-destroy', 'SectionsController@bulk_destroy');
		Route::get('admin/sections/{type}/single/{status}/section/{id}', 'SectionsController@single_status');
		Route::post('admin/sections/{type}/bulk/{status}', 'SectionsController@bulk_status');

		# Sites
		Route::get('admin/sites/{type}', 'SitesController@index');
		Route::get('admin/sites/{type}/create', 'SitesController@create');
		Route::post('admin/sites/{type}', 'SitesController@store');
		Route::get('admin/sites/{type}/{id}/edit', 'SitesController@edit');
		Route::patch('admin/sites/{type}/{id}', 'SitesController@update');
		Route::post('admin/sites', 'SitesController@destroy');
		Route::post('admin/sites-bulk', 'SitesController@bulk_destroy_confirm');
		Route::post('admin/sites-bulk-destroy', 'SitesController@bulk_destroy');
		Route::get('admin/sites/{type}/single/{status}/site/{id}', 'SitesController@single_status');
		Route::post('admin/sites/{type}/bulk/{status}', 'SitesController@bulk_status');

		#News
		Route::get('admin/news', 'NewsController@index');
		Route::get('admin/news/create', 'NewsController@create');
		Route::post('admin/news', 'NewsController@store');
		Route::get('admin/news/{id}/edit', 'NewsController@edit');
		Route::patch('admin/news/{id}', 'NewsController@update');
		Route::post('admin/destroy-news', 'NewsController@destroy');
		Route::post('admin/news-bulk', 'NewsController@bulk_destroy_confirm');
		Route::post('admin/news-bulk-destroy', 'NewsController@bulk_destroy');
		Route::get('admin/news/single/{status}/news/{id}', 'NewsController@single_status');
		Route::post('admin/news/bulk/{status}', 'NewsController@bulk_status');

		#Events
		Route::get('admin/events', 'EventsController@index');
		Route::get('admin/events/create', 'EventsController@create');
		Route::post('admin/events', 'EventsController@store');
		Route::get('admin/events/{id}/edit', 'EventsController@edit');
		Route::post('admin/events/{id}/edit', 'EventsController@update');
		Route::post('admin/destroy-events', 'EventsController@destroy');
		Route::post('admin/events-bulk', 'EventsController@bulk_destroy_confirm');
		Route::post('admin/events-bulk-destroy', 'EventsController@bulk_destroy');
		Route::get('admin/events/single/{status}/events/{id}', 'EventsController@single_status');
		Route::post('admin/events/bulk/{status}', 'EventsController@bulk_status');

		#cities
		Route::get('admin/city', 'CityController@index');
		Route::get('admin/city/create', 'CityController@create');
		Route::post('admin/city', 'CityController@store');
		Route::get('admin/city/{id}/edit', 'CityController@edit');
		Route::patch('admin/city/{id}', 'CityController@update');
		Route::post('admin/destroy-city', 'CityController@destroy');
		Route::post('admin/city-bulk', 'CityController@bulk_destroy_confirm');
		Route::post('admin/city-bulk-destroy', 'CityController@bulk_destroy');
		Route::get('admin/city/single/{status}/city/{id}', 'CityController@single_status');
		Route::post('admin/city/bulk/{status}', 'CityController@bulk_status');

		#area
		Route::get('admin/area', 'AreaController@index');
		Route::get('admin/area/create', 'AreaController@create');
		Route::post('admin/area', 'AreaController@store');
		Route::get('admin/area/{id}/edit', 'AreaController@edit');
		Route::patch('admin/area/{id}', 'AreaController@update');
		Route::post('admin/destroy-area', 'AreaController@destroy');
		Route::post('admin/area-bulk', 'AreaController@bulk_destroy_confirm');
		Route::post('admin/area-bulk-destroy', 'AreaController@bulk_destroy');
		Route::get('admin/area/single/{status}/area/{id}', 'AreaController@single_status');
		Route::post('admin/area/bulk/{status}', 'AreaController@bulk_status');


		#Banners
		Route::get('admin/banners', 'BannersController@index');
		Route::get('admin/banners/create', 'BannersController@create');
		Route::post('admin/banners', 'BannersController@store');
		Route::get('admin/banners/{id}/edit', 'BannersController@edit');
		Route::patch('admin/banners/{id}', 'BannersController@update');
		Route::post('admin/destroy-banners', 'BannersController@destroy');
		Route::post('admin/banners-bulk', 'BannersController@bulk_destroy_confirm');
		Route::post('admin/banners-bulk-destroy', 'BannersController@bulk_destroy');
		Route::get('admin/banners/single/{status}/videos/{id}', 'BannersController@single_status');
		Route::post('admin/banners/bulk/{status}', 'BannersController@bulk_status');

		//Photo gallery
		Route::get('admin/palbum', 'PhotoAlbumController@index');
		Route::get('admin/palbum/create', 'PhotoAlbumController@create');
		Route::post('admin/palbum', 'PhotoAlbumController@store');
		Route::get('admin/palbum/{id}/edit', 'PhotoAlbumController@edit');
		Route::patch('admin/palbum/{id}', 'PhotoAlbumController@update');
		Route::post('admin/destroy-palbum', 'PhotoAlbumController@destroy');
		Route::post('admin/palbum-bulk', 'PhotoAlbumController@bulk_destroy_confirm');
		Route::post('admin/palbum-bulk-destroy', 'PhotoAlbumController@bulk_destroy');
		
		#Videos
		Route::get('admin/videos', 'VideoAlbumController@index');
		Route::get('admin/videos/create', 'VideoAlbumController@create');
		Route::post('admin/videos', 'VideoAlbumController@store');
		Route::get('admin/videos/{id}/edit', 'VideoAlbumController@edit');
		Route::patch('admin/videos/{id}', 'VideoAlbumController@update');
		Route::post('admin/destroy-videos', 'VideoAlbumController@destroy');
		Route::post('admin/videos-bulk', 'VideoAlbumController@bulk_destroy_confirm');
		Route::post('admin/videos-bulk-destroy', 'VideoAlbumController@bulk_destroy');
		Route::get('admin/videos/single/{status}/videos/{id}', 'VideoAlbumController@single_status');
		Route::post('admin/videos/bulk/{status}', 'VideoAlbumController@bulk_status');

		#Pages
		Route::get('admin/pages', 'PagesController@index');
		Route::get('admin/pages/create', 'PagesController@create');
		Route::post('admin/pages', 'PagesController@store');
		Route::get('admin/pages/{id}/edit', 'PagesController@edit');
		Route::patch('admin/pages/{id}', 'PagesController@update');
		Route::post('admin/destroy-pages', 'PagesController@destroy');
		Route::post('admin/pages-bulk', 'PagesController@bulk_destroy_confirm');
		Route::post('admin/pages-bulk-destroy', 'PagesController@bulk_destroy');
		Route::get('admin/pages/single/{status}/pages/{id}', 'PagesController@single_status');
		Route::post('admin/pages/bulk/{status}', 'PagesController@bulk_status');

		#Important links
		Route::get('admin/implinks', 'ImpLinksController@index');
		Route::get('admin/implinks/create', 'ImpLinksController@create');
		Route::post('admin/implinks', 'ImpLinksController@store');
		Route::get('admin/implinks/{id}/edit', 'ImpLinksController@edit');
		Route::patch('admin/implinks/{id}', 'ImpLinksController@update');
		Route::post('admin/destroy-implinks', 'ImpLinksController@destroy');
		Route::post('admin/implinks-bulk', 'ImpLinksController@bulk_destroy_confirm');
		Route::post('admin/implinks-bulk-destroy', 'ImpLinksController@bulk_destroy');
		Route::get('admin/implinks/single/{status}/links/{id}', 'ImpLinksController@single_status');
		Route::post('admin/implinks/bulk/{status}', 'ImpLinksController@bulk_status');
		
		//Reviews canceled
		// Route::get('admin/reviews', 'ReviewController@index');
		// Route::post('admin/reviews', 'ReviewController@destroy');
		// Route::post('admin/reviews-bulk', 'ReviewController@bulk_destroy_confirm');
		// Route::post('admin/reviews-bulk-destroy', 'ReviewController@bulk_destroy');
		
		//Map Tracks
		Route::get('admin/maptracks/create', 'MapTracksController@create');
		Route::post('admin/maptracks/create', 'MapTracksController@store');
		Route::get('admin/maptracks/edit', 'MapTracksController@edit');
		Route::post('admin/maptracks/edit', 'MapTracksController@update');

		# Users
		Route::get('admin/users', 'UsersController@index');
		Route::get('admin/users/create', 'UsersController@create');
		Route::post('admin/users', 'UsersController@store');
		Route::get('admin/users/{id}/edit', 'UsersController@edit');
		Route::patch('admin/users/{id}', 'UsersController@update');
		Route::post('admin/destroy-users', 'UsersController@destroy');
		Route::post('admin/users-bulk', 'UsersController@bulk_destroy_confirm');
		Route::post('admin/users-bulk-destroy', 'UsersController@bulk_destroy');
		Route::get('admin/users/single/{status}/user/{id}', 'UsersController@single_status');
		Route::post('admin/users/bulk/{status}', 'UsersController@bulk_status');
		#profile
		Route::get('admin/profile/{id}/edit', 'UsersController@edit_profile');
		Route::patch('admin/profile/{id}', 'UsersController@update_profile');

		//Comments
		Route::get('admin/comments', 'CommentsController@index');
		Route::get('admin/comments/{id}/edit', 'CommentsController@edit');
		Route::patch('admin/comments/{id}', 'CommentsController@update');
		Route::post('admin/comments', 'CommentsController@destroy');
		Route::post('admin/comments-bulk', 'CommentsController@bulk_destroy_confirm');
		Route::post('admin/comments-bulk-destroy', 'CommentsController@bulk_destroy');
		Route::get('admin/comments/single/{status}/section/{id}', 'CommentsController@single_status');
		Route::post('admin/comments/bulk/{status}', 'CommentsController@bulk_status');
		
		#Media
		Route::get('media/browse/images', 'MediaController@browse_images');
		Route::get('media/upload/image', 'MediaController@upload_image');
		Route::post('media/upload/image', 'MediaController@store_image');
		Route::get('media/browse/gallery', 'MediaController@browse_gallery_images');
		Route::get('media/upload/gallery', 'MediaController@upload_gallery_image');
		Route::post('media/upload/gallery', 'MediaController@store_image_gallery');
	});

	#admin login
	Route::get('admin/login', 'Auth\AuthController@getadmin');
	Route::post('admin/login', 'Auth\AuthController@postadmin');
	Route::get('logout', 'Auth\AuthController@getLogout');

	Route::group([
		      	'middleware' => 'App\Http\Middleware\AdminMiddleware'
			],function()
	{
	#System Home
		Route::get('/admin', 'DashboardController@index');
		Route::get('/', function()
		{
			return redirect('/admin');
		});

		Route::get('admin/getareas/{id}', 'AreaController@getareas');
	});
});

# API
Route::group(['middleware' => ['api']], function () use($locale) {
	Route::get('/api/languages', 'ApiController@languages');
	Route::group([
		      	'prefix' => $locale.'/api'
			],function()
	{
		#Sections
		Route::get('sections', 'ApiController@sections');
		
		#Sites
		Route::get('sites', 'ApiController@sites');
		
		#Comments
		Route::post('add-comment', 'ApiController@create_comment');

		#Reviews
	    Route::post('add-review', 'ApiController@create_review');

	    #Photo Album
	    Route::get('photo-albums', 'ApiController@palbum');

	    #Video Album
	    Route::get('video-album', 'ApiController@valbum');

	    #News
	    Route::get('news', 'ApiController@news');
	    
	    #Cities
	    Route::get('city', 'ApiController@city');

	    #Areas
	    Route::get('area', 'ApiController@area');

	    #Events
	    Route::get('events', 'ApiController@events');

	    #Single Events
	    Route::get('events/{id}', 'ApiController@single_event');

	    #Banners
	    Route::get('banners', 'ApiController@banners');
	    Route::get('banners-web', 'ApiController@banners_web_view');

		#Contact Us
	    Route::post('contact', 'ApiController@create_contactus');
	    Route::get('contacts-info', 'ApiController@contacts_info');
	    Route::get('contacts-gmap', 'ApiController@contacts_gmap');
	    
	    #Complains
	    Route::get('complains-sections', 'ApiController@complains_sections');
	    Route::post('create-complain', 'ApiController@complain');
	    #upload media
	    Route::post('upload-media', 'ApiController@upload_media');

	    #Important links
	    Route::get('implinks', 'ApiController@implinks');

		#pages
	    Route::get('pages', 'ApiController@pages');

	    #Map directions
	    Route::get('map-directions', 'ApiController@maptracks');

	    #Social media
	    Route::get('social-media', 'ApiController@social_media');

		// #Favorites canceled
	 	// Route::post('add-favorite', 'ApiController@create_favourite');
	 	// Route::get('favorites', 'ApiController@favourites');
		
	});
});
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
//web-view
Route::group(['middleware' => ['web'], 'prefix' => $locale],
	function () {
    #sites
	Route::get('sites/{id}', 'WebviewController@sites');
	#news
	Route::get('news/{id}', 'WebviewController@news');
	#Events
	Route::get('events/{id}', 'WebviewController@events_wv');
});


