<?php

declare(strict_types=1);

namespace App\User\UI\Controller;

use App\Shared\UI\Controller\AbstractQueryController;
use Symfony\Component\HttpFoundation\Request;

class UserInfoController extends AbstractQueryController
{
    public function queryAction(Request $request)
    {
        $response = $this->endpointAction($request, 'user_info');

        return $response;
    }
}