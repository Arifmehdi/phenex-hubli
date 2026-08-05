<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LicenseControl
{
    /**
     * Lock file path. When this file exists the application is "down".
     */
    protected function lockFile(): string
    {
        return base_path('storage/app/course_state.lock');
    }

    public function isLocked(): bool
    {
        return File::exists($this->lockFile());
    }

    public function handle(Request $request, Closure $next)
    {
        // The control endpoints must always be reachable,
        // otherwise you could permanently lock yourself out.
        $path = $request->decodedPath();
        $allowedPrefixes = ['license/'];

        $controlPath = trim((string) config('license.control_path', 'license'), '/');
        if ($controlPath !== '' && $controlPath !== 'license') {
            $allowedPrefixes[] = $controlPath . '/';
        }

        foreach ($allowedPrefixes as $prefix) {
            if (Str::startsWith($path, $prefix)) {
                return $next($request);
            }
        }

        if ($this->isLocked()) {
            return response()->view('courseenrollment.course_enrollment', [], 503);
        }

        return $next($request);
    }
}
