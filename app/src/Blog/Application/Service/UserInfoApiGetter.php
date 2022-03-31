<?php

declare(strict_types=1);

namespace App\Blog\Application\Service;

class UserInfoApiGetter
{
    private string $localhostAddress;

    private string $graphqlUserInfoAddress;

    public function __construct(string $localhostAddress, string $graphqlUserInfoAddress)
    {
        $this->localhostAddress = $localhostAddress;
        $this->graphqlUserInfoAddress = $graphqlUserInfoAddress;
    }

    public function getUserInfoById(int $userId, string $requireFields): array
    {
        $endpoint = $this->localhostAddress . $this->graphqlUserInfoAddress;
        $options = $this->prepareQuery($userId, $requireFields);

        $context  = stream_context_create($options);
        $result = file_get_contents($endpoint, false, $context);

        $result = json_decode($result, true);

        return $result['data']['byId'] ?? [];
    }

    private function prepareQuery(int $userId, string $requireFields): array
    {
        $query = "query {byId(userId: " . $userId . "){" . $requireFields . "}}";
        $data = ['query' => $query];
        $data = json_encode($data);
        return [
            'http' => [
                'header' => 'Accept: application/json' . "\r\n" .
                    "Content-Length: " . strlen($data) . "\r\n" .
                    'Content-Type: application/json' . "\r\n",
                'content' => $data
            ]
       ];
    }
}
