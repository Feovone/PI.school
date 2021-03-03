<?php

/** @OA\Tag(
 *     name="User",
 *     description ="Auth & Personal Info"
 * )
 */

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    /** @OA\Get(
     *     tags={"User"},
     *     path="/api/user",
     *     description="Get a User profile ",
     *     @OA\Response(response="200", description="User model" ),
     *     @OA\Response(response="403", description="Unauthorized")
     * )
     */
    public function index()
    {
        return auth()->user();
    }

    /** @OA\Get (
     *     tags={"User"},
     *     path="/api/userPhotoIndex",
     *     description="Get the User photo ",
     *      @OA\Parameter(
     *         name="conversion",
     *         in="query",
     *         description="Type of image",
     *         required=true,
     *  ),
     *     @OA\Response(response="200", description="Added photo")
     * )
     */
    public function userPhotoIndex(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $mediaItems = $user->getMedia('profile');
        $conversion = $request->conversion;
        try {
            if ($conversion == null) {
                $photo = $mediaItems[0]->getPath();
            } else {
                $photo = $mediaItems[0]->getPath($conversion);
            }
        } catch (\Exception $e) {
            return response()->file(Storage::disk('public')->path('user.png'));
        }
        return response()->file($photo);
    }

    /** @OA\Post (
     *     tags={"User"},
     *     path="/api/userPhotoStore",
     *     description="Update the User photo ",
     *      @OA\Parameter(
     *         name="file",
     *         in="path",
     *         description="Type of image",
     *         required=true,
     *  ),
     *     @OA\Response(response=200,description="Changed")
     * )
     */
    public function userPhotoStore(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $this->attachFiles($request, $user);
        return response('Changed', 200);
    }

    /** @OA\Post (
     *     tags={"User"},
     *     path="/api/user/{id}",
     *     description="Update User",
     *      @OA\Parameter(
     *         name="{User}",
     *         in="path",
     *         description="User model",
     *         required=true,
     *  ),
     *     @OA\Response(response=200,description="Update")
     * )
     */
    public function update(UserRequest $request)
    {
        $request->validated();
        $user = User::where('id', auth()->user()->id)->first();
        $temp = $request->all();
        foreach ($temp as $key => $field) {
            if ($field !== null) {
                $input[$key] = $field;
            }
        }
        foreach ($input as $key => $field) {
            switch ($key) {
                case 'firstName':
                    $user->first_name = $field;
                    break;
                case 'lastName':
                    $user->last_name = $field;
                    break;
                case 'forcePercentage':
                    $user->force_exchange_percentage = $field;
                    break;
                case 'exchangeFlag':
                    $user->force_exchange_flag = $field;
                    break;
                case 'taxRate':
                    $user->tax_rate = $field;
                    break;
                case 'notification':
                    $user->notification_period = $field;
                    break;
            }
        }
        $user->save();
        return response('{"status":"Update"}', 200);
    }

    /** @OA\Post (
     *     tags={"User"},
     *     path="/api/register",
     *     description="Registration User",
     *      @OA\Parameter(
     *         name="Email",
     *         in="path",
     *         description="Registration Email",
     *         required=true,
     *  ),
     *     @OA\Parameter(
     *         name="Password",
     *         in="path",
     *         description="Registration pass",
     *         required=true,
     *  ),
     *     @OA\Response(response=200,description="Email already registered"),
     *     @OA\Response(response="default",description="Registration Complete!")
     * )
     */
    public function register(UserRequest $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'required|min:6',
            'confirmPassword' => 'same:password'
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response('{"status":"Email already registered"}', 200);
        }
        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->tax_rate = 5;
        $user->force_exchange_flag = 1;
        $user->force_exchange_percentage = 30;
        $user->notification_period = "false";
        $user->save();
        return response('{"status":"Registration Complete!"}', 200);
    }

    /** @OA\Post (
     *     tags={"User"},
     *     path="/api/login",
     *     description="Login User",
     *      @OA\Parameter(
     *         name="Email",
     *         in="path",
     *         description="Login Email",
     *         required=true,
     *  ),
     *     @OA\Parameter(
     *         name="Password",
     *         in="path",
     *         description="Login pass",
     *         required=true,
     *  ),
     *     @OA\Response(response=200,description="Incorrect credentials"),
     *     @OA\Response(response="default",description="Login!")
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'required|min:6'
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response(
                '{"status":"Incorrect credentials"}'
                , 200);
        }
        $token = $user->createToken('my-app-token')->plainTextToken;
        $response = ['token' => $token];
        return response($response, 201);
    }

    protected function attachFiles(Request $request, User $user)
    {
        if ($request->hasFile('file')) {
            $user->clearMediaCollection('profile');
            $user->addMediaFromRequest('file')->toMediaCollection("profile");
        }
    }

    /** @OA\Get  (
     *     tags={"User"},
     *     path="/api/logout",
     *     description="Delete current token",
     *     @OA\Response(response="default",description="Deleted")
     * )
     */
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
    }
}
