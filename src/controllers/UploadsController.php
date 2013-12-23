<?php namespace Davzie\LaravelBootstrap\Controllers;
use Davzie\LaravelBootstrap\Uploads\UploadsInterface;
use Illuminate\Support\MessageBag;
use Input, App, Redirect;
class UploadsController extends ObjectBaseController {

    /**
     * The place to find the views / URL keys for this controller
     * @var string
     */
    protected $view_key = 'uploads';

    /**
     * Construct Shit
     */
    public function __construct( UploadsInterface $galleries )
    {
        $this->model = $galleries;
        parent::__construct();
    }

    public function postUpdate()
    {
        $ims = Input::get('deleteImage');
        $uploads = App::make('Davzie\LaravelBootstrap\Uploads\UploadsInterface');
        // #todo delete relations?
        // $z = $uploads->getModel()->whereIn( 'id' , $ims )->get()[0]->uploadable()->get();
        // var_dump($z);
        $success = $uploads->deleteById( $ims );
        return Redirect::to( $this->object_url )->with( 'success' , new MessageBag( array( 'Items deleted' ) ) );
    }
}