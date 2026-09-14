<?php

namespace App\Services;

use App\Models\Coupon;

class CouponService {
    private Coupon $couponModel;

    public function __construct() {
        $this->couponModel = new Coupon();
    }

    public function validateAndCalculate(string $code, int $storeId, float $subtotal): array {
        $coupon = $this->couponModel->findByCodeForStore($code, $storeId);

        if (!$coupon) {
            return ['valid' => false, 'message' => 'Invalid or inactive coupon code.'];
        }

        // Date validation
        $now = date('Y-m-d H:i:s');
        if (!empty($coupon['start_date']) && $coupon['start_date'] > $now) {
            return ['valid' => false, 'message' => 'Coupon is not yet active.'];
        }
        if (!empty($coupon['end_date']) && $coupon['end_date'] < $now) {
            return ['valid' => false, 'message' => 'Coupon code has expired.'];
        }

        // Usage Limit validation
        if ($coupon['usage_limit'] !== null && $coupon['used_count'] >= $coupon['usage_limit']) {
            return ['valid' => false, 'message' => 'Coupon usage limit reached.'];
        }

        // Minimum order amount validation
        if ($subtotal < (float)$coupon['min_order_amount']) {
            return ['valid' => false, 'message' => 'Minimum order amount for this coupon is ৳' . number_format($coupon['min_order_amount'], 2)];
        }

        // Calculate discount
        $discount = 0.00;
        if ($coupon['type'] === 'percentage') {
            $discount = ($subtotal * (float)$coupon['discount_value']) / 100;
            if (!empty($coupon['max_discount_amount'])) {
                $discount = min($discount, (float)$coupon['max_discount_amount']);
            }
        } else {
            $discount = (float)$coupon['discount_value'];
        }

        $discount = min($discount, $subtotal); // Cannot exceed subtotal

        return [
            'valid' => true,
            'coupon_id' => $coupon['id'],
            'code' => $coupon['code'],
            'discount_amount' => $discount
        ];
    }
}
