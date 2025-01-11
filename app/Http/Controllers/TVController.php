<?php

namespace App\Http\Controllers;

use App\Models\Televisor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use function Pest\Laravel\json;


class TVController extends Controller
{
    public function store()
    {
        $tv = Televisor::query()->create();
        return response()->json(['device_id' => $tv->id]);
    }
}
