@extends('laravel-bootstrap::layouts.interface')

@section('title')
    Manage Posts
@stop

@section('content')

    <h1>Manage Uploads</h1>

    {{-- The error / success messaging partial --}}
    @include('laravel-bootstrap::partials.messaging')
    
    
    @if( !$items->isEmpty() )
      {{ Form::open( array( 'url'=>$object_url.'/update' , 'class'=>'form-horizontal form-top-margin' , 'role'=>'form', 'id'=>'item-form' ) ) }}
      @include('laravel-bootstrap::partials.uploads-images')
      {{ Form::submit('Delete selected' , array('class'=>'btn btn-large btn-primary pull-right')) }}
      {{ Form::close() }}
    @else
        <div class="alert alert-info">
            <strong>No Items Yet:</strong> You don't have any items here just yet. Add one using the button below.
        </div>
    @endif
@stop