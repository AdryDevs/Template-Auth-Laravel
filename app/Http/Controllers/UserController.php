<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    const SUPER_ADMIN_ROLE_ID = 3;
    public function addSuperAdminRoleByIdUser($id)
    {
        try {
            $userId = $id;
            $user = User::find($userId);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            if ($user->hasRole(self::SUPER_ADMIN_ROLE_ID)) {
                return response()->json([
                    'success' => false,
                    'message' => 'User already has super admin role'
                ]);
            }

            $user->roles()->attach(self::SUPER_ADMIN_ROLE_ID);

            return response()->json([
                'success' => true,
                'message' => 'Super admin role added to user'
            ]);
        } catch (\Throwable $th) {
            Log::error("error adding super admin role to user: " . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error adding super admin role to user'
            ]);
        }
    }
}
