<?php

declare(strict_types=1);

namespace App\Blog\Application\Service;

class UserInfoApiGetter
{
    public function __construct(private string $localhostAddress, private string $graphqlUserInfoAddress)
    {
    }

    public function getUserInfoById(array $userIds, string $requireFields): array
    {
        $endpoint = $this->localhostAddress.$this->graphqlUserInfoAddress;
        $endpoint = 'http://192.168.68.110:8080/graphql/user/info/query';
        $options = $this->prepareQuery($userIds, $requireFields);

        $context = stream_context_create($options);
        $result = file_get_contents($endpoint, false, $context);

        $result = json_decode($result, true, 512, JSON_THROW_ON_ERROR);

        return $result['data']['byId'] ?? [];
    }

    private function prepareQuery(array $userIds, string $requireFields): array
    {
        $query = 'query {byId(userIds: '.json_encode($userIds, JSON_THROW_ON_ERROR).'){'.$requireFields.'}}';
        $data = ['query' => $query];
        $data = json_encode($data, JSON_THROW_ON_ERROR);

        return [
            'http' => [
                'header' => 'Accept: application/json'."\r\n".
                    'Content-Length: '.strlen($data)."\r\n".
                    'Content-Type: application/json'."\r\n",
                'content' => $data,
            ],
       ];
    }
}
