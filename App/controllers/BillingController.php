<?php
namespace Controllers;

use Models\BillingModel;
use Views\BillingView;

class BillingController {
    protected $billModel;
    protected $billView;

    public function __construct() {
        $this->billModel = new BillingModel();
        $this->billView = new BillingView();
    }

    public function displayBillingType() {
        $userId = $_SESSION['user_id'] ?? null;
        if ($userId) {
            $this->billModel->retrieveSubscription($userId);
            $billingPlans = $this->billModel->getBillingPlans();
            $this->billView->renderBillingType($billingPlans);
        } else {
            echo 'User ID not found.';
        }
    }

    public function createSubscription($planId) {
        $userId = $_SESSION['user_id'] ?? null;
        if ($userId) {
            // Create subscription in your database
            if ($this->billModel->createSubscription($userId, $planId)) {
                // Optionally, create subscription in Stripe
                // Replace 'customer_id' with actual Stripe customer ID
                // $this->billModel->createStripeSubscription('customer_id', $planId);
                
                echo 'Subscription created successfully.';
            } else {
                echo 'Failed to create subscription.';
            }
        } else {
            echo 'User ID not found.';
        }
    }

    public function processPayment() {
        // Retrieve the token sent from the frontend
        $token = $_POST['stripeToken'] ?? null;

        if ($token) {
            // Pass the token to your BillingModel to handle payment processing
            $result = $this->billModel->processPayment($token);

            if ($result) {
                echo 'Payment processed successfully.';
            } else {
                echo 'Failed to process payment.';
            }
        } else {
            echo 'Stripe token not found.';
        }
    }
}