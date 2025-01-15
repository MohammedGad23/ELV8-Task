<?php
// user is admin and employee
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest\LoginRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{

    public function login(LoginRequest $request){

        $login = $this->getLoginField($request->username);
        if ($login == 'email') {
            $user = User::where('email', $request->username)->first();
        } elseif ($login === 'phone') {
            $user = User::where('phone', $request->username)->first();
        } else {
            $user = User::where('username', $request->username)->first();
        }
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => ['The user login or password is incorrect.'],
            ], 402);
        }

        return response()->json([
            'token' => $user->createToken($request->password)->plainTextToken,
            'role' => $user->type,
        ], 200);
    }

    private function getLoginField($login)
    {

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }
        if (preg_match('/^\+?[1-9]\d{1,14}$/', $login)) {
            return 'phone';
        }
        return 'username';
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $currentToken = $user->currentAccessToken();
            if ($currentToken) {
                $currentToken->delete();
            }
            return response()->json([
                "message" => "Logged out successfully"
            ]);
        }
        return response()->json([
            "message" => "User not authenticated"
        ], 401);
    }
}
