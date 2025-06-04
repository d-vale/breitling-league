<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('auth.edit-password');
    }

    public function update(PasswordRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = User::find(Auth::user()->id);
    
            if (Hash::check($validated['current_password'], $user->password)) {
                $user->password = Hash::make($validated['new_password']);
                $user->save();
                
                return back()->with('status', 'Mot de passe modifié avec succès!');
            } else {
                return back()->with('error', 'Le mot de passe actuel est incorrect.');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}   