<?php namespace Davzie\LaravelBootstrap\Abstracts\Traits;
use App;

trait UploadableRelationship
{

    /**
     * The relationship setup for many-to-many uploads.
     * @return Eloquent
     */
    public function uploads()
    {
        return $this->morphToMany( 'Davzie\LaravelBootstrap\Uploads\Uploads' , 'uploadable' )->orderBy('order','asc')->withPivot('uploadable_id');
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
        $upload_ids = $this->uploads()->get()->all();
        foreach ($upload_ids as $upload_id) {
          $this->uploads()->detach($upload_id);
        }
    }

}