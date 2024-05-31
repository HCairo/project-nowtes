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

    // public function () {}
}