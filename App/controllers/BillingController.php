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
            $this->billView->renderBillingType();
        } else {
            echo 'User ID not found.';
        }
    }

        /*
     * Handle subscription creation.
     * Add method description here.
     */
    public function createSubscription() {
        // Add logic to handle subscription creation here.
        // Example: $this->billModel->createSubscription();
    }

    /*
     * Handle payment processing.
     * Add method description here.
     */
    public function processPayment() {
        // Add logic to handle payment processing here.
        // Example: $this->billModel->processPayment();
    }
}
