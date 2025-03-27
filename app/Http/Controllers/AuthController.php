<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

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
}
