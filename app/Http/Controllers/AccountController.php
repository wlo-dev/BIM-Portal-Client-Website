<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function show(Request $request)
    {
        return view('account',['user'=>$request->user()]);
    }
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'=> ['required', 'string', 'max:100'],
        ])
        $request->user()->update($data);

        return back()->width('status', 'Profile Updated Successfully');
    }
}