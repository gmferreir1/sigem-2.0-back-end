<?php

namespace Modules\Sicadi\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class DjGuide.
 *
 * @package namespace App\Entities;
 */
class DjGuide extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "dj_guides";

    protected $connection = "sicadi";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dj_id',
        'date_send',
        'receipt_id',
        'value',
        'date_exit',
    ];

    public function setDateSendAttribute($value)
    {
        $date = str_replace('/', '-', $value);
        $this->attributes['date_send'] = date('Y-m-d', strtotime($date));
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = (float) $value;
    }

    public function setDateExitAttribute($value)
    {
        if ($value) {
            $date = str_replace('/', '-', $value);
            $this->attributes['date_exit'] = date('Y-m-d', strtotime($date));
        } else {
            $this->attributes['date_exit'] = null;
        }
    }

}
