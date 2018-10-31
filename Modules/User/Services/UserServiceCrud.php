<?php
/**
 * Created by PhpStorm.
 * User: guilherme
 * Date: 31/07/18
 * Time: 08:38
 */

namespace Modules\User\Services;


use App\Abstracts\Generic\Crud;
use Modules\User\Presenters\UserPresenter;
use Modules\User\Repositories\UserRepository;
use Modules\User\Validators\UserValidator;

class UserServiceCrud extends Crud
{
    /**
     * @var UserRepository
     */
    protected $repository;
    /**
     * @var UserValidator
     */
    protected $validator;

    public function __construct(UserRepository $repository, UserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function getAll()
    {
        $closure = function ($query) {
            return $query->orderBy('name', 'ASC');
        };

        return parent::scopeQuery($closure, false, 0, UserPresenter::class);
    }
}