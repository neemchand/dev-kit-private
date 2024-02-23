<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class PasswordValidationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Eliminating consecutive identical chars, as per NIST Special Publication 800-63B section 5.1.1.2:
        $this->extendPasswordValidatorWithConsecutiveCharsRule();

        // Eliminating sequential increasing/decreasing chars, as per NIST Special Publication 800-63B section 5.1.1.2:
        $this->extendPasswordValidatorWithSequentialCharsRule();

        $this->extendPasswordValidatorWithKeyboardSequenceRule();
        $this->extendPasswordValidatorWithCurrentPasswordRule();
        $this->extendPasswordValidatorWithEmailRule();

        Password::defaults(function () {
            return Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->rules([
                    'not_current',
                    'no_email',
                    'max_consecutive:2',
                    'max_sequential:2',
                    'max_keyboard_sequential:4'
                ])
                ->uncompromised(5);
        });
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    private function extendPasswordValidatorWithConsecutiveCharsRule(): void
    {
        Validator::extend('max_consecutive', function ($attribute, $value, $parameters, $validator) {
            $maxConsecutiveChars = $parameters[0] ?? 2;
            return !preg_match('/([a-zA-Z0-9])\1{' . $maxConsecutiveChars . ',}/', $value);
        });

        Validator::replacer('max_consecutive', function ($message, $attribute, $rule, $parameters) {
            $maxConsecutiveChars = $parameters[0] ?? 2;
            return __('passwords.consecutive_chars', ['count' => $maxConsecutiveChars]);
        });
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    private function extendPasswordValidatorWithSequentialCharsRule(): void
    {
        Validator::extend('max_sequential', function ($attribute, $value, $parameters, $validator) {
            $maxSequentialChars = $parameters[0] ?? 2;

            for ($i = 0, $loopLength = strlen($value) - $maxSequentialChars; $i < $loopLength; $i++) {
                $increasing = true;
                $decreasing = true;

                for ($j = 0; $j < $maxSequentialChars; $j++) {
                    $increasing = ord($value[$i + $j]) === ord($value[$i + $j + 1]) + 1;
                    $decreasing = ord($value[$i + $j]) === ord($value[$i + $j + 1]) - 1;

                    if (!$increasing && !$decreasing) {
                        break;
                    }
                }
                if ($increasing || $decreasing) {
                    return false;
                }
            }
            return true;
        });

        Validator::replacer('max_sequential', function ($message, $attribute, $rule, $parameters) {
            $maxSequentialChars = $parameters[0] ?? 2;
            return __('passwords.sequential_chars', ['count' => $maxSequentialChars]);
        });
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    private function extendPasswordValidatorWithKeyboardSequenceRule(): void
    {
        Validator::extend('max_keyboard_sequential', function ($attribute, $value, $parameters, $validator) {
            $maxKeyboardChars = $parameters[0] ?? 2;
            // currently QWERTY keyboard only
            $keyboardSequences = [
                '~!@#$%^&*()_+',
                'qwertyuiop[]\\',
                'QWERTYUIOP{}|',
                'asdfghjkl;\'',
                'ASDFGHJKL:"',
                'zxcvbnm,./',
                'ZXCVBNM<>?'
            ];

            foreach ($keyboardSequences as $sequence) {
                if (strlen($sequence) <= $maxKeyboardChars) {
                    continue;
                }

                for ($i = 0, $loopLength = strlen($sequence) - $maxKeyboardChars; $i < $loopLength; $i++) {
                    if (str_contains($value, substr($sequence, $i, $maxKeyboardChars + 1))) {
                        return false;
                    }
                    if (str_contains($value, strrev(substr($sequence, $i, $maxKeyboardChars + 1)))) {
                        return false;
                    }
                }
            }

            return true;
        });

        Validator::replacer('max_keyboard_sequential', function ($message, $attribute, $rule, $parameters) {
            $maxKeyboardChars = $parameters[0] ?? 2;
            return __('passwords.keyboard_sequential_chars', ['count' => $maxKeyboardChars]);
        });
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    private function extendPasswordValidatorWithCurrentPasswordRule()
    {
        Validator::extend('not_current', function ($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            if (!isset($data['current_' . $attribute])) {
                return true; // when "current_*" attribute is not required, skip rule
            }

            $current = $data['current_' . $attribute];
            return $value !== $current;
        });

        Validator::replacer('not_current', function ($message, $attribute, $rule, $parameters) {
            return __('passwords.equals_current');
        });
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    private function extendPasswordValidatorWithEmailRule()
    {
        Validator::extend('no_email', function ($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            if (!isset($data['email'])) {
                return true; // when "email" attribute is not required, skip rule
            }

            $email_prefix = explode('@', $data['email'])[0];
            return !str_contains(strtolower($value), strtolower($email_prefix));
        });

        Validator::replacer('no_email', function ($message, $attribute, $rule, $parameters) {
            return __('passwords.contains_email');
        });
    }
}
