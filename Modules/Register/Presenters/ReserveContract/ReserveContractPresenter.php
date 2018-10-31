<?php

namespace Modules\Register\Presenters\ReserveContract;

use Modules\Register\Transformers\ReserveContract\ReserveContractTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ReserveContractPresenter.
 *
 * @package namespace App\Presenters;
 */
class ReserveContractPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ReserveContractTransformer();
    }
}
