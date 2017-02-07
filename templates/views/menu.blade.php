<nav class="main-navigation">
    <ul>
        <li{!! strpos(Request::path(), 'admin/panel')!==false ? ' class="active"' : '' !!}>
            <a href="{{ action('Admin\PanelController@index') }}"><i class="icon fa fa-fw fa-dashboard"></i> Panel</a>
        </li>
    </ul>
</nav>