<?php
namespace SafiStudio;

class ListGenerator{

    public static function generateList($package){
        $generator = app_path().'/Generators/'.$package.'.php';

        if(!file_exists($generator))
            die('Can not find generator file');

        $list = array();

        include($generator);

        $rt_data = array(
            'title' => '',
            'headers' => '',
            'columns' => '',
        );

        $rt_data['title'] = $list['title'];

        $headers = array();
        foreach($list['headers'] as $header){
            $headers []= "\n\t\t\t\t<th>".$header."</th>";
        }
        $rt_data['headers'] = implode("", $headers);

        $columns = array();
        foreach($list['columns'] as $column){
            $columns []= "\n\t\t\t\t<td>".self::getColumn($column)."</td>";
        }
        $rt_data['columns'] = implode("", $columns);

        return $rt_data;
    }

    private static function getColumn($column){
        $method = 'get'.$column['type'].'Column';
        return self::$method($column);
    }

    private static function getTextColumn($column){
        return '{{ $row->'.$column['name'].' }}';
    }

}