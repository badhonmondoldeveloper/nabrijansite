<div class="container py-5 my-5 text-center">
    <div class="store-pdp-card max-w-600 mx-auto p-4 p-md-5">
        <div class="mb-3">
            <i class="bi bi-box-seam fs-1 text-muted"></i>
        </div>
        <h2 class="fw-bold mb-2">Product Not Found</h2>
        <p class="text-muted mb-4">The product you are looking for is no longer available or may have been removed.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="/store/<?= sanitize($store['slug']) ?>" class="btn btn-success btn-lg fw-bold rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i> Back to Shop
            </a>
            <a href="/store/<?= sanitize($store['slug']) ?>#products" class="btn btn-outline-secondary btn-lg fw-bold rounded-pill px-4">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
