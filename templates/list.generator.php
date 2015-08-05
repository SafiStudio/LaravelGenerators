@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-title">
        <h3>{title}</h3>
        <div class="card-title-actions">
            <a href="{{  action('Admin\{controller}@create') }}" class="standard">
                <i class="icon fa fa-plus"></i> Dodaj nowy
            </a>
        </div>
    </div>
    <div class="card-text bottom-space">
        <table class="list-table">
            <thead>
            <tr>{headers}
                <th>Akcja</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $row)
            <tr>{columns}
                <td class="actions">
                    <a href="{{ action('Admin\{controller}@edit', ['id' => $row->id]) }}" class="edit">
                        <i class="icon fa fa-edit"></i>
                    </a>
                    <a href="{{ action('Admin\{controller}@destroy', ['id' => $row->id]) }}" class="remove">
                        <i class="icon fa fa-remove"></i>
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection