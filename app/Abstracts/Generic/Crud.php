<?php

namespace App\Abstracts\Generic;

use App\Contracts\Generic\Crud as ICrud;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

abstract class Crud implements ICrud
{
    public function create(array $data, $validate = true)
    {
        if ($this->repository) {

            if ($validate) {

                try {

                    $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

                    return $this->repository->create($data);

                } catch (ValidatorException $e) {

                    $errorBag = $e->getMessageBag()->messages();
                    $error = gettype($errorBag) === 'object' ? $errorBag->toArray() : $errorBag;

                    $messages = [];
                    foreach ($error as $key => $err) {
                        $messages[] = $err[0];
                    }

                    return response($messages, 422);
                }
            }

            return $this->repository->create($data);

        } else {

            throw new \Exception("Repository is empty");
        }
    }

    public function update(array $data, $id, $validade = true)
    {
        if ($this->repository) {

            if ($validade) {

                try {
                    $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
                    return $this->repository->update($data, $id);
                } catch (ValidatorException $e) {
                    $errorBag = $e->getMessageBag()->messages();
                    $error = gettype($errorBag) === 'object' ? $errorBag->toArray() : $errorBag;

                    $messages = [];
                    foreach ($error as $key => $err) {
                        $messages[] = $err[0];
                    }

                    return response($messages, 422);
                }

            }

            return $this->repository->update($data, $id);

        } else {

            throw new \Exception("Repository is empty");
        }
    }

    public function find($id, $presenter = null)
    {
        if ($presenter) {
            return $this->repository->skipPresenter(false)->setPresenter($presenter)->find($id);
        }
        return $this->repository->skipPresenter(true)->find($id);
    }

    public function all($paginate = false, $limitPaginate = 100, $presenter = null, array $fields = ['*'])
    {
        if ($paginate and $presenter) {
            return $this->repository->skipPresenter(false)->setPresenter($presenter)->paginate($limitPaginate);
        }
        if ($paginate and !$presenter) {
            return $this->repository->skipPresenter(true)->paginate($limitPaginate);
        }
        if (!$paginate and $presenter) {
            return $this->repository->skipPresenter(false)->setPresenter($presenter)->all($fields);
        }
        if (!$paginate and !$presenter) {
            return $this->repository->skipPresenter(true)->all($fields);
        }
    }

    public function scopeQuery($closure, $paginate = false, $limitPaginate = 100, $presenter = null, array $fields = ['*'])
    {

        if ($paginate and $presenter) {
            return $this->repository->skipPresenter(false)->setPresenter($presenter)->scopeQuery($closure)->paginate($limitPaginate);
        }

        if ($paginate and !$presenter) {
            return $this->repository->skipPresenter(true)->scopeQuery($closure)->paginate($limitPaginate);
        }

        if (!$paginate and $presenter) {
            return $this->repository->skipPresenter(false)->setPresenter($presenter)->scopeQuery($closure)->all($fields);
        }

        if (!$paginate and !$presenter) {
            return $this->repository->skipPresenter(true)->scopeQuery($closure)->all($fields);
        }
    }

    public function delete($id)
    {
        $this->repository->delete($id);
        return [
            'success' => true
        ];
    }

    public function findWhere(array $params, $presenter = null)
    {
        if ($presenter) {
            return $this->repository->skipPresenter(false)->setPresenter($presenter)->findWhere($params);
        }

        if (!$presenter) {
            return $this->repository->skipPresenter(true)->findWhere($params);
        }

    }

    public function findAndDelete(array $params)
    {
        $find = $this->repository->findWhere($params);
        if (count($find)) {
            $this->repository->delete($find[0]['id']);
        }
    }
}