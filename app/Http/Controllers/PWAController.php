<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PWAController extends Controller
{
    /**
     * Display the QR scanner interface
     */
    public function scanner(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access the scanner');
        }

        $user = Auth::user();

        return view('pwa.scanner', [
            'user' => $user,
            'pageTitle' => 'QR Scanner',
        ]);
    }

    /**
     * Display offline fallback page
     */
    public function offline()
    {
        return view('pwa.offline', [
            'pageTitle' => 'Offline Mode',
        ]);
    }

    /**
     * Get scanner configuration for authenticated user
     */
    public function getScannerConfig(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();

        // Get auth token for API calls
        $token = $request->user()->currentAccessToken()?->token
            ?? $request->bearerToken()
            ?? session('api_token');

        return response()->json([
            'success' => true,
            'config' => [
                'apiEndpoint' => route('api.qr-scan.process'),
                'batchSyncEndpoint' => route('api.qr-scan.batch-sync'),
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
                'token' => $token,
                'enableGPS' => true,
                'enableSound' => true,
                'enableVibration' => true,
                'fps' => 10,
                'qrboxSize' => 250,
            ],
        ]);
    }

    /**
     * Handle PWA install prompt
     */
    public function install()
    {
        return response()->json([
            'success' => true,
            'message' => 'PWA installation initiated',
        ]);
    }

    /**
     * Get PWA status
     */
    public function status()
    {
        return response()->json([
            'success' => true,
            'pwa' => [
                'installed' => true,
                'version' => '1.0.0',
                'features' => [
                    'offline_mode' => true,
                    'qr_scanning' => true,
                    'background_sync' => true,
                    'push_notifications' => true,
                    'gps_tracking' => true,
                ],
            ],
        ]);
    }
}
