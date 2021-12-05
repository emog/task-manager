<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Rules\OrganizationBelongsToOffice;

class RegisterController extends Controller
{
    use RegistersUsers;

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
     *      path="/register",
     *      operationId="register",
     *      tags={"Authentication"},
     *      summary="Register new user",
     *      description="Register new user",
     *      @OA\Response(
     *          response=201,
     *          description="Successful response",
     *          @OA\JsonContent(
     *          ref="#/components/schemas/User"
     *         )
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
     *                  property="name",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="email",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="password_confirmation",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="office_id",
     *                  type="int",
     *                  format="int32"
     *              ),
     *              @OA\Property(
     *                  property="organization_id",
     *                  type="string",
     *                  format="int32"
     *              )
     *         )
     *     )
     *)
     */
    protected function registered(Request $request, $user)
    {
        return $user;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'              => 'required|min:2|max:255',
            'email'             => 'required|email|max:255|unique:users',
            'password'          => 'required|min:6|confirmed',
            'office_id'         => 'required|exists:offices,id',
            'organization_id'   => 'required|exists:organizations,id',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data): User
    {
        $v = Validator::make($data, ['organization_id' => new OrganizationBelongsToOffice($data['office_id'])]);
        $v->validate();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'active' => 1,
            'office_id'=> $data['office_id'],
            'organization_id'=> $data['organization_id']
        ]);

        $user->assignRole('installer');
        return $user;
    }
}
