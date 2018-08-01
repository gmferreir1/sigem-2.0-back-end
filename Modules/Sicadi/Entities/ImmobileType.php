<?php

namespace Modules\Sicadi\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ImmobileType extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "immobile_types";

    protected $connection = "sicadi";

    public $timestamps = false;

    protected $fillable = [
        'type_immobile_id',
        'name_type_immobile',
    ];

    public function setTypeImmobileIdAttribute($value)
    {
        $this->attributes['type_immobile_id'] = trim($value);
    }

    public function setNameTypeImmobileAttribute($value)
    {
        $this->attributes['name_type_immobile'] = trim(toLowerCase(removeAccents(encode($value))));
    }
}
