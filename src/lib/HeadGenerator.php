<?php
namespace SafiStudio;

class HeadGenerator
{
    private $_stylesheets = [];
    private $_scripts = [];

    public function getHead(){
        $head = [];

        if($this->_stylesheets)
            $head []= implode("\n\t", $this->_stylesheets);
        if($this->_scripts)
            $head []= implode("\n\t", $this->_scripts);

        $head = implode("\n\t", $head);
        return $head;
    }

    public function attachScript($script){
        $this->_scripts []= '<script src="'.asset($script).'"></script>';
    }

    public function attachStyleSheet($stylesheet){
        $this->_stylesheets []= '<link rel="stylesheet" href="'.asset($stylesheet).'" />';
    }
}