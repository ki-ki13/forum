<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     *    @OA\Get(
     *       path="/group",
     *       tags={"Group"},
     *       operationId="group-index",
     *       summary="Group - Get All",
     *       description="Mengambil Data Group",
     *		security={{ "bearerAuth": {} }},
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil mengambil Data Group",
     *               "data": {
     *                   {
     *						"id": "1",
     *						"g_nama": "test group",
     *						"g_tipe": "public",
     *						"g_status": "aktif"
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
                $data = Group::all();
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
     *     	operationId="group-store",
     *     	tags={"Group"},
     *     	summary="Group - Insert",
     *     	description="Post data Group",
     *     	path="/group",
     *     	security={{"bearerAuth":{}}},
     *    	@OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             example={
     *						"g_nama": "test group",
     *						"g_tipe": "public",
     *						"g_status": "aktif"
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
                'g_nama' => 'required',
                'g_tipe' => 'required',
                'g_status' => 'required',
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
                $data = Group::create($request->all());
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
     *       path="/group/{group}",
     *       tags={"Group"},
     *       operationId="group-show",
     *       summary="Group - Get By ID",
     *		security={{ "bearerAuth": {} }},
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="3",
     *       type="string",
     *     ),
     *     description="Masukan Group ID",
     *     example="1",
     *     in="path",
     *     name="group",
     *     required=true,
     *   ),
     *       description="Mengambil Data Group Berdasarkan Group ID",
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil mengambil Data Group",
     *               "data": {
     *                   {
     *						"g_nama": "test group",
     *						"g_tipe": "public",
     *						"g_status": "aktif"
     *					}
     *              }
     *          }),
     *      ),
     *  )
     */
    public function show($group)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil diambil';
                $data = Group::where('id', $group)->first();
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
    public function edit(string $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * 	@OA\Put(
     *     	operationId="group-update",
     *     	tags={"Group"},
     *     	summary="Group - Update",
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="1",
     *       type="string",
     *     ),
     *     description="Masukan Group ID",
     *     example="1",
     *     in="path",
     *     name="group",
     *     required=true,
     *   ),
     *     	description="Update data Group",
     *     	path="/group/{group}",
     *     	security={{"bearerAuth":{}}},
     *    	@OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             example={
     *						"g_nama": "test group",
     *						"g_tipe": "public",
     *						"g_status": "non aktif"
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
    public function update(Request $request, $group)
    {
        try {
            $validator = Validator::make($request->all(), [
                'g_nama' => 'required',
                'g_tipe' => 'required',
                'g_status' => 'required',
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
                $result = Group::where('id', $group)->update($request->all());
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
     *     	operationId="group-destroy",
     *     	tags={"Group"},
     *     	summary="Group - Delete",
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="2",
     *       type="string",
     *     ),
     *     description="Masukan Group ID",
     *     example="2",
     *     in="path",
     *     name="group",
     *     required=true,
     *   ),
     *     	description="Delete data Group",
     *     	path="/group/{group}",
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
    public function destroy($group)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil dihapus';

                $data = Group::where([
                    ['id', '=', $group]
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
     *       path="/group-aktif",
     *       tags={"Group"},
     *       operationId="getAktifGroup",
     *       summary="Group - Get Aktif Group",
     *       description="Mengambil Data Group Aktif",
     *		security={{ "bearerAuth": {} }},
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil mengambil Data Group",
     *               "data": {
     *                   {
     *						"id": "1",
     *						"g_nama": "test group",
     *						"g_tipe": "public",
     *						"g_status": "aktif"
     *					}
     *              }
     *          }),
     *      ),
     *  )
     */
    
     public function getAktifGroup()
     {
         try {
             $token = request()->bearerToken();
             $success = false;
             $message = "Authorization Failed";
             $data = null;
 
             if ($this->checkToken($token)) {
                 $success = true;
                 $message = 'Data berhasil diambil';
                 $data = Group::where('g_status', 'aktif')->get();
             }
             return response()->json([
                 'message' => $message,
                 'data' => $data,
                 'success'=>$success
             ]);
         } catch (\Exception $e) {
             return response()->json([
                 'message' => 'Something went wrong in GroupController.getAktifGroup',
                 'error' => $e->getMessage(),
                 'success' => $success
             ], 400);
         }
     }

    /**
     *    @OA\Get(
     *       path="/group/{group}/member",
     *       tags={"Group"},
     *       operationId="getGroupMember",
     *       summary="Group - Get Member",
     *		security={{ "bearerAuth": {} }},
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="3",
     *       type="string",
     *     ),
     *     description="Masukan Group ID",
     *     example="1",
     *     in="path",
     *     name="group",
     *     required=true,
     *   ),
     *       description="Mengambil Data Member Berdasarkan Group ID",
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil mengambil Data Member",
     *               "data": {
     *                   {
     *						"id": "1",
     *						"nama": "Kiki",
     *						"alamat": "Pemalang",
     *						"no_telp": "087723977966",
     *						"jenis_kelamin": "Perempuan",
     *					}
     *              }
     *          }),
     *      ),
     *  )
     */
    public function getGroupMember($group)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil diambil';
                $data = User::where('group_id', $group)->select('id', 'nama', 'no_telp', 'alamat', 'jenis_kelamin')->get();
            }
            return response()->json([
                'message' => $message,
                'data' => $data,
                'success'=>$success
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in GroupController.getGroupMember',
                'error' => $e->getMessage(),
                'success' => $success
            ], 400);
        }
    }
}
