<?php

namespace Modules\Register\Presenters\ReserveSendLetter;

use Modules\Register\Transformers\ReserveSendLetter\ReserveSendLetterTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ReserveSendLetterPresenter.
 *
 * @package namespace App\Presenters;
 */
class ReserveSendLetterPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ReserveSendLetterTransformer();
    }
}
