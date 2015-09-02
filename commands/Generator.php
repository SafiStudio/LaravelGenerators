<?php
/**
 * Generator for admin form and list views
 * version 0.1
 */
namespace SafiStudio\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use SafiStudio\FormGenerator;
use SafiStudio\ListGenerator;

class Generator extends Command
{
    use \Illuminate\Console\AppNamespaceDetectorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generator:package {PackageName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate MVC as package';

    /**
     * Template path
     *
     * @var string
     */
    protected $template_path;

    /**
     * App namespace
     *
     * @var string
     */
    protected $namespace;

    /**
     * Package name
     *
     * @var string
     */
    protected $package;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Set templates path for MVC files
        $this->template_path = base_path().'/vendor/safistudio/generators/templates';
        $this->namespace = $this->getNamespace();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->package = $this->argument('PackageName');
        $this->generateFiles();
    }

    /**
     * Generate MVC files
     */
    private function generateFiles(){
        $this->info('Start to execute SQL file for '.$this->package);
        if(!$this->executeSQL()){
            $this->error('Check your query. SQL returns an error.');
            return;
        }
        $this->info('Start to generate controller file for '.$this->package);
        if(!$this->createController()){
            $this->warn('Controller file exists. Please remove all package files before command run.');
        }
        $this->info('Start to generate model file for '.$this->package);
        if(!$this->createModel()){
            $this->warn('Model file exists. Please remove all package files before command run.');
        }
        $this->info('Start to generate request file for '.$this->package);
        if(!$this->createRequest()){
            $this->warn('Request file exists. Please remove all package files before command run.');
        }
        $this->info('Start to generate form view file for '.$this->package);
        if(!$this->createFormView()){
            $this->warn('Form view file exists. Please remove all package files before command run.');
        }
        $this->info('Start to generate list view file for '.$this->package);
        if(!$this->createListView()){
            $this->warn('List view file exists. Please remove all package files before command run.');
        }
        $this->info('Start to generate routing');
        if(!$this->createRouting()){
            $this->warn('Routing for package exists. Please remove all package routing before command run.');
        }
    }

    /**
     * Execute SQL command
     *
     * @return bool
     */
    private function executeSQL(){
        $generator = app_path().'/Generators/'.$this->package.'.php';

        if(!file_exists($generator)){
            $this->error('Brak pliku generatora');
            return false;
        }
        include $generator;

        if($sql && is_array($sql)){
            $rt = true;
            foreach($sql as $q){
                if(!DB::statement($q))
                    return false;
            }
            return $rt;
        }

        return true;
    }

    /**
     * Generate controller file
     *
     * @return bool
     */
    private function createController(){
        $ctrl_path = app_path().'/Http/Controllers/Admin/';
        $ctrl_name = $this->package.'Controller';
        $model_name = $this->package.'Model';
        $request_name = $this->package.'Request';

        if(!is_dir($ctrl_path))
            mkdir($ctrl_path, 0755);

        if(file_exists($ctrl_path.$ctrl_name.'.php'))
            return false;

        copy($this->template_path.'/controller.generator.php', $ctrl_path.$ctrl_name.'.php');

        $ctrl = file_get_contents($ctrl_path.$ctrl_name.'.php');

        $ctrl = $this->setControllerElements($ctrl);

        $ctrl = str_replace('GeneratorNameSpace\\',$this->namespace, $ctrl); // Set app namespaces
        $ctrl = str_replace('GeneratorNameController', $ctrl_name, $ctrl); // Set controller name
        $ctrl = str_replace('GeneratorNameModel', $model_name, $ctrl); // Set model namespace
        $ctrl = str_replace('GeneratorNameRequest', $request_name, $ctrl); // Set model namespace

        $form_view = 'admin.'.strtolower($this->package).'.form';
        $list_view = 'admin.'.strtolower($this->package).'.list';

        $ctrl = str_replace('{form_view}', $form_view, $ctrl); // Set form view
        $ctrl = str_replace('{list_view}', $list_view, $ctrl); // Set list view
        $ctrl = str_replace('{short_name}', strtolower($this->package), $ctrl); // Set list view

        $fctrl = fopen($ctrl_path.$ctrl_name.'.php', 'w');
        fwrite($fctrl, $ctrl);
        fclose($fctrl);

        $this->info('Controller file created sucessfully');

        return true;
    }

    /**
     * Method to change controller comment elements to PHP code
     *
     * @return string
     */
    private function setControllerElements($ctrl){
        $generator = app_path().'/Generators/'.$this->package.'.php';
        include $generator;

        preg_match_all("/\/\/ {(.*?)}/", $ctrl, $matches);
        $used_ext = [];
        if(isset($matches[1])){
            foreach($matches[1] as $i => $extension){
                include_once $this->template_path.'/elements/controller/'.$extension.'.php';
                $fn_name = 'get'.ucfirst($extension).'Code';
                if(!in_array($extension, $used_ext) && in_array($extension, $extensions)){
                    $ctrl = str_replace($matches[0][$i], $fn_name(true), $ctrl);
                }
                else{
                    $ctrl = str_replace($matches[0][$i], $fn_name(false), $ctrl);
                }
            }
        };
        return $ctrl;
    }


    /**
     * Generate model file
     *
     * @return bool
     */
    private function createModel(){
        $model_path = app_path().'/';
        $model_name = $this->package.'Model';
        $generator = app_path().'/Generators/'.$this->package.'.php';

        if(file_exists($model_path.$model_name.'.php'))
            return false;

        copy($this->template_path.'/model.generator.php', $model_path.$model_name.'.php');

        $model = file_get_contents($model_path.$model_name.'.php');

        $model = str_replace('GeneratorNameSpace',substr($this->namespace, 0, -1), $model); // Set app namespaces
        $model = str_replace('GeneratorNameModel', $model_name, $model); // Set model name
        $model = str_replace('{table_name}', strtolower($this->package), $model); // Set table name

        include $generator;

        $fillable = [];
        foreach($form['fields'] as $key => $field){
            $fillable []= "'".$field['name']."'";
        }
        $fillable = '['.implode(', ', $fillable).']';

        $model = str_replace("'{fillable}'", $fillable, $model); // Set fillable fields

        $searchable = [];
        if(is_array($search)){
            foreach($search as $key => $field){
                $searchable []= "'".$field."'";
            }
            $searchable = '['.implode(', ', $searchable).']';
        }
        $model = str_replace("'{searchable}'", $searchable, $model); // Set fillable fields

        $fmodel = fopen($model_path.$model_name.'.php', 'w');
        fwrite($fmodel, $model);
        fclose($fmodel);

        $this->info('Model file created sucessfully');

        return true;
    }

    /**
     * Generate request file
     *
     * @return bool
     */
    private function createRequest(){
        $rq_path = app_path().'/Http/Requests/Admin/';
        $rq_name = $this->package.'Request';
        $generator = app_path().'/Generators/'.$this->package.'.php';

        if(!is_dir($rq_path))
            mkdir($rq_path, 0755);

        if(file_exists($rq_path.$rq_name.'.php'))
            return false;

        copy($this->template_path.'/request.generator.php', $rq_path.$rq_name.'.php');

        $request = file_get_contents($rq_path.$rq_name.'.php');

        $request = str_replace('GeneratorNameSpace',substr($this->namespace, 0, -1), $request); // Set app namespaces
        $request = str_replace('GeneratorNameRequest', $rq_name, $request); // Set request name

        include $generator;

        $rules = [];
        $attributes = [];
        foreach($form['fields'] as $key => $field){
            if($field['rules']){
                $rules []= "'data.".$field['name']."' => '".$field['rules']."'";
                $attributes []= "'data.".$field['name']."' => '".$field['label']."'";
            }
        }
        $rules = "[\n\t\t\t".implode(",\n\t\t\t", $rules)."\n\t\t]";
        $attributes = "[\n\t\t\t".implode(",\n\t\t\t", $attributes)."\n\t\t]";

        $request = str_replace("'{rules}'", $rules, $request); // Set rules
        $request = str_replace("'{attributes}'", $attributes, $request); // Set attributes

        $fmodel = fopen($rq_path.$rq_name.'.php', 'w');
        fwrite($fmodel, $request);
        fclose($fmodel);

        $this->info('Request file created sucessfully');

        return true;
    }

    /**
     * Generate form view file
     *
     * @return boolean
     */
    private function createFormView()
    {
        $admin_path = base_path().'/resources/views/admin';
        $view_path = $admin_path.'/'.strtolower($this->package);
        $view_name = '/form.blade.php';

        if(!is_dir($admin_path))
            mkdir($admin_path, 0755);
        if(!is_dir($view_path))
            mkdir($view_path, 0755);

        if(file_exists($view_path.$view_name))
            return false;

        copy($this->template_path.'/form.generator.php', $view_path.$view_name);

        $form = file_get_contents($view_path.$view_name);

        $data = FormGenerator::generateForm($this->package);
        $form = str_replace('{controller}',$this->package.'Controller', $form); // Set form fields
        $form = str_replace('{title}',$data['title'], $form); // Set form fields
        $form = str_replace('{elements}',$data['form'], $form); // Set form fields

        $fform = fopen($view_path.$view_name, 'w');
        fwrite($fform, $form);
        fclose($fform);

        $this->info('Form view file created sucessfully');

        return true;
    }

    /**
     * Generate list view file
     *
     * @return boolean
     */
    private function createListView()
    {
        $admin_path = base_path().'/resources/views/admin';
        $view_path = $admin_path.'/'.strtolower($this->package);
        $view_name = '/list.blade.php';

        if(!is_dir($admin_path))
            mkdir($admin_path, 0755);
        if(!is_dir($view_path))
            mkdir($view_path, 0755);

        if(file_exists($view_path.$view_name))
            return false;

        copy($this->template_path.'/list.generator.php', $view_path.$view_name);

        $list = file_get_contents($view_path.$view_name);

        $data = ListGenerator::generateList($this->package);
        $list = str_replace('{title}',$data['title'], $list); // Set form fields
        $list = str_replace('{headers}',$data['headers'], $list); // Set form fields
        $list = str_replace('{columns}',$data['columns'], $list); // Set form fields
        $list = str_replace('{controller}',$this->package.'Controller', $list); // Set form fields

        $flist = fopen($view_path.$view_name, 'w');
        fwrite($flist, $list);
        fclose($flist);

        $this->info('List view file created sucessfully');

        return true;
    }

    /**
     * Generate routing for MVC
     */
    private function createRouting(){
        $add_php = false;
        $rt_file = app_path().'/Http/routes.php';
        if(!file_exists($rt_file))
            $add_php = true;
        else
            $check_ct = file_get_contents($rt_file);

        if($check_ct && strpos($check_ct, "// --- Routing for ".$this->package)!==false){
            return false;
        }

        $rt_handle = fopen($rt_file, 'a+');

        $header = "\n// --- Routing for ".$this->package."\n";
        if($add_php)
            $header = "<?php \n\n".$header;
        fwrite($rt_handle, $header);



        $command_start = "\nRoute::group(['middleware' => 'auth.admin'], function(){\n\tRoute::group(['prefix' => 'admin/".strtolower($this->package)."'], function(){";
        $command = "\n\t\tRoute::{method}('{uri}', [\n\t\t\t'uses' => '{controller}@{action}'\n\t\t]);";
        // List routing
        $list_cmd = $command;
        $list_cmd = str_replace('{method}','get',$list_cmd);
        $list_cmd = str_replace('{uri}','/',$list_cmd);
        $list_cmd = str_replace('{controller}','Admin\\'.$this->package.'Controller',$list_cmd);
        $list_cmd = str_replace('{action}','index',$list_cmd);
        $command_start .= $list_cmd;
        // List POST routing
        $list_cmd = $command;
        $list_cmd = str_replace('{method}','post',$list_cmd);
        $list_cmd = str_replace('{uri}','/',$list_cmd);
        $list_cmd = str_replace('{controller}','Admin\\'.$this->package.'Controller',$list_cmd);
        $list_cmd = str_replace('{action}','index',$list_cmd);
        $command_start .= $list_cmd;
        // New form
        $list_cmd = $command;
        $list_cmd = str_replace('{method}','get',$list_cmd);
        $list_cmd = str_replace('{uri}','form',$list_cmd);
        $list_cmd = str_replace('{controller}','Admin\\'.$this->package.'Controller',$list_cmd);
        $list_cmd = str_replace('{action}','create',$list_cmd);
        $command_start .= $list_cmd;
        // Store form
        $list_cmd = $command;
        $list_cmd = str_replace('{method}','post',$list_cmd);
        $list_cmd = str_replace('{uri}','form',$list_cmd);
        $list_cmd = str_replace('{controller}','Admin\\'.$this->package.'Controller',$list_cmd);
        $list_cmd = str_replace('{action}','store',$list_cmd);
        $command_start .= $list_cmd;
        // Edit form
        $list_cmd = $command;
        $list_cmd = str_replace('{method}','get',$list_cmd);
        $list_cmd = str_replace('{uri}','form/{id}',$list_cmd);
        $list_cmd = str_replace('{controller}','Admin\\'.$this->package.'Controller',$list_cmd);
        $list_cmd = str_replace('{action}','edit',$list_cmd);
        $command_start .= $list_cmd;
        // Update form
        $list_cmd = $command;
        $list_cmd = str_replace('{method}','post',$list_cmd);
        $list_cmd = str_replace('{uri}','form/{id}',$list_cmd);
        $list_cmd = str_replace('{controller}','Admin\\'.$this->package.'Controller',$list_cmd);
        $list_cmd = str_replace('{action}','update',$list_cmd);
        $command_start .= $list_cmd;
        // Remove form
        $list_cmd = $command;
        $list_cmd = str_replace('{method}','get',$list_cmd);
        $list_cmd = str_replace('{uri}','remove/{id}',$list_cmd);
        $list_cmd = str_replace('{controller}','Admin\\'.$this->package.'Controller',$list_cmd);
        $list_cmd = str_replace('{action}','destroy',$list_cmd);
        $command_start .= $list_cmd;
        // Show item
        $list_cmd = $command;
        $list_cmd = str_replace('{method}','get',$list_cmd);
        $list_cmd = str_replace('{uri}','item/{id}',$list_cmd);
        $list_cmd = str_replace('{controller}','Admin\\'.$this->package.'Controller',$list_cmd);
        $list_cmd = str_replace('{action}','show',$list_cmd);
        $command_start .= $list_cmd;

        // Write to routes
        $command_end = "\n\t});\n});";
        fwrite($rt_handle, $command_start . $command_end);

        $this->info('Routing created sucessfully');
    }

    /**
     * Get app namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->getAppNamespace();
    }

}
