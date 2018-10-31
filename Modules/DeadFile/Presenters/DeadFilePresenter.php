<?php

namespace Modules\DeadFile\Presenters;

use Modules\DeadFile\Transformers\DeadFileTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DeadFilePresenter.
 *
 * @package namespace App\Presenters;
 */
class DeadFilePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DeadFileTransformer();
    }
}
