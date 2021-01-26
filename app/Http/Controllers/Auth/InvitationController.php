<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    public function index(Request $request){

        $user = User::where('parent_id', $request->user()->id)->get();

        return response()->json($user);
    }
    public function store(Request $request)
    {

        $request->validate([
            'name'          => 'required|string',
            'nric'          => 'required|string|unique:users',
            'country_code'  => 'required|string',
            'mobile'        => 'required|string|unique:users',
            'email'         => 'required|string|email|unique:users',
        ]);

        $user = new User;

        $user->name = $request->name;
        $user->nric = $request->nric;
        $user->country_code = $request->country_code;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->password = bcrypt('Smsgvs32!@#$');
        $user->parent_id = $request->user()->id;

        if(Auth()->user()->status == 'admin'){

            $user->status = 'sale_expert';

        }elseif(Auth()->user()->status == 'sale_expert'){

            $user->status = 'personal_shopper_1';

        }elseif(Auth()->user()->status == 'personal_shopper_1'){

            $user->status = 'personal_shopper_2';

        }else {

            $user->status = 'personal_shopper_2';
        }

        $user->save();

        $token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($user);

        Mail::to($user->email)
            ->send(new Contact($user->name, $token, $user->email));

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        return response()->json([
            'message' => 'Invite successfully'
        ], 201);
    }

    public function user(){


    }

    public function password(Request $request, $token = null){

        return view('site.pages.validation.validate')->with(['token' => $token, 'email' => $request->email]);

    }
}
