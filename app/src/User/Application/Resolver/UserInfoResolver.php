<?php

declare(strict_types=1);

namespace App\User\Application\Resolver;

use App\User\Application\Service\NameCasingTransformer;
use App\User\Infrastructure\Repository\UserRepository;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

class UserInfoResolver implements QueryInterface
{
    private UserRepository $userRepository;
    private NameCasingTransformer $casingTransformer;

    public function __construct(UserRepository $userRepository, NameCasingTransformer $casingTransformer)
    {
        $this->userRepository = $userRepository;
        $this->casingTransformer = $casingTransformer;
    }

    public function __invoke(array $arguments, ResolveInfo $info): array
    {
        if (!isset($arguments[0]['userId'])) {
            return [];
        }
        $userId = $arguments[0]['userId'];
        $selectedFields = $this->casingTransformer->transformToCamelCase(array_keys($info->getFieldSelection()));

        return $this->casingTransformer->transformToSnakeCase($this->userRepository->getUserInfo($userId, $selectedFields));
    }
}