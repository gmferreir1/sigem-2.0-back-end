<?php

namespace Modules\Register\Presenters\Transfer\Historic;

use Modules\Register\Transformers\Transfer\Historic\HistoricTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class HistoricPresenter.
 *
 * @package namespace App\Presenters;
 */
class HistoricPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new HistoricTransformer();
    }
}
