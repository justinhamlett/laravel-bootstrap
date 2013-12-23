<div id="item-media" class="row">
       <?php
    $index = 0;
    ?>
    @foreach($items as $upload)
    <?php
        if ($index == 0) {
            var_dump($upload->uploadable());
        }
        $index++;
        // $upload->sizeImg( 200 , 150 , false )
        
        ?>
    <div upload-id="{{ $upload->id }}" class="col-sm-6 col-md-4">
        <div class="thumbnail">
            <div class="image-container">
                <img src="{{ $upload->sizeImg( 200 , 150 , false ) }}" alt="">
            </div>
            <div class="caption">
                <label class="checkbox">
                    <?php $checkedArray = Input::old('deleteImage', [] ); ?>
                    {{ Form::checkbox('deleteImage['.$upload->id.']', $upload->id, in_array( $upload->id, $checkedArray ) ) }}
                    Delete Image
                </label>
            </div>
        </div>
    </div>
    @endforeach
</div>