<?php namespace Davzie\LaravelBootstrap\Abstracts\Traits;
use App;

trait UploadableRelationship
{

    /**
     * The relationship setup for taggable classes
     * @return Eloquent
     */
    // public function uploads()
    // {
    //     return $this->morphMany( 'Davzie\LaravelBootstrap\Uploads\Uploads' , 'uploadable' )->orderBy('order','asc');
    // }

    public function uploads()
    {
        return $this->morphToMany( 'Davzie\LaravelBootstrap\Uploads\Uploads' , 'uploadable', 'uploadables', 'uploadable_id' )->orderBy('order','asc')->withPivot('id', 'uploadable_id');
    }

    /**
     * Remove the imagery associated with this model
     * @return void
     */
    public function deleteImagery($id)
    {
        $uploads = App::make('Davzie\LaravelBootstrap\Uploads\UploadsInterface');
        $uploads->deleteById( $id );
    }

    /**
     * Remove the imagery associated with this model
     * @return void
     */
    public function deleteAllImagery()
    {
        $uploads = App::make('Davzie\LaravelBootstrap\Uploads\UploadsInterface');
        $uploads->deleteByIdType( $this->id , $this->getTableName() );
    }

}