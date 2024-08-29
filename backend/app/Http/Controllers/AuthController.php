<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    //------------register-----------------//

    public function register(Request $request)
    {
        // Valider les données de l'utilisateur
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            // Créer l'utilisateur
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Créer un token pour l'utilisateur
            $token = $user->createToken('auth_token')->plainTextToken;

            // Retourner une réponse avec les informations de l'utilisateur et le token
            return response()->json([
                'message' => 'User registered successfully!',
                'user' => $user,
                'token' => $token,
            ], 201);
        } catch (\Exception $e) {
            // Log l'erreur et retourner une réponse d'erreur
            \Log::error('Error during registration: ' . $e->getMessage());
            return response()->json(['message' => 'Registration failed, please try again.'], 500);
        }
    }


    //------------login-----------------//

    public function login(Request $request)
    {
        // Valider les informations d'identification
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Vérifier les informations d'identification
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        // Récupérer l'utilisateur
        $user = Auth::user();

        // Créer un token pour l'utilisateur
        $token = $user->createToken('auth_token')->plainTextToken;

        // Retourner la réponse avec le token
        return response()->json([
            'message' => 'Login successful!',
            'token' => $token,
            'user' => $user,
        ]);
    }
    //------------logout-----------------//
    public function logout(Request $request)
    {
        // Révoquer le token actuel de l'utilisateur
        $request->user()->currentAccessToken()->delete();

        // Retourner une réponse de succès
        return response()->json([
            'message' => 'Logout successful!'
        ]);
    }


}


