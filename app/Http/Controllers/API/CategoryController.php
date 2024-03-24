<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     *    @OA\Get(
     *       path="/category",
     *       tags={"Category"},
     *       operationId="category-index",
     *       summary="Category - Get All",
     *       description="Mengambil Data Category",
     *		security={{ "bearerAuth": {} }},
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil mengambil Data Category",
     *               "data": {
     *                   {
     *						"id": "1",
     *						"c_nama": "Pemrograman Komputer",
     *						"c_created_by": 1,
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
                $data = Category::all();
            }
            return response()->json([
                'message' => $message,
                'data' => $data,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CategoryController.index',
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
     *     	operationId="category-store",
     *     	tags={"Category"},
     *     	summary="Category - Insert",
     *     	description="Post data Category",
     *     	path="/category",
     *     	security={{"bearerAuth":{}}},
     *    	@OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             example={
     *						"c_nama": "Pemrograman Komputer",
     *						"c_created_by": 2,
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
                'c_nama' => 'required',
                'c_created_by' => 'required',
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
                $data = Category::create($request->all());
            }
            return response()->json([
                'message' => $message,
                'data' => $data,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CategoryController.store',
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
     *       path="/category/{category}",
     *       tags={"Category"},
     *       operationId="category-show",
     *       summary="Category - Get By ID",
     *		security={{ "bearerAuth": {} }},
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="1",
     *       type="string",
     *     ),
     *     description="Masukan User ID",
     *     example="1",
     *     in="path",
     *     name="category",
     *     required=true,
     *   ),
     *       description="Mengambil Data Category Berdasarkan User ID",
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil mengambil Data Category",
     *               "data": {
     *                   {
     *						"id": "1",
     *						"c_nama": "Pemrograman Komputer",
     *						"c_created_by": 2,
     *					}
     *              }
     *          }),
     *      ),
     *  )
     */
    public function show($category)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil diambil';
                $data = Category::where('id', $category)->first();
            }
            return response()->json([
                'message' => $message,
                'data' => $data,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CategoryController.show',
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
     *     	operationId="category-update",
     *     	tags={"Category"},
     *     	summary="Category - Update",
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="3",
     *       type="string",
     *     ),
     *     description="Masukan Category ID",
     *     example="1",
     *     in="path",
     *     name="category",
     *     required=true,
     *   ),
     *     	description="Update data Category",
     *     	path="/category/{category}",
     *     	security={{"bearerAuth":{}}},
     *    	@OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             example={
     *						"c_nama": "Pemrograman Komputer",
     *						"c_created_by": 2,
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
    public function update(Request $request, $category)
    {
        try {
            $validator = Validator::make($request->all(), [
                'c_nama' => 'required',
                'c_created_by' => 'required',
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
                $result = Category::where('id', $category)->update($request->all());
            }
            return response()->json([
                'message' => $message,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in categoryController.update',
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
     *     	operationId="category=destroy",
     *     	tags={"Category"},
     *     	summary="Category - Delete",
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="3",
     *       type="string",
     *     ),
     *     description="Masukan Category ID",
     *     example="2",
     *     in="path",
     *     name="category",
     *     required=true,
     *   ),
     *     	description="Delete data Category",
     *     	path="/category/{category}",
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
    public function destroy($category)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil dihapus';

                $data = Category::where([
                    ['id', '=', $category]
                ])->delete();
            }
            return response()->json([
                'message' => $message,
                'success' => $success
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CategoryController.destroy',
                'error' => $e->getMessage(),
                'success' => $success
            ], 400);
        }
    }
}
