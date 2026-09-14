<!-- Minimal Theme Footer -->
<footer class="bg-dark text-secondary py-4 border-top border-secondary mt-5">
    <div class="container text-center">
        <p class="mb-2"><?= sanitize($themeConfig['footer']['copyright_text'] ?? ('© ' . date('Y') . ' ' . $store['name'] . '. Powered by Nabrijan SaaS.')) ?></p>
        <div class="d-flex justify-content-center gap-3">
            <?php if (!empty($themeConfig['footer']['facebook_url'])): ?>
                <a href="<?= sanitize($themeConfig['footer']['facebook_url']) ?>" target="_blank" class="text-secondary fs-5"><i class="bi bi-facebook"></i></a>
            <?php endif; ?>
            <?php if (!empty($themeConfig['footer']['instagram_url'])): ?>
                <a href="<?= sanitize($themeConfig['footer']['instagram_url']) ?>" target="_blank" class="text-secondary fs-5"><i class="bi bi-instagram"></i></a>
            <?php endif; ?>
        </div>
    </div>
</footer>
