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

}