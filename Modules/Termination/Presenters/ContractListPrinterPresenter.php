<?php

namespace Modules\Termination\Presenters;

use Modules\Termination\Transformers\ContractListPrinterTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ContractListPrinterPresenter.
 *
 * @package namespace App\Presenters;
 */
class ContractListPrinterPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ContractListPrinterTransformer();
    }
}
