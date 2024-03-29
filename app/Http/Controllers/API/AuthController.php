<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
	 * 	@OA\Post(
	 *     	operationId="checkLogin",
	 *     	tags={"Authentication"},
	 *     	summary="Authentication - Check Login",
	 *     	description="Authentication User",
	 *     	path="/auth/checkLogin",
	 *     	security={{"bearerAuth":{}}},
	 *    	@OA\RequestBody(
	 *         required=true,
	 *         description="Request Body Description",
	 *         @OA\JsonContent(
	 *             example={
	 *						"username": "admin",
	 *						"password": "admin"
	 *             },
	 *         ),
	 *     	),
	 *       @OA\Response(
	 *           response="201",
	 *           description="Ok",
	 *           @OA\JsonContent
	 *           (example={
	 *				"success": true,
	 *				"message": "Berhasil Login",
	 *               "data": {
	 *                   {
	 *						"username": "admin",
	 *						"nama": "Admin",
	 *						"role": "Admin",
	 *					}
	 *				}
	 *			}),
	 *      ),
	 * 	)
	 *
	 *
	 */
	public function checkLogin(Request $request)
	{
		date_default_timezone_set('Asia/Jakarta');

		//define validation rules
		$validator = Validator::make($request->all(), [
			'username' => 'required',
			'password' => 'required',
		]);

		//check if validation fails
		if ($validator->fails()) {
			return response()->json($validator->errors(), 422);
		}

		$username = $request->input("username");
		$password = $request->input("password");

		// update token
		$token = $this->createToken();

		$data_update = array(
			"api_token" => $token,
		);

		$result_update = User::where([
			['username', '=', $username],
			['password', '=', $password]
		])->update($data_update);

		$result = true;
		$message = "";

		if ($result_update != null) {
			$data = User::where([
					['username', '=', $username],
					['password', '=', $password]
				])->get();


			if (!$data->isEmpty()) {
				$result = true;
				$message = "Login berhasil";
			} else {
				$result = false;
				$message = "Username atau password salah";
				$data = null;
			}
		} else {
			$result = false;
			$message = "Gagal create token";
			$data = null;
		}

		return response()->json([
			'success' => $result,
			'message' => $message,
			'data'    => $data
		], 201);
	}

	/**
	* 	@OA\Post(
	*     	operationId="register",
	*     	tags={"Authentication"},
	*     	summary="Authentication - Register",
	*     	description="Post data Register",
	*     	path="/auth/register",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
	*						"username": "admin",
	*						"password": "admin",
	*						"nama": "Admin",
	*						"alamat": "Pemalang",
	*						"no_telp": "087723977966",
	*						"jenis_kelamin": "Perempuan",
	*						"role": "Admin"
    *             },
    *         ),
    *     	),
	*       @OA\Response(
    *           response="201",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
	*				"success": true,
	*				"message": "Data berhasil disimpan"
	*			}),
    *      ),
	 * 	)
	 *
	*
	*/
	public function register(Request $request) {
		
		//define validation rules
        $validator = Validator::make($request->all(), [
			'username' => 'required',
			'password' => 'required',
			'nama' => 'required',
			'alamat' => 'required',
			'no_telp' => 'required',
			'jenis_kelamin' => 'required',
			'role' => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $token = $this->createToken();
		$success = true;
		$message = 'Data berhasil disimpan';
		$result = User::create(array_merge($request->all(), ['api_token' => $token,'token_type'=>'Bearer']));
		
		//make response JSON
		return response()->json([
			'success' => $success,
			'message' => $message,
			'data'    => $result  
		], 201);
    }
	
	public function checkUserToken(Request $request){
		$status = true;
		$token = User::where('user_id',$request->input('user_id'))->value('api_token');
		if($request->input('api_token')!=$token){
			$status = false;
		}
		return response()->json([
			'data'    => $status  
		], 201);
	}

}
