<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request)
    {//validator salje POST zahteve, pa tako proverava da li su validni podaci
        $validator = Validator::make($request->all(),[ //ovaj validator kreira neki objekat i smesta ga unutar promenljive validator, ta promenljiva predstavlja objekat koji ima
            //neke promenljive u sebi, jedna od tih metoda je request, koja proverava da li je nas korisnik uspesno prosao sva ogranicenja, ako jeste vraca true, ako ne, vraca false
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()) //ukoliko uspesno prodje validaciju, kreiraj korisnika i ubaci ga u bazu
            return response()->json($validator->errors());

            $user = User::create([ //kreiramo usera, on cuva automatski sa odredjenim imenom, mejlom i sifrom, cuva u bazi i promenljivoj
                'name' => $request->name,
                'email'=> $request->email,
                'password' => Hash::make($request -> password),
            ]);

        //moramo da pravimo tokene, tj kada se user registruje da ima token u sebi da se registrovao, da on kasnije moze da se uloguje preko tog tokena
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer']);

        //unutar kontrolera kreirali smo metodu, da bismo mogli da je pozovemo moramo da napravimo RUTU
    }

    public function login(Request $request) //proveravamo registrovanog korisnika da li ima odgovarajuc mejl i sifru
    //auth se koristi za pristup autentifikovanom korisniku
    //iz requesta pokupi samo mejl i sifru, ako jeste.. ako nije..
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail(); //vrati usera gde mu je email ovaj email koji smo dobili u requestu, ako ih ima vise, nadji 
        //onaj prvi, tj prvi takav vrati

        $token = $user->createToken('auth_token')->plainTextToken; //dobijamo token sa kojim mozemo da se krecemo dalje po stranici, npr da kupimo proizvode, stavimo 
        //ih u korpu itd

        return response()
            ->json(['message' => 'Hi ' . $user->name . ', welcome to home', 'access_token' => $token, 'token_type' => 'Bearer',]);
    }


    public function logout()
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
}
    

