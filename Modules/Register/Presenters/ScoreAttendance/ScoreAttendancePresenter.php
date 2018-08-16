<?php

namespace Modules\Register\Presenters\ScoreAttendance;

use Modules\Register\Transformers\ScoreAttendance\ScoreAttendanceTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ScoreAttendancePresenter.
 *
 * @package namespace App\Presenters;
 */
class ScoreAttendancePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ScoreAttendanceTransformer();
    }
}
