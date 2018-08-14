<?php

namespace Modules\Termination\Presenters;

use Modules\Termination\Transformers\ImmobileReleaseTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ImmobileReleasePresenter.
 *
 * @package namespace App\Presenters;
 */
class ImmobileReleasePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ImmobileReleaseTransformer();
    }
}
