<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     *    @OA\Get(
     *       path="/user",
     *       tags={"User"},
     *       operationId="index",
     *       summary="User - Get All",
     *       description="Mengambil Data User",
     *		security={{ "bearerAuth": {} }},
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil mengambil Data User",
     *               "data": {
     *                   {
     *						"id": "1",
     *						"username": "admin",
     *						"password": "admin",
     *						"nama": "Admin",
     *						"alamat": "Pemalang",
     *						"no_telp": "087723977966",
     *						"jenis_kelamin": "Perempuan",
     *						"role": "Admin"
     *					}
     *              }
     *          }),
     *      ),
     *  )
     */
    public function index()
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil diambil';
                $data = User::all();
            }
            return response()->json([
                'message' => $message,
                'data' => $data,
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * 	@OA\Post(
     *     	operationId="store",
     *     	tags={"User"},
     *     	summary="User - Insert",
     *     	description="Post data User",
     *     	path="/user",
     *     	security={{"bearerAuth":{}}},
     *    	@OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             example={
     *						"username": "kiki",
     *						"password": "password",
     *						"nama": "Kiki",
     *						"alamat": "Pemalang",
     *						"no_telp": "08722729109",
     *						"jenis_kelamin": "Perempuan",
     *						"role": "user"
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
    public function store(Request $request)
    {
        try {
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

            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil disimpan';
                $token = $this->createToken();
                $data = User::create(array_merge($request->all(), ['api_token' => $token,'token_type'=>'Bearer']));
            }
            return response()->json([
                'message' => $message,
                'data' => $data,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in UserController.store',
                'error' => $e->getMessage(),
                'success' => $success
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */

    /**
     *    @OA\Get(
     *       path="/user/{user}",
     *       tags={"User"},
     *       operationId="show",
     *       summary="User - Get By ID",
     *		security={{ "bearerAuth": {} }},
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="3",
     *       type="string",
     *     ),
     *     description="Masukan User ID",
     *     example="3",
     *     in="path",
     *     name="user",
     *     required=true,
     *   ),
     *       description="Mengambil Data User Berdasarkan User ID",
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil mengambil Data User",
     *               "data": {
     *                   {
     *						"id": "1",
     *						"username": "admin",
     *						"password": "admin",
     *						"nama": "Admin",
     *						"alamat": "Pemalang",
     *						"no_telp": "087723977966",
     *						"jenis_kelamin": "Perempuan",
     *						"role": "Admin",
     *                       "api_token":"lalalala",
     *                       "token_type":"Bearer"
     *					}
     *              }
     *          }),
     *      ),
     *  )
     */
    public function show($user)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil diambil';
                $data = User::where('id', $user)->first();
            }
            return response()->json([
                'message' => $message,
                'data' => $data,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in UserController.show',
                'error' => $e->getMessage(),
                'success' => $success
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * 	@OA\Put(
     *     	operationId="update",
     *     	tags={"User"},
     *     	summary="User - Update",
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="3",
     *       type="string",
     *     ),
     *     description="Masukan User ID",
     *     example="1",
     *     in="path",
     *     name="user",
     *     required=true,
     *   ),
     *     	description="Update data User",
     *     	path="/user/{user}",
     *     	security={{"bearerAuth":{}}},
     *    	@OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             example={
     *						"username": "kiki",
     *						"nama": "Kiki",
     *						"alamat": "Pemalang",
     *						"no_telp": "08772383920",
     *						"jenis_kelamin": "Perempuan",
     *                      "group_id":3,
     *						"role": "User"
     *             },
     *         ),
     *     	),
     *       @OA\Response(
     *           response="201",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *				"success": true,
     *				"message": "Data berhasil diubah"
     *			}),
     *      ),
     * 	)
     *
     *
     */
    public function update(Request $request, $user)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required',
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

            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil disimpan';
                $result = User::where('id', $user)->update($request->all());
            }
            return response()->json([
                'message' => $message,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in UserController.update',
                'error' => $e->getMessage(),
                'success' => $success
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * 	@OA\Delete(
     *     	operationId="destroy",
     *     	tags={"User"},
     *     	summary="User - Delete",
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="3",
     *       type="string",
     *     ),
     *     description="Masukan User ID",
     *     example="2",
     *     in="path",
     *     name="user",
     *     required=true,
     *   ),
     *     	description="Delete data User",
     *     	path="/user/{user}",
     *     	security={{"bearerAuth":{}}},
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *				"success": true,
     *				"message": "Data berhasil dihapus"
     *			}),
     *      ),
     * 	)
     *
     *
     */
    public function destroy($user)
    {
        try {

            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil dihapus';

                $data = User::where([
                    ['id', '=', $user]
                ])->delete();
            }
            return response()->json([
                'message' => $message,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in UserController.destroy',
                'error' => $e->getMessage(),
                'success' => $success
            ], 400);
        }
    }

     /**
     * Update the specified resource in storage.
     */
    /**
     * 	@OA\Put(
     *     	operationId="updateGroupId",
     *     	tags={"User"},
     *     	summary="User - Update Group Id",
     *     	description="Update data User",
     *     	path="/user-group",
     *     	security={{"bearerAuth":{}}},
     *    	@OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             example={
     *						"username": "kiki",
     *                      "group_id":3,
     *             },
     *         ),
     *     	),
     *       @OA\Response(
     *           response="201",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *				"success": true,
     *				"message": "Data berhasil diubah"
     *			}),
     *      ),
     * 	)
     *
     *
     */
    public function updateGroupId(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required',
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
                $message = 'Data berhasil disimpan';
                $user= $request->username;
                $result = User::where('username', $user)->update(['group_id' => $request->group_id]);
            }
            return response()->json([
                'message' => $message,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in UserController.updateGroupId',
                'error' => $e->getMessage(),
                'success' => $success
            ], 400);
        }
    }
}
