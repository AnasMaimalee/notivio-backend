<?php

namespace App\Http\Controllers\API\Onboarding;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserThemeService;

class OnboardingController extends Controller
{
    public function __construct(protected UserThemeService $service) {}

    // GET /api/themes/colors
    public function listColors()
    {
        return response()->json($this->service->listThemeOptions());
    }

    // POST /api/onboarding/theme
    public function setTheme(Request $request)
    {
        $request->validate([
            'primary' => 'required|string',
            'secondary' => 'required|string',
        ]);

        $theme = $this->service->setUserTheme(
            $request->user()->id,
            ['primary_color' => $request->primary, 'secondary_color' => $request->secondary]
        );

        return response()->json([
            'message' => 'Theme saved successfully',
            'theme' => $theme
        ]);
    }
}
