<?php

namespace Modules\ManagerAction\Presenters;

use Modules\ManagerAction\Transformers\ActionDatabaseTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ActionDatabasePresenter.
 *
 * @package namespace App\Presenters;
 */
class ActionDatabasePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ActionDatabaseTransformer();
    }
}
