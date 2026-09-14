<?php

namespace App\Controllers\Api\V1;

use App\Core\Controller;

class HealthApiController extends Controller {
    public function index(): void {
        $this->success('Nabrijan SaaS API is running successfully.', [
            'app_name' => config('app.name'),
            'version' => '1.0.0',
            'environment' => config('app.env'),
            'timezone' => config('app.timezone'),
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }
}
