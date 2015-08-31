@extends('layouts.admin')

@section('content')
<div class="card-head">
    <h3>{title}</h3>
    <div class="actions">
        <a href="#" id="saveForm" class="button standard">
            <i class="fa fa-save"></i>
        </a>
        <a href="{{  action('Admin\{controller}@index') }}" class="button back">
            <i class="fa fa-ban"></i>
        </a>
    </div>
</div>
<div class="card">
    <div class="card-text bottom-space form-container">
        <form method="post" id="adminForm" action="{{ ($item->id) ? action('Admin\{controller}@update',['id'=>$item->id]) : action('Admin\{controller}@store') }}" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="form">{elements}
            </div>
        </form>
    </div>
</div>
@endsection
