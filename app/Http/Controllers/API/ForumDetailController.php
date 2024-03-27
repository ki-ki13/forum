<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ForumDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForumDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     *    @OA\Get(
     *       path="/forumd",
     *       tags={"Forum Detail"},
     *       operationId="forumd-index",
     *       summary="Forum Detail - Get All",
     *       description="Mengambil Data Forum Detail",
     *		security={{ "bearerAuth": {} }},
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil mengambil Data Forum Detail",
     *               "data": {
     *                      "id": 1,
     *                      "fd_forum_id": 3,
     *                      "fd_detail": "test lagi coba ya?",
     *                      "fd_user_id": 3,
     *                      "created_at": "2024-03-26T10:41:00.000000Z",
     *                      "updated_at": "2024-03-26T10:42:50.000000Z",
     *                      "forum_detail_user": {
     *                          "id": 3,
     *                          "nama": "Kiki"
     *                      }
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
                $data = ForumDetail::with([
                    'forum_detail_user:id,nama',
                ])->get();
            }
            return response()->json([
                'message' => $message,
                'data' => $data,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in GroupController.store',
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * 	@OA\Post(
     *     	operationId="forumd-store",
     *     	tags={"Forum Detail"},
     *     	summary="Forum Detail - Insert",
     *     	description="Post data Forum Detail",
     *     	path="/forumd",
     *     	security={{"bearerAuth":{}}},
     *    	@OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             example={
     *						"fd_forum_id": 2 ,
     *						"fd_detail": "test lagi?",
     *						"fd_user_id": 3,
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
                'fd_forum_id' => 'required',
                'fd_detail' => 'required',
                'fd_user_id' => 'required',
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
                $data = ForumDetail::create($request->all());
            }
            return response()->json([
                'message' => $message,
                'data' => $data,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in GroupController.store',
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
     *       path="/forumd/{forumd}",
     *       tags={"Forum Detail"},
     *       operationId="forumd-show",
     *       summary="Forum Detail - Get By ID",
     *		security={{ "bearerAuth": {} }},
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="1",
     *       type="string",
     *     ),
     *     description="Masukan Forum Detail ID",
     *     example="1",
     *     in="path",
     *     name="forumd",
     *     required=true,
     *   ),
     *       description="Mengambil Data Forum Detail Berdasarkan Forum Detail ID",
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil mengambil Data Forum Detail",
     *               "data": {    
     *                      "id": 1,
     *                      "fd_forum_id": 3,
     *                      "fd_detail": "test lagi coba ya?",
     *                      "fd_user_id": 3,
     *                      "created_at": "2024-03-26T10:41:00.000000Z",
     *                      "updated_at": "2024-03-26T10:42:50.000000Z",
     *                      "forum_detail_user": {
     *                          "id": 3,
     *                          "nama": "Kiki"
     *                      }
     *                  }
     *          }),
     *      ),
     *  )
     */
    public function show($forumd)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil diambil';
                $data = ForumDetail::with([
                    'forum_detail_user:id,nama',
                ])->where('id', $forumd)->first();
            }
            return response()->json([
                'message' => $message,
                'data' => $data,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in GroupController.store',
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
     *     	operationId="forumd-update",
     *     	tags={"Forum Detail"},
     *     	summary="Forum Detail - Update",
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="1",
     *       type="string",
     *     ),
     *     description="Masukan Forum Detail ID",
     *     example="1",
     *     in="path",
     *     name="forumd",
     *     required=true,
     *   ),
     *     	description="Update data Forum Detail",
     *     	path="/forumd/{forumd}",
     *     	security={{"bearerAuth":{}}},
     *    	@OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             example={
     *                      "fd_forum_id": 3,
     *						"fd_detail": "test lagi ?",
     *						"fd_user_id": 3
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
    public function update(Request $request, $forumd)
    {
        try {
            $validator = Validator::make($request->all(), [
                'fd_forum_id' => 'required',
                'fd_detail' => 'required',
                'fd_user_id' => 'required'
            ]);

            //check if validation fails
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil disimpan';
                $data = ForumDetail::findOrFail($forumd);
                $result = $data->update($request->all());
            }
            return response()->json([
                'message' => $message,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in GroupController.store',
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
     *     	operationId="forumd-destroy",
     *     	tags={"Forum Detail"},
     *     	summary="Forum Detail - Delete",
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="2",
     *       type="string",
     *     ),
     *     description="Masukan Forum Detail ID",
     *     example="2",
     *     in="path",
     *     name="forumd",
     *     required=true,
     *   ),
     *     	description="Delete data Forum Detail",
     *     	path="/forumd/{forumd}",
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
    public function destroy($forumd)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil dihapus';

                $data = ForumDetail::where([
                    ['id', '=', $forumd]
                ])->delete();
            }
            return response()->json([
                'message' => $message,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in GroupController.store',
                'error' => $e->getMessage(),
                'success' => $success
            ], 400);
        }
    }

     /**
     *    @OA\Get(
     *       path="/forumd/{forumd}/forum",
     *       tags={"Forum Detail"},
     *       operationId="getFDbasedForumId",
     *       summary="Forum Detail - Get By Forum ID",
     *		security={{ "bearerAuth": {} }},
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="1",
     *       type="string",
     *     ),
     *     description="Masukan Forum ID",
     *     example="1",
     *     in="path",
     *     name="forumd",
     *     required=true,
     *   ),
     *       description="Mengambil Data Forum Detail Berdasarkan Forum ID",
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil mengambil Data Forum Detail",
     *               "data": {    
     *                      "id": 1,
     *                      "fd_forum_id": 3,
     *                      "fd_detail": "test lagi coba ya?",
     *                      "fd_user_id": 3,
     *                      "created_at": "2024-03-26T10:41:00.000000Z",
     *                      "updated_at": "2024-03-26T10:42:50.000000Z",
     *                      "forum_detail_user": {
     *                          "id": 3,
     *                          "nama": "Kiki"
     *                      }
     *                  }
     *          }),
     *      ),
     *  )
     */
    public function getFDbasedForumId($forumd){
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil diambil';
                $data = ForumDetail::with([
                    'forum_detail_user:id,nama',
                ])->where('fd_forum_id', $forumd)->get();
            }
            return response()->json([
                'message' => $message,
                'data' => $data,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in GroupController.store',
                'error' => $e->getMessage(),
                'success' => $success
            ], 400);
        }
    }

     /**
     *    @OA\Get(
     *       path="/forumd/{user}/user",
     *       tags={"Forum Detail"},
     *       operationId="getFDbasedUserId",
     *       summary="Forum Detail - Get By User ID",
     *		security={{ "bearerAuth": {} }},
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="1",
     *       type="string",
     *     ),
     *     description="Masukan User ID",
     *     example="1",
     *     in="path",
     *     name="user",
     *     required=true,
     *   ),
     *       description="Mengambil Data Forum Detail Berdasarkan User ID",
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil mengambil Data Forum Detail",
     *               "data": {    
     *                      "id": 1,
     *                      "fd_forum_id": 3,
     *                      "fd_detail": "test lagi coba ya?",
     *                      "fd_user_id": 3,
     *                      "created_at": "2024-03-26T10:41:00.000000Z",
     *                      "updated_at": "2024-03-26T10:42:50.000000Z",
     *                      "forum_detail_user": {
     *                          "id": 3,
     *                          "nama": "Kiki"
     *                      }
     *                  }
     *          }),
     *      ),
     *  )
     */

    public function getFDbasedUserId($userid){
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil diambil';
                $data = ForumDetail::with([
                    'forum_detail_user:id,nama',
                ])->where('fd_user_id', $userid)->get();
            }
            return response()->json([
                'message' => $message,
                'data' => $data,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in GroupController.store',
                'error' => $e->getMessage(),
                'success' => $success
            ], 400);
        }
    }

}
