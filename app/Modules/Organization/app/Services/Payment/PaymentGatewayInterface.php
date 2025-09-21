<?php

namespace App\Modules\Organization\app\Services\Payment;

interface PaymentGatewayInterface
{
    /**
     * Initialize payment gateway with organization settings
     */
    public function initialize(array $settings): void;

    /**
     * Process a payment
     */
    public function processPayment(float $amount, array $data = []): array;

    /**
     * Validate gateway settings
     */
    public function validateSettings(array $settings): bool;

    /**
     * Get required settings fields
     */
    public function getRequiredSettings(): array;

    /**
     * Handle payment webhook
     */
    public function handleWebhook(array $payload): array;
}
