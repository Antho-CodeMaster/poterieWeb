<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Question_securite;
use Illuminate\Support\Facades\Hash;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Display the password reset link request view.
     */
    public function question(Request $request): View
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $q_id = User::where('email', $request->email)->first()->id_question_securite;

        $q = Question_securite::where('id_question', $q_id)->first()->question;

        return view('auth.question-password', ['question' => $q, 'email' => $request->email]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $status = null;
        $request->validate([
            'reponse' => ['required'],
        ]);

        $rep = User::where('email', $request->email)->first()->reponse_question;

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        if(Hash::check($request->reponse, $rep))
            $status = Password::sendResetLink(
                $request->only('email')
            );
        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('reponse'))
                            ->withErrors(['reponse' => __($status)]);
    }
}
