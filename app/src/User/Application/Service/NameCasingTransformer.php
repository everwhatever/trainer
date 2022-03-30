<?php

declare(strict_types=1);

namespace App\User\Application\Service;

class NameCasingTransformer
{
    public function transformToCamelCase(array $arrayKeys, string $separator = '_'): array
    {
        $camelizeKeys = [];
        foreach ($arrayKeys as $key) {
            $camelizeKeys[] = str_replace($separator, '', lcfirst(ucwords($key, $separator)));
        }

        return $camelizeKeys;
    }

    public function transformToSnakeCase(array $result): array
    {
        $snakeCaseResult = [];
        foreach ($result as $key => $value) {
            $snakeCaseKey = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $key));
            $snakeCaseResult[$snakeCaseKey] = $value;
        }

        return $snakeCaseResult;
    }
}
