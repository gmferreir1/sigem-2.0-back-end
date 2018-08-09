<?php

namespace Modules\Terminaton\Presenters;

use Modules\Termination\Transformers\ContractListTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ContractListPresenter.
 *
 * @package namespace App\Presenters;
 */
class ContractListPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ContractListTransformer();
    }
}
