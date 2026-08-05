<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ServerControlController extends Controller
{
    protected function lockFile(): string
    {
        return base_path('storage/app/course_state.lock');
    }

    protected function secret(): ?string
    {
        return config('license.control_token');
    }

    protected function checkToken(string $token): void
    {
        $secret = $this->secret();

        if (!$secret || !hash_equals($secret, $token)) {
            abort(403, 'Invalid access token.');
        }
    }

    /**
     * Remote state change via GET.
     * /license/control/lock/{token}   -> take the app down (deactivate)
     * /license/control/unlock/{token} -> bring the app back up (activate)
     */
    public function control(Request $request, string $action, string $token)
    {
        $this->checkToken($token);

        $lockFile = $this->lockFile();

        if (in_array($action, ['lock', 'down'])) {
            if (!File::exists($lockFile)) {
                File::put($lockFile, now()->toDateTimeString());
            }
            $state = 'locked';
        } elseif (in_array($action, ['unlock', 'up'])) {
            if (File::exists($lockFile)) {
                File::delete($lockFile);
            }
            $state = 'unlocked';
        } else {
            abort(400, 'Unknown action. Use lock or unlock.');
        }

        $locked = File::exists($lockFile);

        return response()->json([
            'status' => 'ok',
            'action' => $action,
            'state'  => $state,
            'locked' => $locked,
        ]);
    }

    /**
     * Check current state without changing it.
     * /license/control/status/{token}
     */
    public function status(Request $request, string $token)
    {
        $this->checkToken($token);

        return response()->json([
            'locked'     => File::exists($this->lockFile()),
            'checked_at' => now()->toDateTimeString(),
        ]);
    }
}
