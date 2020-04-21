<?php

namespace App\Http\Controllers;

use App\Exceptions\AlreadyRegisteredDeviceException;
use App\Exceptions\InvalidCredentialException;
use App\Exceptions\InvalidDeviceException;
use App\Exceptions\InvalidUserIdException;
use App\Notifications\RegisterDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     operationId="login",
     *     tags={"Login"},
     *     description="Login form",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"email": "ile.dan27@yahoo.com", "password": "test"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login Successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 ref="#/components/schemas/User"
     *             ),
     *             @OA\Property(
     *                 property="accessToken",
     *                 type="string"
     *             ),
     *         ),
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $login = $request->validate([
           'email' => 'required|string',
           'password' => 'required|string'
        ]);

        if (!Auth::attempt($login)) {
            throw new InvalidCredentialException();
        }

        Auth::user()->tokens()->delete();

        return response([
            'user' => Auth::user(),
            'accessToken' => Auth::user()->createToken('authToken')->accessToken,
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/verifyDevice/{id}/{hash}",
     *      operationId="verifyDevice",
     *      tags={"Login"},
     *      description="Verify a Device",
     *      @OA\Parameter(
     *         description="ID of the user that add the device",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *      ),
     *     @OA\Parameter(
     *         description="Hash of the user browser id",
     *         in="path",
     *         name="hash",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *      ),
     *     @OA\Parameter(
     *         description="Expire date of the link",
     *         in="query",
     *         name="expires",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *      ),
     *     @OA\Parameter(
     *         description="Hash of the link",
     *         in="query",
     *         name="signature",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              ),
     *              example={"message": "This is a success message"}
     *          ),
     *      )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function verifyDevice(Request $request)
    {
        if (! hash_equals((string) $request->route('hash'), sha1($request->server('HTTP_USER_AGENT')))) {
            throw new InvalidDeviceException();
        }

        $sha1UserKey = sha1($request->route('id'));
        $shaUserAgent = sha1($request->server('HTTP_USER_AGENT'));

        if (Cookie::has($sha1UserKey) && hash_equals($shaUserAgent, Cookie::get($sha1UserKey))) {
            throw new AlreadyRegisteredDeviceException();
        }

        return response(['message' => 'Your device was successfully added to your account for 30 days!'])
            ->withCookie($sha1UserKey, $shaUserAgent, time() + (86400 * 30));
    }

    /**
     * @OA\Get(
     *     path="/api/registerDevice",
     *     operationId="registerDevice",
     *     tags={"Login"},
     *     description="With this link you can send a register device mail",
     *     security={{"authbearer": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              ),
     *              example={"message": "This is a success message"}
     *          ),
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function registerDevice(Request $request)
    {
        $sha1UserKey = sha1(auth()->user()->getKey());
        $shaUserAgent = sha1($request->server('HTTP_USER_AGENT'));

        if (Cookie::has($sha1UserKey) && hash_equals($shaUserAgent, Cookie::get($sha1UserKey))) {
            throw new AlreadyRegisteredDeviceException();
        }

        auth()->user()->notify(new RegisterDevice($request));

        return response(['message' => 'You need to verify your device first. Check your email!']);
    }
}
