<?php

namespace Modules\SystemGoal\Presenters;

use Modules\SystemGoal\Transformers\SystemGoalTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SystemGoalPresenter.
 *
 * @package namespace App\Presenters;
 */
class SystemGoalPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SystemGoalTransformer();
    }
}
