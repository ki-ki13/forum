<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
/**
* @OA\Info(
*      version="1.0.0",
*      title="Dokumentasi API",
*      description="API Forum App",
*      @OA\Contact(
*          email="rizkimahjati845@gmail.com"
*      ),
*      @OA\License(
*          name="Apache 2.0",
*          url="http://www.apache.org/licenses/LICENSE-2.0.html"
*      )
* )
*
* @OA\SecurityScheme(
*         securityScheme="bearerAuth",
*         type="http",
*         scheme="bearer",
*         description="Enter token"
*  )
*
* @OA\Server(
*      url=L5_SWAGGER_CONST_HOST,
*      description="API Forum App"
* )
*/

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function checkToken($token) {
		
		if ($token == null) $token = '';
		$data = User::where([
				['api_token', '=', $token]
			])->get();
		$result = false;
		if (!$data->isEmpty()) {
			$result = true;
		}
		return $result;
	}
    public function createToken(): string
	{
		return hash('sha256', Str::random(20) . strtotime('now'));
	}

}
