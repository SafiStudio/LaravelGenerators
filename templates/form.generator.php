@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-title">
        <h3>{title}</h3>
        <div class="card-title-actions">
            <a href="#" id="saveForm" class="standard">
                <i class="icon fa fa-save"></i> Zapisz
            </a>
            <a href="{{  action('Admin\{controller}@index') }}" class="back">
                <i class="icon fa fa-ban"></i> Anuluj
            </a>
        </div>
    </div>
    <div class="card-text bottom-space form-container">
        <form method="post" id="adminForm" action="{{ ($item->id) ? action('Admin\{controller}@update',['id'=>$item->id]) : action('Admin\{controller}@store') }}" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="form">{elements}
            </div>
        </form>
    </div>
</div>
@endsection
