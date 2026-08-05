<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\HubliForgetPassword;

class LicenseAlertController extends Controller
{
    /**
     * Receive a domain-change alert (from sikhobd license control) and forward
     * it as a human-readable email to the license owner.
     *
     * Alias used by the caller: hubli_forget_password
     */
    public function domainChange(Request $request)
    {
        // Verify the shared secret so only the license system can trigger this.
        $expected = config('license.alert_secret', env('LICENSE_ALERT_SECRET'));

        if (!$expected || $request->input('secret') !== $expected) {
            abort(403, 'Invalid secret.');
        }

        $data = [
            'event' => $request->input('event', 'license_domain_change'),
            'old'   => $request->input('old'),
            'new'   => $request->input('new'),
            'ip'    => $request->input('ip'),
            'url'   => $request->input('url'),
            'time'  => $request->input('time'),
            'app'   => $request->input('app', config('app.name')),
        ];

        $to = config('license.alert_to', env('LICENSE_ALERT_TO', 'mehedaiarif.du@gmail.com'));

        Mail::to($to)->send(new HubliForgetPassword($data));

        return response()->json([
            'status' => 'ok',
            'sent'   => true,
        ]);
    }
}
