<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

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
     *      path="/password/email",
     *      operationId="emailPassword",
     *      tags={"Authentication"},
     *      summary="Email Password",
     *      description="Email Password",
     *      @OA\Response(
     *          response=200,
     *          description="Successful response",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status",
     *                  type="string"
     *              )
                )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                  property="email",
     *                  type="string"
     *              )
                )
     *     ),
     *            
     *     @OA\RequestBody(
     *         description="Input data format",
     *         required=true,
     *         @OA\JsonContent(
     *              @OA\Property(
     *                  property="email",
     *                  type="string"
     *              )
     *         )
     *     )        
     *)
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return ['status' => trans($response)];
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json(['email' => trans($response)], 400);
    }
}
