<?php

namespace GeneratorNameSpace;

use Illuminate\Database\Eloquent\Model;

class GeneratorNameModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = '{table_name}';

    /**
     * The array of fillable fields.
     *
     * @var array
     */
    protected $fillable = '{fillable}';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The array of searchable fields
     *
     * @var array
     */
    protected $search_fields = '{searchable}';

    /**
     * Method to set search query
     *
     * @param $query
     * @param $search_value string
     * @return mixed
     */
    public function scopeSearch($query, $search_value)
    {
        if($search_value){
            foreach($this->search_fields as $field){
                $query->orWhere($field, 'LIKE', '%'.$search_value.'%');
            }
        }
        return $query;
    }

}