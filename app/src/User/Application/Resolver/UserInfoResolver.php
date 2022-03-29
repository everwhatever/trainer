<?php

declare(strict_types=1);

namespace App\User\Application\Resolver;

use App\User\Infrastructure\Repository\UserRepository;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

class UserInfoResolver implements QueryInterface
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(array $arguments, ResolveInfo $info): array
    {
        if (!isset($arguments[0]['userId'])) {
            return [];
        }
        $userId = $arguments[0]['userId'];
        $selectedFields = $this->camelize(array_keys($info->getFieldSelection()));

        return $this->transformToSnakeCase($this->userRepository->getUserInfo($userId, $selectedFields));
    }

    private function camelize(array $arrayKeys): array
    {
        $camelizeKeys = [];
        foreach ($arrayKeys as $key) {
             $camelizeKeys[] = str_replace('_', '', lcfirst(ucwords($key, '_')));
        }

        return $camelizeKeys;
    }

    private function transformToSnakeCase(array $result): array
    {
        $snakeCaseResult = [];
        foreach ($result as $key => $value) {
            $snakeCaseKey = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $key));
            $snakeCaseResult[$snakeCaseKey] = $value;
        }

        return $snakeCaseResult;
    }
}