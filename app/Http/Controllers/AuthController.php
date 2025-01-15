<?php
// user is admin and employee
namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Http\Resources\CustomerResource;
use App\Models\User;
use App\Models\Customer;
use App\Models\AssignedCustomer;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest\LoginRequest;
use App\Http\Requests\AuthRequest\CustomerRequest;
use App\Http\Requests\AuthRequest\UserRequest;
use App\Http\Requests\AuthRequest\AssignedCustomerRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    // this function for create user admin and employee
    // create user admin or employee
    public function createUser(UserRequest $request){
        try{
            $user = Auth::user();
            $userData = User::create(
                array_merge(
                    $request->all(),
                    [
                        'created_by' => $user->id
                    ]
                )
            );
            return response()->json([
                'message' => ['User created successfully.'],
                'data' => new EmployeeResource($userData)
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => ['Something wrong, please confirm your data and try again.'],
            ], 403);
        }
    }



    // this function for create Customer
    public function createCustomer(CustomerRequest $request){
        try{
            $user = Auth::user();
            $Customer = Customer::create(
                array_merge(
                    $request->all(),
                    [
                        'created_by' => $user->id
                    ]
                )
            );
            return response()->json([
                'message' => ['Customer created successfully.'],
                'data' => new CustomerResource($Customer)
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => ['Something wrong, please confirm your data and try again.'],
            ], 403);
        }
    }

    public function assignCustomerToEmployee(AssignedCustomerRequest $request){
        try{

            $user = Auth::user();
            $employee = User::find($request->employee_id);

            if($employee->type != 'employee'){
                return response()->json([
                    'message' => ['This user is not employee to assign customer to it.'],
                ], 403);
            }
            AssignedCustomer::updateOrCreate([
                'created_by' => $user->id, // is an admin
                'customer_id' => $request->customer_id,
                'employee_id' => $request->employee_id,
            ]);

            return response()->json([
                'message' => ['Customer assigned to employee successfully.'],
            ], 200);

        }catch(\Exception $e){
            return response()->json([
                'message' => ['Something wrong, please confirm your data and try again.'],
            ], 403);
        }
    }

    public function login(LoginRequest $request)
    {
        // can login by username or email
        $login = $this->getLoginField($request->username);
        if ($login == 'email') {
            $user = User::where('email', $request->username)->first();
        } elseif ($login === 'username') {
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
