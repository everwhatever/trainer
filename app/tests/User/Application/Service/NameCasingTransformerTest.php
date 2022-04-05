<?php

declare(strict_types=1);

namespace App\Tests\User\Application\Service;

use App\User\Application\Service\NameCasingTransformer;
use PHPUnit\Framework\TestCase;

class NameCasingTransformerTest extends TestCase
{
    public function testTransformToSnakeCase(): void
    {
        $transformer = new NameCasingTransformer();

        self::assertSame($transformer->transformToSnakeCase(['thisIsCamel' => 12]), ['this_is_camel' => 12]);
    }

    public function testTransformToCamelCase(): void
    {
        $transformer = new NameCasingTransformer();

        self::assertSame($transformer->transformToCamelCase(['this_is_snake_case']), ['thisIsSnakeCase']);
    }
}
