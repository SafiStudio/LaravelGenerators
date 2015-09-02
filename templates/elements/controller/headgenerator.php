<?php
function getHeadgeneratorCode($show){
    if($show){
        return "use GeneratorNameSpace\\HeadGenerator;\n";
    }
    else{
        return '';
    }
}