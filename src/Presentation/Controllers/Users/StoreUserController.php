<?php

namespace App\Presentation\Controllers\Users;

use App\Core\Requests\Request;
use App\Core\Responses\Response;
use App\Core\Utils\Failures\Failure;
use App\Core\Utils\Failures\NotFoundFailure;
use App\Core\Utils\Failures\ServerFailure;
use App\Data\UseCases\Users\StoreUserUseCase;

class StoreUserController
{
    private StoreUserUseCase $storeUserUseCase;

    public function __construct(StoreUserUseCase $storeUserUseCase)
    {
        $this->storeUserUseCase = $storeUserUseCase;
    }

    public function execute(Request $request, Response $response)
    {

        $body = $request->body;

        $useCaseResult = $this->storeUserUseCase->execute($body["firstName"], $body["lastName"], $body["email"], $body["password"]);

        if ($useCaseResult instanceof Failure) {
            $response->setStatusCode($useCaseResult->getStatusCode());
            if ($useCaseResult instanceof NotFoundFailure) {
                $response->renderView("_404", ["fatalError" => $useCaseResult->getRaw()]);
            } else if ($useCaseResult instanceof ServerFailure) {
                $response->renderView("_500", ["fatalError" => $useCaseResult->getRaw()]);
            }
        } else {
            $response->renderView("showUserView", ["user" => $useCaseResult]);
        }
    }
}