<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class PasswordChange extends Controller
{
    /**
     * 	@OA\Put(
     *     	operationId="updatePassword",
     *     	tags={"User"},
     *     	summary="User - Change Password",
     *     	description="Change Password",
     *     	path="/changepassword",
     *     	security={{"bearerAuth":{}}},
     *    	@OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             example={
     *						"username": "admin",
     *						"password": "123"
     *             },
     *         ),
     *     	),
     *       @OA\Response(
     *           response="201",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *				"success": true,
     *				"message": "Password berhasil diubah"
     *			}),
     *      ),
     * 	)
     *
     *
     */
    function updatePassword(Request $request)
    {
        try {
            //define validation rules
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required'
            ]);

            //check if validation fails
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil diubah';

                $data = array(
                    "username" => $request->input("username"),
                    "password" => $request->input("password")
                );

                $id = $request->input("username");
                $data = User::where([
                    ['username', '=', $id]
                ])->update($data);
            }
            return response()->json([
                'message' => $message,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in UserController.index',
                'error' => $e->getMessage(),
                'success' => $success
            ], 400);
        }
    }
}
