<?php

namespace Modules\Financial\Presenters\ContractCelebrated;

use App\Transformers\ContractCelebratedTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ContractCelebratedPresenter.
 *
 * @package namespace App\Presenters;
 */
class ContractCelebratedPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ContractCelebratedTransformer();
    }
}
