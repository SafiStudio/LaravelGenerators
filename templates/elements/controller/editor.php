<?php
function getEditorCode($show){
    if($show){
        return "\$head = new HeadGenerator();
        \$head->attachScript('js/editor/ckeditor.js');

        return view('{form_view}',['item' => \$item, '_head_scripts' => \$head->getHead()]);";
    }
    else{
        return "\n\t\treturn view('{form_view}',['item' => \$item]);";
    }
}
