<?php

namespace GeneratorNameSpace\Http\Controllers\Admin;

use Illuminate\Http\Request;
use GeneratorModelNameSpace\GeneratorNameModel;
use GeneratorNameSpace\Http\Requests\Admin\GeneratorNameRequest;
use GeneratorNameSpace\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
// {headgenerator}
class GeneratorNameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $search = \Request::input('search');
        if(isset($search['text'])){
            Session::put('GeneratorName.search.text', $search['text']);
            return redirect()->action('Admin\GeneratorNameController@index');
        }

        $search_value = Session::get('GeneratorName.search.text', '');
        $data = GeneratorNameModel::search($search_value)->paginate(30);
        $data->setPath(''); // set default path to pagination

        return view('{list_view}', ['data' => $data, 'search_value' => $search_value]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $item = new GeneratorNameModel();
        // {editor}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(GeneratorNameRequest $request)
    {
        $data = $request->get('data');

        // Data strone
        $db_data = array();
        if(is_array($data)){
            foreach($data as $key => $value){
                $db_data[$key] = $value;
            }
        }
        // {files}
        $object = new GeneratorNameModel($db_data);
        $object->save();

        return redirect()->action('Admin\GeneratorNameController@index')->with('message', 'Element został pomyślnie zapisany');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $item = GeneratorNameModel::find($id);
        $validator = \Validator::make(['check'=>$item],['check'=>'required'],['required'=>'Nie mogę odnaleźć elementu do edycji']);
        if($validator->fails()){
            return redirect()->action('Admin\GeneratorNameController@index')->withErrors($validator);
        }

        return $item;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $item = GeneratorNameModel::find($id);
        $validator = \Validator::make(['check'=>$item],['check'=>'required'],['required'=>'Nie mogę odnaleźć elementu do edycji']);
        if($validator->fails()){
            return redirect()->action('Admin\GeneratorNameController@index')->withErrors($validator);
        }
        // {editor}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(GeneratorNameRequest $request, $id)
    {
        $item = GeneratorNameModel::find($id);
        $validator = \Validator::make(['check'=>$item],['check'=>'required'],['required'=>'Nie mogę odnaleźć elementu do edycji']);
        if($validator->fails()){
            return redirect()->action('Admin\GeneratorNameController@index')->withErrors($validator);
        }

        $data = $request->get('data');

        $db_data = array();
        if(is_array($data)){
            foreach($data as $key => $value){
                $db_data[$key] = $value;
            }
        }
        // {files}
        $item->update($db_data);

        return redirect()->action('Admin\GeneratorNameController@index')->with('message', 'Element został pomyślnie zapisany');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = GeneratorNameModel::find($id);
        $validator = \Validator::make(['check'=>$item],['check'=>'required'],['required'=>'Nie mogę odnaleźć elementu do usunięcia']);
        if($validator->fails()){
            return redirect()->action('Admin\GeneratorNameController@index')->withErrors($validator);
        }
        else{
            $item->delete();
            return redirect()->action('Admin\GeneratorNameController@index')->with('message', 'Element został pomyślnie usunięty');
        }
    }
}