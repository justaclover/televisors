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
        return Socialite::driver('keycloak')->stateless()->redirect();
    }

    public function keycloakCallback()
    {
        $requestUser = Socialite::driver('keycloak')->stateless()->user();
        //dd(json_encode($requestUser, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
//        $token = $requestUser->token;
//
//        $publicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA4okswT9tjkxa7VLRu/jZ5lLF7Qf9HdeJtIN3gSqaEkNaDynq/ZRmuS+UUhVZTHRxrJBFy30EHV7q6g7A2vlaY5MJNf9+QYeaxLmajllLvoanY0/a6ThWNjaLln3lwUd1JC8NElEWcS6LEwCrm9HdLiNhs19wDro7V2pzEcPCg4h2Lw9jnjf9xIFEqS4LbkT4O+InHLQ/Yeq3JNJ1ObSWmShEpdvqb/6eqrnxr3Rbxz7O2SplMUgOyidrNIesEg5TBbPeROUzvCSbWLmAVB0yOk8s+kq1Zs2rzS4CpsTgpFtXwVRmXkMCLW34JDUE3F9U0A1xBetEcmQRurFOqZNiJwIDAQAB";
//        $publicKey = "-----BEGIN PUBLIC KEY-----\n" . chunk_split($publicKey, 64) . "-----END PUBLIC KEY-----";
//        $decoded = JWT::decode($token, new Key($publicKey, 'RS256'));
        $groups = $requestUser->groups;

        if (in_array("Developer", $groups) || in_array("IT", $groups)) {
            $user = User::updateOrCreate(['keycloak_id' => $requestUser->id], [
                'name' => $requestUser->name,
                'username' => $requestUser->username,
                'email' => $requestUser->email,
            ]);
            if ($requestUser->tg_id) {
                $user->update(['telegram_id' => $requestUser->tg_id]);
            }
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

    public function logout()
    {
        if (Auth::check()){
            //$token = Auth::user()->getRememberToken();
            $keycloakLogoutUrl = config('services.keycloak.base_url')
                . '/realms/' . config('services.keycloak.realms')
                . '/protocol/openid-connect/logout';
            $params = [
                'client_id' => config('services.keycloak.client_id'),
                'post_logout_redirect_uri' => url('/login'), // URL для перенаправления после логаута
            ];

            Auth::logout();
            request()->session()->invalidate();

            return redirect($keycloakLogoutUrl . '?' . http_build_query($params));
        }
        else {
            return redirect()->back();
        }
    }

}
