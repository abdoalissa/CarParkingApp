<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

/**
 * @group Auth
 */

class LogoutController extends Controller
{
     public function __invoke(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
 
        return response()->noContent();
    }
}
