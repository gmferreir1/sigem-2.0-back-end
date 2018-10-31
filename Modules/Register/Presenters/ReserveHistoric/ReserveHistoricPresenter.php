<?php

namespace Modules\Register\Presenters\ReserveHistoric;

use Modules\Register\Transformers\ReserveHistoric\ReserveHistoricTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class HistoricPresenter.
 *
 * @package namespace App\Presenters;
 */
class ReserveHistoricPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ReserveHistoricTransformer();
    }
}
