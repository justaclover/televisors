<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Playlist;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function store(Request $request)
    {
        $group = Group::query()->create([
            'name' => $request->name,
            'comment' => $request->comment
        ]);

        return response()->json([
            'group' => [
                'id' => $group->id,
                'name' => $group->name,
                'comment' => $group->comment,
            ]
        ]);
    }
}
