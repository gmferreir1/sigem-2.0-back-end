<?php

namespace Modules\Register\Presenters\Transfer\Reason;

use Modules\Register\Transformers\Transfer\Reason\ReasonTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ReasonPresenter.
 *
 * @package namespace App\Presenters;
 */
class ReasonPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ReasonTransformer();
    }
}
