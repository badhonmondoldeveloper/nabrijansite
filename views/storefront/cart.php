<div class="container py-5">
    <h3 class="fw-bold text-light mb-4"><i class="bi bi-cart3 me-2 text-warning"></i> Shopping Cart</h3>

    <?php if (empty($cart['items'])): ?>
        <div class="card-custom p-5 text-center">
            <i class="bi bi-cart-x fs-1 text-secondary d-block mb-3"></i>
            <h4>Your Cart is Empty</h4>
            <p class="text-secondary mb-4">Browse our catalog to add products to your shopping cart.</p>
            <a href="/store/<?= sanitize($store['slug']) ?>" class="btn btn-brand px-4 py-2">Continue Shopping</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card-custom p-3">
                    <div class="table-responsive">
                        <table class="table table-dark align-middle mb-0">
                            <thead>
                                <tr class="text-secondary small">
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
                                                    <img src="<?= sanitize($item['image']) ?>" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                                <?php endif; ?>
                                                <div>
                                                    <a href="/store/<?= sanitize($store['slug']) ?>/product/<?= sanitize($item['slug']) ?>" class="fw-bold text-light text-decoration-none"><?= sanitize($item['name']) ?></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= format_bdt($item['unit_price']) ?></td>
                                        <td>
                                            <form action="/store/<?= sanitize($store['slug']) ?>/cart/update" method="POST" class="d-flex align-items-center gap-1" style="width: 120px;">
                                                <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>" class="form-control form-control-sm bg-dark text-light border-secondary">
                                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Update Quantity"><i class="bi bi-check-lg"></i></button>
                                            </form>
                                        </td>
                                        <td class="fw-bold text-success"><?= format_bdt($item['total_price']) ?></td>
                                        <td>
                                            <form action="/store/<?= sanitize($store['slug']) ?>/cart/remove" method="POST">
                                                <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
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
                <div class="card-custom p-4">
                    <h5 class="fw-bold text-light mb-3">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-2 text-secondary">
                        <span>Subtotal</span>
                        <span class="text-light fw-bold"><?= format_bdt($cart['subtotal']) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 text-secondary">
                        <span>Estimated Shipping</span>
                        <span class="text-warning">Calculated at checkout</span>
                    </div>
                    <hr class="border-secondary mb-3">
                    <a href="/store/<?= sanitize($store['slug']) ?>/checkout" class="btn btn-brand w-100 py-2 fw-bold">Proceed To Checkout</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
