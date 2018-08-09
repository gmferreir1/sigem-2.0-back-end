<?php

namespace Modules\Termination\Presenters;

use Modules\Termination\Transformers\ContractTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ContractPresenter.
 *
 * @package namespace App\Presenters;
 */
class ContractPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ContractTransformer();
    }
}
