<?php

namespace Modules\Register\Presenters\ReserveContract;

use Modules\Register\Transformers\ReserveContract\ReserveContractListTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ReserveContractListPresenter.
 *
 * @package namespace App\Presenters;
 */
class ReserveContractListPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ReserveContractListTransformer();
    }
}
