<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ForumDetail;
use App\Models\ForumQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForumQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     *    @OA\Get(
     *       path="/forumq",
     *       tags={"Forum Question"},
     *       operationId="forumq-index",
     *       summary="Forum Question - Get All",
     *       description="Mengambil Data Forum Question",
     *		security={{ "bearerAuth": {} }},
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil mengambil Data Forum Question",
     *               "data": {
     *                   {
     *						 *                      "id": 6,
     *                      "fq_question": "coba aja?",
     *                      "fq_group_id": 3,
     *                      "fq_created_by": 3,
     *                      "fq_updated_by": 5,
     *                      "created_at": "2024-03-26T06:58:15.000000Z",
     *                      "updated_at": "2024-03-26T07:07:04.000000Z",
     *                      "categories": {
     *                      {
     *                          "id": 1,
     *                          "c_nama": "Algoritma Pemrograman Komputer",
     *                          "c_created_by": 1,
     *                          "created_at": "2024-03-24T16:19:38.000000Z",
     *                          "updated_at": "2024-03-24T16:24:05.000000Z",
     *                          "pivot": {
     *                              "fc_forum_id": 6,
     *                              "fc_category_id": 1
     *                           }
     *                      }
     *                      },
     *                      "forum_user": {
     *                          "id": 3,
     *                          "nama": "Kiki"
     *                          },
     *                      "forum_user_update": {
     *                          "id": 5,
     *                          "nama": "Putin"
     *                      },
     *                      "forum_group": null
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
                $data = ForumQuestion::with([
                    'categories',
                    'forum_user:id,nama',
                    'forum_user_update:id,nama',
                    'forum_group:id,g_nama'
                ])->withCount('forum_detail')->get();
            }
            return response()->json([
                'message' => $message,
                'success' => $success,
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ForumController.index',
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
     *     	operationId="forumq-store",
     *     	tags={"Forum Question"},
     *     	summary="Forum Question - Insert",
     *     	description="Post data Forum Question",
     *     	path="/forumq",
     *     	security={{"bearerAuth":{}}},
     *    	@OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             example={
     *						"fc_category_id": "[1,2]",
     *						"fq_question": "test?",
     *						"fq_group_id": 2,
     *                      "fq_created_by":2,
     *                      "fq_updated_by":2
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
                'fc_category_id' => 'required',
                'fq_question' => 'required',
                'fq_created_by' => 'required',
                'fq_updated_by' => 'required',
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
                $categories = json_decode($request->fc_category_id);
                $data = ForumQuestion::create([
                    'fq_group_id' => $request->fq_group_id,
                    'fq_question' => $request->fq_question,
                    'fq_created_by' => $request->fq_created_by,
                    'fq_updated_by' => $request->fq_updated_by,
                ]);
                $data->categories()->attach($categories);
            }
            return response()->json([
                'message' => $message,
                'data' => $data,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ForumController.store',
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
     *       path="/forumq/{forumq}",
     *       tags={"Forum Question"},
     *       operationId="forumq-show",
     *       summary="Forum Question - Get By ID",
     *		security={{ "bearerAuth": {} }},
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="3",
     *       type="string",
     *     ),
     *     description="Masukan Forum Question ID",
     *     example="1",
     *     in="path",
     *     name="forumq",
     *     required=true,
     *   ),
     *       description="Mengambil Data Forum Question Berdasarkan Forum Question ID",
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil mengambil Data Forum Question",
     *               "data": {
     *                   {
     *                      "id": 6,
     *                      "fq_question": "coba aja?",
     *                      "fq_group_id": 3,
     *                      "fq_created_by": 3,
     *                      "fq_updated_by": 5,
     *                      "created_at": "2024-03-26T06:58:15.000000Z",
     *                      "updated_at": "2024-03-26T07:07:04.000000Z",
     *                      "categories": {
     *                      {
     *                          "id": 1,
     *                          "c_nama": "Algoritma Pemrograman Komputer",
     *                          "c_created_by": 1,
     *                          "created_at": "2024-03-24T16:19:38.000000Z",
     *                          "updated_at": "2024-03-24T16:24:05.000000Z",
     *                          "pivot": {
     *                              "fc_forum_id": 6,
     *                              "fc_category_id": 1
     *                           }
     *                      }
     *                      },
     *                      "forum_user": {
     *                          "id": 3,
     *                          "nama": "Kiki"
     *                          },
     *                      "forum_user_update": {
     *                          "id": 5,
     *                          "nama": "Putin"
     *                      },
     *                      "forum_group": null
     *				}
     *              }
     *          }),
     *      ),
     *  )
     */
    public function show($forumq)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil diambil';
                $data = ForumQuestion::with([
                    'categories',
                    'forum_user:id,nama',
                    'forum_user_update:id,nama',
                    'forum_group:id,g_nama',
                    'forum_detail',
                    'forum_detail.forum_detail_user:id,nama'
                ])->where('id', $forumq)->first();
            }
            return response()->json([
                'message' => $message,
                'data' => $data,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ForumController.show',
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
     *     	operationId="forumq-update",
     *     	tags={"Forum Question"},
     *     	summary="Forum Question - Update",
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="1",
     *       type="string",
     *     ),
     *     description="Masukan Forum Question ID",
     *     example="1",
     *     in="path",
     *     name="forumq",
     *     required=true,
     *   ),
     *     	description="Update data Forum Question",
     *     	path="/forumq/{forumq}",
     *     	security={{"bearerAuth":{}}},
     *    	@OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             example={
     *                      "fc_category_id": "[1,2]",
     *						"fq_question": "test ?",
     *						"fq_updated_by": 2
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
    public function update(Request $request, $forumq)
    {
        try {
            $validator = Validator::make($request->all(), [
                'fq_question' => 'required',
                'fq_updated_by' => 'required',
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
                $data = ForumQuestion::findOrFail($forumq);
                $categories = json_decode($request->fc_category_id);
                $result = $data->update($request->all());
                $data->categories()->sync($categories);
            }
            return response()->json([
                'message' => $message,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ForumController.update',
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
     *     	operationId="forumq-destroy",
     *     	tags={"Forum Question"},
     *     	summary="Forum Question - Delete",
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="2",
     *       type="string",
     *     ),
     *     description="Masukan Forum Question ID",
     *     example="2",
     *     in="path",
     *     name="forumq",
     *     required=true,
     *   ),
     *     	description="Delete data Forum Question",
     *     	path="/forumq/{forumq}",
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
    public function destroy($forumq)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil dihapus';

                $data = ForumQuestion::where([
                    ['id', '=', $forumq]
                ])->delete();
            }
            return response()->json([
                'message' => $message,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ForumController.destroy',
                'error' => $e->getMessage(),
                'success' => $success
            ], 400);
        }
    }

    /**
     *    @OA\Get(
     *       path="/forumq/{user}/user",
     *       tags={"Forum Question"},
     *       operationId="getFQBasedUserId",
     *       summary="Forum Question - Get By User ID",
     *		security={{ "bearerAuth": {} }},
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
     *       description="Mengambil Data Forum Question Berdasarkan User ID",
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil mengambil Data Forum Question",
     *               "data": {
     *                   {
     *                      "id": 6,
     *                      "fq_question": "coba aja?",
     *                      "fq_group_id": 3,
     *                      "fq_created_by": 3,
     *                      "fq_updated_by": 5,
     *                      "created_at": "2024-03-26T06:58:15.000000Z",
     *                      "updated_at": "2024-03-26T07:07:04.000000Z",
     *                      "categories": {
     *                      {
     *                          "id": 1,
     *                          "c_nama": "Algoritma Pemrograman Komputer",
     *                          "c_created_by": 1,
     *                          "created_at": "2024-03-24T16:19:38.000000Z",
     *                          "updated_at": "2024-03-24T16:24:05.000000Z",
     *                          "pivot": {
     *                              "fc_forum_id": 6,
     *                              "fc_category_id": 1
     *                           }
     *                      }
     *                      },
     *                      "forum_user": {
     *                          "id": 3,
     *                          "nama": "Kiki"
     *                          },
     *                      "forum_user_update": {
     *                          "id": 5,
     *                          "nama": "Putin"
     *                      },
     *                      "forum_group": null
     *				}
     *              }
     *          }),
     *      ),
     *  )
     */
    public function getFQBasedUserId($userid)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;
            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil diambil';

                $data = ForumQuestion::with([
                    'categories',
                    'forum_user:id,nama',
                    'forum_user_update:id,nama',
                    'forum_group:id,g_nama'
                ])->where('fq_created_by', '=', $userid)->withCount('forum_detail')->get();
            }
            return response()->json([
                'message' => $message,
                'success' => $success,
                'data'=>$data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ForumController.getFQBasedUserId',
                'error' => $e->getMessage(),
                'success' => $success
            ], 400);
        }
    }

    /**
     *    @OA\Get(
     *       path="/forumq/{group}/group",
     *       tags={"Forum Question"},
     *       operationId="getFQBasedGroupId",
     *       summary="Forum Question - Get By Group ID",
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
     *       description="Mengambil Data Forum Question Berdasarkan Group ID",
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil mengambil Data Forum Question",
     *               "data": {
     *                   {
     *                      "id": 6,
     *                      "fq_question": "coba aja?",
     *                      "fq_group_id": 3,
     *                      "fq_created_by": 3,
     *                      "fq_updated_by": 5,
     *                      "created_at": "2024-03-26T06:58:15.000000Z",
     *                      "updated_at": "2024-03-26T07:07:04.000000Z",
     *                      "categories": {
     *                      {
     *                          "id": 1,
     *                          "c_nama": "Algoritma Pemrograman Komputer",
     *                          "c_created_by": 1,
     *                          "created_at": "2024-03-24T16:19:38.000000Z",
     *                          "updated_at": "2024-03-24T16:24:05.000000Z",
     *                          "pivot": {
     *                              "fc_forum_id": 6,
     *                              "fc_category_id": 1
     *                           }
     *                      }
     *                      },
     *                      "forum_user": {
     *                          "id": 3,
     *                          "nama": "Kiki"
     *                          },
     *                      "forum_user_update": {
     *                          "id": 5,
     *                          "nama": "Putin"
     *                      },
     *                      "forum_group": null
     *				}
     *              }
     *          }),
     *      ),
     *  )
     */
    public function getFQBasedGroupId($groupid)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;
            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil diambil';

                $data = ForumQuestion::with([
                    'categories',
                    'forum_user:id,nama',
                    'forum_user_update:id,nama',
                    'forum_group:id,g_nama'
                ])->where('fq_group_id', '=', $groupid)->get();
            }
            return response()->json([
                'message' => $message,
                'success' => $success,
                'data'=>$data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ForumController.getFQBasedGroupId',
                'error' => $e->getMessage(),
                'success' => $success
            ], 400);
        }
    }

    /**
     *    @OA\Post(
     *       path="/forumq/category",
     *       tags={"Forum Question"},
     *       operationId="getFQBasedCategory",
     *       summary="Forum Question - Get By Category ID",
     *		security={{ "bearerAuth": {} }},
     *       description="Mengambil Data Forum Question Berdasarkan Group ID",
    *    	@OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             example={
     *                      "fc_category_id": "[1,2]",
     *             },
     *         ),
     *     	),
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil mengambil Data Forum Question",
     *               "data": {
     *                   {
     *                      "id": 6,
     *                      "fq_question": "coba aja?",
     *                      "fq_group_id": 3,
     *                      "fq_created_by": 3,
     *                      "fq_updated_by": 5,
     *                      "created_at": "2024-03-26T06:58:15.000000Z",
     *                      "updated_at": "2024-03-26T07:07:04.000000Z",
     *                      "categories": {
     *                      {
     *                          "id": 1,
     *                          "c_nama": "Algoritma Pemrograman Komputer",
     *                          "c_created_by": 1,
     *                          "created_at": "2024-03-24T16:19:38.000000Z",
     *                          "updated_at": "2024-03-24T16:24:05.000000Z",
     *                          "pivot": {
     *                              "fc_forum_id": 6,
     *                              "fc_category_id": 1
     *                           }
     *                      }
     *                      },
     *                      "forum_user": {
     *                          "id": 3,
     *                          "nama": "Kiki"
     *                          },
     *                      "forum_user_update": {
     *                          "id": 5,
     *                          "nama": "Putin"
     *                      },
     *                      "forum_group": null
     *				}
     *              }
     *          }),
     *      ),
     *  )
     */
    public function getFQBasedCategory(Request $request)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;
            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil diambil';
                $categories = json_decode($request->fc_category_id);
                $data = ForumQuestion::join('tbl_forum_category', 'tbl_forum_category.fc_forum_id', 'tbl_forum_question.id')
                    ->join('tbl_category', 'tbl_category.id', 'tbl_forum_category.fc_category_id')
                    ->whereIn('tbl_forum_category.fc_category_id', $categories)
                    ->select('tbl_forum_question.*')
                    ->distinct()
                    ->with([
                        'categories',
                        'forum_user:id,nama',
                        'forum_user_update:id,nama',
                        'forum_group:id,g_nama'
                    ])
                    ->get();
            }
            return response()->json([
                'message' => $message,
                'success' => $success,
                'data'=>$data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in GroupController.store',
                'error' => $e->getMessage(),
                'success' => $success
            ], 400);
        }
    }

    public function getForumCount($userid){
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;
            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil diambil';
                $data = ForumQuestion::where('created_by',$userid)->count();
            }
            return response()->json([
                'message' => $message,
                'success' => $success,
                'data'=>$data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in GroupController.getForumCount',
                'error' => $e->getMessage(),
                'success' => $success
            ], 400);
        }
    }
}
