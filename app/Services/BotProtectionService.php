<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\RateLimiter;

class BotProtectionService
{
    /**
     * Generate a new math verification challenge
     *
     * @param string $formKey
     * @return array
     */
    public static function generateChallenge($formKey = 'default')
    {
        $num1 = rand(2, 9);
        $num2 = rand(1, 9);
        $answer = $num1 + $num2;

        $payload = [
            'ans' => $answer,
            'time' => time(),
            'key' => $formKey,
        ];

        $token = Crypt::encrypt($payload);
        $renderedAt = Crypt::encrypt(time());

        // Also store in session for dual-mode verification
        try {
            session()->put("bot_challenge_{$formKey}", $answer);
        } catch (\Throwable $e) {
            // Ignore if session not active yet
        }

        return [
            'num1' => $num1,
            'num2' => $num2,
            'question' => "{$num1} + {$num2} = ?",
            'token' => $token,
            'rendered_at' => $renderedAt,
        ];
    }

    /**
     * Validate an incoming request against bot / spam criteria:
     * 1. Honeypot check (hidden input traps)
     * 2. Time-lock check (bot submitted too quickly)
     * 3. Math verification check (if required)
     * 4. IP rate limiter (throttling spam attacks)
     *
     * @param Request $request
     * @param string $formKey
     * @param bool $requireMath
     * @return array ['success' => bool, 'message' => string|null]
     */
    public static function validate(Request $request, $formKey = 'default', $requireMath = true)
    {
        // 1. Honeypot traps: automated bots fill all inputs they see
        $honeypots = ['website_hp', 'newsletter_hp', 'company_url_hp', 'fax_number_hp'];
        foreach ($honeypots as $hp) {
            if ($request->filled($hp) && trim($request->input($hp)) !== '') {
                return [
                    'success' => false,
                    'message' => 'Spam detected: automated bot submission blocked.',
                ];
            }
        }

        // 2. Time-lock check: humans take > 1.5 seconds to fill forms
        $timeToken = $request->input('_form_time') ?? $request->input('_form_rendered_at');
        if (!empty($timeToken)) {
            try {
                $renderedTime = Crypt::decrypt($timeToken);
                if (is_numeric($renderedTime) && (time() - $renderedTime) < 1.5) {
                    return [
                        'success' => false,
                        'message' => 'Form submitted too quickly. Please take a moment to review and submit again.',
                    ];
                }
            } catch (\Throwable $e) {
                return [
                    'success' => false,
                    'message' => 'Security token invalid or expired. Please reload the page and try again.',
                ];
            }
        }

        // 3. Math Security Verification
        if ($requireMath) {
            $userAnswerRaw = $request->input('captcha_answer');
            if ($userAnswerRaw === null || trim($userAnswerRaw) === '') {
                return [
                    'success' => false,
                    'message' => 'Please solve the security verification question (e.g. math answer) to confirm you are human.',
                ];
            }

            $userAnswer = intval(trim($userAnswerRaw));
            $matched = false;

            // Method A: Decrypt token
            $captchaToken = $request->input('captcha_token');
            if (!empty($captchaToken)) {
                try {
                    $payload = Crypt::decrypt($captchaToken);
                    if (is_array($payload) && isset($payload['ans'])) {
                        // Challenge expires after 45 minutes
                        if (time() - ($payload['time'] ?? 0) <= 2700) {
                            if (intval($payload['ans']) === $userAnswer) {
                                $matched = true;
                            }
                        }
                    }
                } catch (\Throwable $e) {
                    // Decrypt failed
                }
            }

            // Method B: Session fallback
            if (!$matched && session()->has("bot_challenge_{$formKey}")) {
                if (intval(session()->get("bot_challenge_{$formKey}")) === $userAnswer) {
                    $matched = true;
                }
            }

            if (!$matched) {
                return [
                    'success' => false,
                    'message' => 'Incorrect answer to the security verification question. Please try again.',
                ];
            }
        }

        // 4. Rate Limiter: Max 10 submissions per minute per IP
        $ip = $request->ip() ?? 'unknown';
        $rateKey = 'bot_rate_limit:' . md5($ip . '_' . $formKey);
        if (RateLimiter::tooManyAttempts($rateKey, 10)) {
            $seconds = RateLimiter::availableIn($rateKey);
            return [
                'success' => false,
                'message' => "Too many submissions from this connection. Please wait {$seconds} seconds before trying again.",
            ];
        }
        RateLimiter::hit($rateKey, 60);

        return ['success' => true, 'message' => null];
    }
}

