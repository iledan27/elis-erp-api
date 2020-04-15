<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="ElisERP API Documentation",
     *      description="This is Swagger for ElisERP API!",
     *      @OA\Contact(
     *          email="office@iledan.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="ElisERP API",
     * )
     *
     * @OA\SecurityScheme(
     *     securityScheme="authbearer",
     *     name="Authorization",
     *     in="header",
     *     type="http",
     *     description="Authorisation Bearer [Token]",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     *)
     *
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
