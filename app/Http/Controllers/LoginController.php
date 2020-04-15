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
    public function login(Request $request)
    {
        $login = $request->validate([
           'email' => 'required|string',
           'password' => 'required|string'
        ]);

        if (!Auth::attempt($login)) {
            throw new InvalidCredentialException();
        }

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
     *      security={{"authbearer": {}}},
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
     *          @OA\MediaType(
     *             mediaType="application/json"
     *          )
     *      )
     * )
    */
    public function verifyDevice(Request $request)
    {
        if (! hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
            throw new InvalidUserIdException();
        }

        if (! hash_equals((string) $request->route('hash'), sha1($request->server('HTTP_USER_AGENT')))) {
            throw new InvalidDeviceException();
        }

        $sha1UserKey = sha1(auth()->user()->getKey());
        $shaUserAgent = sha1($request->server('HTTP_USER_AGENT'));

        if ( Cookie::has($sha1UserKey) && hash_equals($shaUserAgent, Cookie::get($sha1UserKey))) {
            throw new AlreadyRegisteredDeviceException();
        }

        return response(['message' => 'Your device was successfully added to your account for 30 days!'])
            ->withCookie($sha1UserKey, $shaUserAgent, time() + (86400 * 30));
    }

    public function registerDevice(Request $request)
    {
        auth()->user()->notify(new RegisterDevice($request));

        return response(['message' => 'You need to verify your device first. Check your email!']);
    }
}
