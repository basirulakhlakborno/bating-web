<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesJwtUser;
use App\Support\Referral\ReferralDataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReferralApiController extends Controller
{
    use ResolvesJwtUser;

    public function __construct(
        private ReferralDataService $referralData,
    ) {}

    public function show(Request $request): JsonResponse
    {
        $user = $this->resolveBearerUser($request);
        if ($user === null) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return response()->json($this->referralData->snapshot($user));
    }
}
