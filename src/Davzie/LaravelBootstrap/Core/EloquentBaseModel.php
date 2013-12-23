<?php namespace Davzie\LaravelBootstrap\Core;
use Davzie\LaravelBootstrap\Core\Exceptions\NoValidationRulesFoundException;
use Validator, Eloquent, ReflectionClass, Input;

/**
 * Base Eloquent Class Built On From Shawn McCool <-- This guy is pretty amazing
 */
class EloquentBaseModel extends Eloquent
{
    protected $validationRules = [];
    protected $validator;

    public function isValid( $data = array() )
    {
        if ( ! isset($this->validationRules) or empty($this->validationRules)) {
            throw new NoValidationRulesFoundException('no validation rules found in class ' . get_called_class());
        }

        if( !$data )
            $data = $this->getAttributes();

        $this->validator = Validator::make( $data , $this->getPreparedRules() );

        return $this->validator->passes();
    }

    public function getErrors()
    {
        return $this->validator->errors();
    }

    protected function getPreparedRules()
    {
        if ( ! $this->validationRules) {
            return [];
        }

        $preparedRules = $this->replaceIdsIfExists($this->validationRules);

        return $preparedRules;
    }

    protected function replaceIdsIfExists($rules)
    {
        $preparedRules = [];

        foreach ($rules as $key => $rule) {
            if (false !== strpos($rule, "<id>")) {
                if ($this->exists) {
                    $rule = str_replace("<id>", $this->getAttribute($this->primaryKey), $rule);
                } else {
                    $rule = str_replace("<id>", "", $rule);
                }
            }

            $preparedRules[$key] = $rule;
        }

        return $preparedRules;
    }

    public function addImagery($upload_ids) {
        if ($upload_ids) {
            foreach ($upload_ids as $upload_id) {
                $this->uploads()->attach($upload_id);
            }
        }
    } 

    public function removeImagery($upload_ids) {
        if ($upload_ids) {
            foreach ($upload_ids as $upload_id) {
                $this->uploads()->detach($upload_id);
            }
        }
    } 

    /**
     * Hydrate the model with more stuff and 
     * @return this
     */
    public function hydrate()
    {
        if( $this->isTaggable() )
            $this->saveTags();

        var_dump(Input::get('removeImage'));
        if( $this->isUploadable() ) {
            // $this->deleteImagery( Input::get('deleteImage') );
            $this->addImagery( Input::get('addImage') );
            $this->removeImagery( Input::get('removeImage') );
        }

        return $this;
    }

    /**
     * Delete method overrid
     * @return void
     */
    public function delete()
    {
        if( $this->isTaggable() )
            $this->saveTags('');

        if( $this->isUploadable() )
            $this->deleteAllImagery();


        return parent::delete();
    }

    /**
     * Figure out if tags can be used on the model
     * @return boolean
     */
    public function isTaggable()
    {
        return in_array( 'Davzie\LaravelBootstrap\Abstracts\Traits\TaggableRelationship' , ( new ReflectionClass( $this ) )->getTraitNames() );
    }

    /**
     * Figure out if you can upload stuff here
     * @return boolean
     */
    public function isUploadable()
    {
        return in_array( 'Davzie\LaravelBootstrap\Abstracts\Traits\UploadableRelationship' , ( new ReflectionClass( $this ) )->getTraitNames() );
    }            

    /**
     * Return the table name
     * @return string
     */
    public function getTableName()
    {
        return $this->table;
    }

}