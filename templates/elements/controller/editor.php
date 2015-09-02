<?php
function getEditorCode($show){
    if($show){
        return "\$head = new HeadGenerator();
        \$head->attachScript('js/editor/ckeditor.js');

        return view('admin.hotels.form',['item' => \$item, '_head_scripts' => \$head->getHead()]);";
    }
    else{
        return "\n\t\treturn view('admin.hotels.form',['item' => \$item]);";
    }
}
