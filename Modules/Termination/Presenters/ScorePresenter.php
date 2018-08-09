<?php

namespace Modules\Termination\Presenters;

use Modules\Termination\Transformers\ScoreTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ScorePresenter.
 *
 * @package namespace App\Presenters;
 */
class ScorePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ScoreTransformer();
    }
}
