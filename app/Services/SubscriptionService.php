<?php

namespace App\Services;

use Laravel\Cashier\PaymentMethod;

class SubscriptionService
{
    public function getPaymentDetails(PaymentMethod $paymentMethod): array
    {
        $paymentDetails = [];
        if ($paymentMethod->type === 'card') {
            $card = $paymentMethod->card;
            $paymentDetails = [
                'brand' => $card->brand,
                'exp_month' => $card->exp_month,
                'exp_year' => $card->exp_year,
                'last_4' => $card->last4
            ];
        }
        return $paymentDetails;
    }
}
