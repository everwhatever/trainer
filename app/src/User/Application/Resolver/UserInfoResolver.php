<?php

declare(strict_types=1);

namespace App\User\Application\Resolver;

use App\User\Application\Service\NameCasingTransformer;
use App\User\Infrastructure\Repository\UserRepository;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

class UserInfoResolver implements QueryInterface
{
    public function __construct(private readonly UserRepository $userRepository, private readonly NameCasingTransformer $casingTransformer)
    {
    }

    public function __invoke(array $arguments, ResolveInfo $info): array
    {
        if (!isset($arguments[0]['userIds'])) {
            return [];
        }
        $userIds = $arguments[0]['userIds'];
        $selectedFields = $this->casingTransformer->transformToCamelCase(array_keys($info->getFieldSelection()));

        return $this->casingTransformer->transformToSnakeCase($this->userRepository->getUserInfo($userIds, $selectedFields));
    }
}
