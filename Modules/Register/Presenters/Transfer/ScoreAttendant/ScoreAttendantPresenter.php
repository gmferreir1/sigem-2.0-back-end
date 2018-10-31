<?php

namespace Modules\Register\Presenters\Transfer\ScoreAttendant;

use Modules\Register\Transformers\Transfer\ScoreAttendant\ScoreAttendantTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ScoreAttendantPresenter.
 *
 * @package namespace App\Presenters;
 */
class ScoreAttendantPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ScoreAttendantTransformer();
    }
}
