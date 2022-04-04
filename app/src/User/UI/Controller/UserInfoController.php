<?php

declare(strict_types=1);

namespace App\User\UI\Controller;

use App\Shared\UI\Controller\AbstractQueryController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserInfoController extends AbstractQueryController
{
    public function queryAction(Request $request): Response
    {
        return $this->endpointAction($request, 'user_info');
    }
}