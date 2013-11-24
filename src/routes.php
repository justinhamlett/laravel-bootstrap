<?php

// Get the URL segment to use for routing
$urlSegment = Config::get('laravel-bootstrap::app.access_url');

// Filter all requests ensuring a user is logged in when this filter is called
Route::filter('adminFilter', 'Davzie\LaravelBootstrap\Filters\Admin');

Route::controller( $urlSegment.'/users'     , 'Davzie\LaravelBootstrap\Controllers\UsersController' );
Route::controller( $urlSegment.'/uploads' , 	'Davzie\LaravelBootstrap\Controllers\UploadsController' );
Route::controller( $urlSegment.'/galleries' , 'Davzie\LaravelBootstrap\Controllers\GalleriesController' );
Route::controller( $urlSegment.'/settings'  , 'Davzie\LaravelBootstrap\Controllers\SettingsController' );
Route::controller( $urlSegment.'/blocks'    , 'Davzie\LaravelBootstrap\Controllers\BlocksController' );
Route::controller( $urlSegment.'/posts'     , 'Davzie\LaravelBootstrap\Controllers\PostsController' );
Route::controller( $urlSegment              , 'Davzie\LaravelBootstrap\Controllers\DashController'  );

/** Include IOC Bindings **/
include __DIR__.'/bindings.php';