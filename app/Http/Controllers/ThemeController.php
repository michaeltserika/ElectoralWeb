<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function toggle(Request $request)
    {
        $theme = $request->input('theme', 'dark');
        session(['theme' => $theme]);
        return response()->json(['success' => true]);
    }
}
