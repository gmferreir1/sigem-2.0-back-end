<?php

namespace Modules\ImmobileCaptured\Presenters\ReportList;

use Modules\ImmobileCaptured\Transformers\ReportList\ReportListTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ReportListPresenter.
 *
 * @package namespace App\Presenters;
 */
class ReportListPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ReportListTransformer();
    }
}
