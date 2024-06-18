<?php
namespace Models;

use App\Database;

class BillingModel {
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getBillingPlans() {
        $query = "SELECT * FROM billing";
        $stmt = $this->db->getConnection()->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function retrieveSubscription($userId) {
        // Query to retrieve the billing type for the specified user.
        $query = "SELECT b.bills AS bill_type_name FROM user u
                  LEFT JOIN billing b ON u.bill_type = b.id
                  WHERE u.id = ?";
        // Prepare and execute the query.
        $stmt = $this->db->getConnection()->prepare($query);
        if ($stmt->execute([$userId])) {
            // Fetch the result.
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            $_SESSION['bill_plan'] = $result['bill_type_name'] ?? 'Unknown';
        } else {
            // Handle query execution failure.
            echo 'Failed to retrieve billing type.';
        }
    }

    public function createSubscription($userId, $planId) {
        // Save the selected plan to the user's profile
        $query = "UPDATE user SET bill_type = ? WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($query);
        return $stmt->execute([$planId, $userId]);
    }

    // Add more methods to handle Stripe subscription creation and payment processing
    public function createStripeSubscription($customerId, $planId) {
        // Use Stripe API to create subscription
        try {
            \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

            $subscription = \Stripe\Subscription::create([
                'customer' => $customerId,
                'items' => [['plan' => $planId]],
            ]);

            return $subscription;
        } catch (\Exception $e) {
            // Handle Stripe API exception
            echo 'Subscription creation failed: ' . $e->getMessage();
            return false;
        }
    }
}