<?php
namespace SafiStudio;

class FormGenerator{

    public static function generateForm($package){
        $generator = app_path().'/Generators/'.$package.'.php';
        $form_line = base_path().'/vendor/safistudio/generators/templates/elements/form.line.php';

        if(!file_exists($generator))
            die('Can not find generator file');

        if(!file_exists($form_line))
            die('Can not find form line file');

        $form = array();

        include($generator);

        $rt_data = array(
            'title' => '',
            'form' => '',
        );

        $rt_data['title'] = $form['title'];

        $f_lines = array();
        foreach($form['fields'] as $field){
            $method = 'get'.ucfirst($field['type']).'Field';
            if(method_exists(self::class, $method)){
                $input = self::$method($field);
            }
            else{
                $input = self::getStandardField($field);
            }
            $line = file_get_contents($form_line);

            $line = str_replace('{input}', $input, $line);
            $line = str_replace('{label}', $field['label'], $line);
            $line = str_replace('{name}', $field['name'], $line);


            $f_lines []= $line;
        }
        $rt_data['form'] = "\n".implode("\n", $f_lines);

        return $rt_data;
    }

    private static function getStandardField($field){
        $code_file = base_path().'/vendor/safistudio/generators/templates/elements/inputs/'.$field['type'].'.php';
        if(!file_exists($code_file))
            die('Can not find input file '.$code_file);

        $code = file_get_contents($code_file);

        $params = array();
        foreach($field['params'] as $key=>$value){
            $params []= $key.'="'.$value.'"';
        }
        $params = implode(' ', $params);

        $code = str_replace('{params}', $params, $code);

        return $code;
    }

    private static function getTextareaField($field){
        $code_file = base_path().'/vendor/safistudio/generators/templates/elements/inputs/'.$field['type'].'.php';
        if(!file_exists($code_file))
            die('Can not find input file '.$code_file);

        $code = file_get_contents($code_file);

        $params = array();
        foreach($field['params'] as $key=>$value){
            $params []= $key.'="'.$value.'"';
        }
        $params = implode(' ', $params);

        $code = str_replace('{params}', $params, $code);

        return $code;
    }

    private static function getFileField($field){
        $code_file = base_path().'/vendor/safistudio/generators/templates/elements/inputs/'.$field['type'].'.php';
        if(!file_exists($code_file))
            die('Can not find input file '.$code_file);

        $code = file_get_contents($code_file);

        $params = array();
        foreach($field['params'] as $key=>$value){
            $params []= $key.'="'.$value.'"';
        }
        $params = implode(' ', $params);

        $code = str_replace('{params}', $params, $code);

        return $code;
    }

    private static function getCheckboxField($field){
        $code_file = base_path().'/vendor/safistudio/generators/templates/elements/inputs/'.$field['type'].'.php';
        if(!file_exists($code_file))
            die('Can not find input file '.$code_file);

        $code = file_get_contents($code_file);

        $params = array();
        foreach($field['params'] as $key=>$value){
            $params []= $key.'="'.$value.'"';
        }
        $params = implode(' ', $params);

        $code = str_replace('{params}', $params, $code);

        return $code;
    }

    private static function getSelectField($field){
        $code_file = base_path().'/vendor/safistudio/generators/templates/elements/inputs/'.$field['type'].'.php';
        if(!file_exists($code_file))
            die('Can not find input file '.$code_file);

        $code = file_get_contents($code_file);

        $params = array();
        foreach($field['params'] as $key=>$value){
            $params []= $key.'="'.$value.'"';
        }
        $params = implode(' ', $params);

        $code = str_replace('{params}', $params, $code);

        $options = [];
        foreach($field['options'] as $value => $label){
            $options []= '<option value="'.$value.'"{{ (old(\'data.{name}\')==\''.$value.'\' || $item->{name}==\''.$value.'\') ? \' selected="selected"\' : \'\' }}>'.$label.'</option>';
        }

        $code = str_replace('{options}', implode("\n\t\t\t\t\t\t\t", $options), $code);

        return $code;
    }

    private static function getPasswordField($field){
        $code_file = base_path().'/vendor/safistudio/generators/templates/elements/inputs/'.$field['type'].'.php';
        if(!file_exists($code_file))
            die('Can not find input file '.$code_file);

        $code = file_get_contents($code_file);

        $params = array();
        foreach($field['params'] as $key=>$value){
            $params []= $key.'="'.$value.'"';
        }
        $params = implode(' ', $params);

        $code = str_replace('{params}', $params, $code);

        return $code;
    }

}