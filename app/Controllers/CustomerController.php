<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Customer;
use App\Middleware\TenantMiddleware;

class CustomerController extends Controller {
    private Customer $customerModel;

    public function __construct() {
        $this->customerModel = new Customer();
    }

    public function index(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $customers = $this->customerModel->getCustomersWithStats($store['id']);

        $this->view('dashboard.customers.index', [
            'pageTitle' => 'Customer List - ' . sanitize($store['name']),
            'store' => $store,
            'customers' => $customers
        ], 'dashboard.layout');
    }
}
