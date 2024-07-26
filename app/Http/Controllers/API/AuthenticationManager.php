<?php
namespace App\Http\Controllers\API;

use App\Helpers\Functions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationManager extends Controller
{

    /**
     * AuthenticationManager constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('logout');
    }

    public function register(Request $request)
    {

        /* Validate User Credentials */

        $validator = Validator::make($request->all(), [

            'name' => 'required|string|min:2|max:50',

            'email' => 'required|string|email|min:5,max:96|unique:users',

            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();

        // We'll simply execute the given callback within a try / catch block

        // and if we catch any exception we can rollback the transaction

        // so that none of the changes are persisted to the database.

        try {

            $user = User::create([

                'name' => $request->name,

                'email' => $request->email,

                'password' => Hash::make($request->password)
             ]);

            DB::commit();

            return response()

            ->json(['status' => 'success',

            'message' => "Registered Successfully",

            'data' => $user,

            'access_token' => $user->createToken('auth_token')->plainTextToken,

            'token_type' => 'Bearer']);
        }

        // If we catch an exception, we will roll back so nothing gets messed

        // up in the database. Then we'll re-throw the exception so it can

        // be handled how the developer sees fit for their applications.

        catch (\Exception $e) {

            Functions::logException($e);

            /* Rollback if the creation failed */

            DB::rollBack();

            return response()

                ->json(['status' => 'failure',

                'message' => $e->getMessage(),

                'data' => null]);
        }
    }

    public function login(Request $request)
    {
        try {

            /* Validate User Credentials */

            $validator = Validator::make($request->only('email', 'password'), [

                'email' => 'required|string|email|min:5,max:96|exists:users',

                'password' => 'required|string|min:8'
            ]);

            if ($validator->fails()) {

                return response()->json(['errors' => $validator->errors()]);
            }

            if (!Auth::attempt($request->only('email', 'password'))) {

                return response()

                ->json(['message' => 'Unable to authenticate'], 401);
            }

            $token = auth()->user()

            ->createToken('login_token')

            ->plainTextToken;

            return response()

            ->json(['status' => 'success',

            'data' => auth()->user(),

            'message' => "Logged in Successfully",

            'access_token' => $token,

            'token_type' => 'Bearer']);

        } catch (\Exception $e) {

            Functions::logException($e);

            return response()

            ->json(['message' => 'Bad Request'], 400);
        }
    }

    public function logout()
    {
        $user = auth()->user();

        /* Delete all tokens associated with the user */

        $user->tokens()->delete();

        return [

            'status' => 'success',

            'data' => $user,

            'message' => "Logged out successfully"
        ];
    }
}
