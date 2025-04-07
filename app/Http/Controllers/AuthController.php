<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;
use PHPUnit\Framework\Exception;

class AuthController extends Controller
{
    public function telegram()
    {
        $requestUser = Socialite::driver('telegram')->user();

        if (User::where('telegram_id',$requestUser->getId())->exists()) {
            $user = User::where('telegram_id',$requestUser->getId())->first();
            Auth::login($user, true);

            return redirect('admin');
        }
        else {
            return Inertia::render('Authorize', [
                'botId' => 7767854254,
                'failedAuth' => true,
            ]);
        }

    }

    public function keycloak()
    {
        if (Auth::user()){
            return redirect('admin');
        }
        Auth::logout();
        request()->session()->invalidate();
        return Socialite::driver('keycloak')->stateless()->redirect();
    }

    public function keycloakCallback()
    {
        $requestUser = Socialite::driver('keycloak')->stateless()->user();
        $token = $requestUser->token;

        $publicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA4okswT9tjkxa7VLRu/jZ5lLF7Qf9HdeJtIN3gSqaEkNaDynq/ZRmuS+UUhVZTHRxrJBFy30EHV7q6g7A2vlaY5MJNf9+QYeaxLmajllLvoanY0/a6ThWNjaLln3lwUd1JC8NElEWcS6LEwCrm9HdLiNhs19wDro7V2pzEcPCg4h2Lw9jnjf9xIFEqS4LbkT4O+InHLQ/Yeq3JNJ1ObSWmShEpdvqb/6eqrnxr3Rbxz7O2SplMUgOyidrNIesEg5TBbPeROUzvCSbWLmAVB0yOk8s+kq1Zs2rzS4CpsTgpFtXwVRmXkMCLW34JDUE3F9U0A1xBetEcmQRurFOqZNiJwIDAQAB";
        $publicKey = "-----BEGIN PUBLIC KEY-----\n" . chunk_split($publicKey, 64) . "-----END PUBLIC KEY-----";
        $decoded = JWT::decode($token, new Key($publicKey, 'RS256'));
        $groups = $decoded->groups;

        if (in_array("Developer", $groups) || in_array("IT", $groups)) {
//            $user = User::updateOrCreate(['keycloack_id' => $requestUser->id], [
//                'name' => $requestUser->name,
//                'email' => $requestUser->email,
//            ]);;
            Auth::login($requestUser, true);

            return redirect('admin');
        }
        else {
            return Inertia::render('Authorize', [
                'botId' => 7767854254,
                'failedAuth' => true,
            ]);
        }

        Auth::login($user, true);
        return redirect('admin');
    }
}
