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

    public function getUserInfoById(array $userIds, string $requireFields): array
    {
        $endpoint = $this->localhostAddress.$this->graphqlUserInfoAddress;
        $endpoint = 'http://192.168.68.110:8080/graphql/user/info/query';
        $options = $this->prepareQuery($userIds, $requireFields);

        $context = stream_context_create($options);
        $result = file_get_contents($endpoint, false, $context);

        $result = json_decode($result, true);

        return $result['data']['byId'] ?? [];
    }

    private function prepareQuery(array $userIds, string $requireFields): array
    {
        $query = 'query {byId(userIds: '.json_encode($userIds).'){'.$requireFields.'}}';
        $data = ['query' => $query];
        $data = json_encode($data);

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
