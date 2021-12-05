<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @OA\Post(
     *      path="/password/reset",
     *      operationId="resetPassword",
     *      tags={"Authentication"},
     *      summary="Reset Password",
     *      description="Reset your Password",
     *      @OA\Response(
     *          response=200,
     *          description="Successful response",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *           ref="#/components/schemas/LoginError"
                )
     *     ),
     *
     *     @OA\RequestBody(
     *         description="Input data format",
     *         required=true,
     *         @OA\JsonContent(
     *              @OA\Property(
     *                  property="password",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="password_confirmation",
     *                  type="string"
     *              )
     *         )
     *     )
     *)
     */
    protected function sendResetResponse(Request $request, $response)
    {
        return ['status' => trans($response)];
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  string  $response
     */
    protected function sendResetFailedResponse(Request $request, $response): JsonResponse
    {
        return response()->json(['email' => trans($response)], 400);
    }
}
