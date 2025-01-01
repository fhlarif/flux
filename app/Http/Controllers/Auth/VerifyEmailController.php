<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

final class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        /** @var \App\Models\User|null $user */
        $user = $request->user();
        if ($user) {
            if ($user->hasVerifiedEmail()) {
                return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
            }

            if (config('auth.providers.users.verify') && $user->markEmailAsVerified()) {
                event(new Verified($user));
            }
        }

        return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
    }
}
