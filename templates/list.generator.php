@extends('layouts.admin')

@section('content')
<div class="card-head">
    <h3>{title}</h3>
    <div class="actions">
        <a href="{{ action('Admin\{controller}@create') }}" class="button standard">
            <i class="fa fa-plus"></i>
        </a>
        <div class="search-box">
            <div class="button search">
                <i class="fa fa-search"></i>
            </div>
            <span class="search-value">{{ $search_value }}</span>
            <div class="search-container">
                <form action="{{ action('Admin\{controller}@index') }}" method="post">
                    {!! csrf_field() !!}
                    <ul>
                        <li>
                            <input type="text" name="search[text]" value="{{ $search_value }}" class="search-input-value" />
                        </li>
                        <li>
                            <button name="search[submit]" type="submit">szukaj</button>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-text bottom-space">
        @if(count($data) > 0)
        <table class="list-table">
            <thead>
            <tr>{headers}
                <th class="actions">Akcja</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $row)
            <tr>{columns}
                <td class="actions">
                    <a href="{{ action('Admin\{controller}@edit', ['id' => $row->id]) }}" class="edit">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <a href="{{ action('Admin\{controller}@destroy', ['id' => $row->id]) }}" class="remove">
                        <i class="fa fa-remove"></i>
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @else
        <p class="no-data">
            Brak danych do wyświetlenia
        </p>
        @endif
    </div>
</div>
{!! $data->render() !!}
@endsection