<?php
function getFilesCode($show){
    if($show){
        return "\n\t\t// Files store
        \$files = \$request->file('data');
        if(is_array(\$files)){
            foreach(\$files as \$key => \$file){
                if(\$file && \$file->isValid()){
                    \$db_data[\$key] = \$file->getClientOriginalName();
                    \$bpath = public_path().'/data';
                    if(!is_dir(\$bpath))
                        mkdir(\$bpath, 0755);
                    if(!is_dir(\$bpath.'/{short_name}'))
                        mkdir(\$bpath.'/{short_name}', 0755);
                    \$fname_sfx = time();
                    if(file_exists(\$bpath.'/{short_name}/'.\$db_data[\$key]))
                        \$file->move(\$bpath.'/{short_name}/',\$fname_sfx.\$db_data[\$key]);
                    else
                        \$file->move(\$bpath.'/{short_name}/',\$db_data[\$key]);
                }

            }
        }\n";
    }
    else{
        return '';
    }
}