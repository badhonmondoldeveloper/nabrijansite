<div class="container py-4">
    <h3 class="fw-bold mb-4"><i class="bi bi-bag-check me-2 text-success"></i> Shopping Cart</h3>

    <?php if (empty($cart['items'])): ?>
        <div class="bg-white border rounded-4 p-5 text-center shadow-sm">
            <i class="bi bi-cart-x fs-1 text-muted d-block mb-3"></i>
            <h4 class="fw-bold">Your Cart is Empty</h4>
            <p class="text-muted mb-4">Browse our collection to add items to your shopping cart.</p>
            <a href="/store/<?= sanitize($store['slug']) ?>" class="btn btn-success px-4 py-2.5 fw-bold rounded-pill">Continue Shopping</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="bg-white border rounded-4 p-3 shadow-sm">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr class="text-muted small">
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart['items'] as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <?php if (!empty($item['image'])): ?>
                                                    <img src="<?= sanitize($item['image']) ?>" class="rounded" style="width: 54px; height: 54px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 54px; height: 54px;">
                                                        <i class="bi bi-image"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <a href="/store/<?= sanitize($store['slug']) ?>/product/<?= sanitize($item['slug']) ?>" class="fw-bold text-dark text-decoration-none"><?= sanitize($item['name']) ?></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-semibold"><?= format_bdt($item['unit_price']) ?></td>
                                        <td>
                                            <form action="/store/<?= sanitize($store['slug']) ?>/cart/update" method="POST" class="d-flex align-items-center gap-1" style="width: 120px;">
                                                <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>" class="form-control form-control-sm text-center font-weight-bold">
                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Update"><i class="bi bi-check-lg"></i></button>
                                            </form>
                                        </td>
                                        <td class="fw-bold text-success"><?= format_bdt($item['total_price']) ?></td>
                                        <td>
                                            <form action="/store/<?= sanitize($store['slug']) ?>/cart/remove" method="POST">
                                                <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger border-0"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="bg-white border rounded-4 p-4 shadow-sm">
                    <h5 class="fw-bold mb-3">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-2 text-muted">
                        <span>Subtotal</span>
                        <span class="text-dark fw-bold"><?= format_bdt($cart['subtotal']) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 text-muted">
                        <span>Shipping Charge</span>
                        <span class="text-success small">Calculated at checkout</span>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex justify-content-between mb-4 fs-5 fw-bold">
                        <span>Subtotal</span>
                        <span class="text-success"><?= format_bdt($cart['subtotal']) ?></span>
                    </div>
                    <a href="/store/<?= sanitize($store['slug']) ?>/checkout" class="btn btn-success w-100 py-3 fw-bold rounded-pill fs-6">Proceed To Checkout</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
