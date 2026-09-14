<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">System Settings</h4>
        <p class="text-secondary small mb-0">Platform configuration, default localization, and cPanel environment parameters.</p>
    </div>
</div>

<div class="card-custom max-w-700">
    <form action="/admin/settings" method="POST">
        <input type="hidden" name="_csrf_token" value="<?= \App\Helpers\Security::generateCsrfToken() ?>">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="site_name" class="form-label text-secondary">SaaS Platform Name</label>
                <input type="text" class="form-control bg-dark text-light border-secondary" id="site_name" name="site_name" value="Nabrijan">
            </div>
            <div class="col-md-6 mb-3">
                <label for="support_email" class="form-label text-secondary">Support Email</label>
                <input type="email" class="form-control bg-dark text-light border-secondary" id="support_email" name="support_email" value="support@nabrijan.site">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="currency" class="form-label text-secondary">Default Currency</label>
                <input type="text" class="form-control bg-dark text-light border-secondary" id="currency" name="currency" value="BDT (৳)" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="timezone" class="form-label text-secondary">Platform Timezone</label>
                <input type="text" class="form-control bg-dark text-light border-secondary" id="timezone" name="timezone" value="Asia/Dhaka" readonly>
            </div>
        </div>
        <button type="button" class="btn btn-success" onclick="alert('Platform system settings saved successfully.')">Save System Settings</button>
    </form>
</div>
