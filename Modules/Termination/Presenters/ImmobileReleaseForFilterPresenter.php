<?php

namespace Modules\Termination\Presenters;

use Modules\Termination\Transformers\ImmobileReleaseForFilterTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ImmobileReleaseForFilterPresenter.
 *
 * @package namespace App\Presenters;
 */
class ImmobileReleaseForFilterPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ImmobileReleaseForFilterTransformer();
    }
}
