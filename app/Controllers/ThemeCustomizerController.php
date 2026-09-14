<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Theme;
use App\Models\ThemeSetting;
use App\Models\StoreSetting;
use App\Services\ThemeService;
use App\Middleware\TenantMiddleware;
use App\Middleware\CSRFMiddleware;

class ThemeCustomizerController extends Controller {
    private Theme $themeModel;
    private ThemeSetting $themeSettingModel;
    private StoreSetting $storeSettingModel;
    private ThemeService $themeService;

    public function __construct() {
        $this->themeModel = new Theme();
        $this->themeSettingModel = new ThemeSetting();
        $this->storeSettingModel = new StoreSetting();
        $this->themeService = new ThemeService();
    }

    public function index(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;

        $themes = $this->themeModel->getActiveThemes();
        $themeConfig = $this->themeService->getStoreThemeConfig($store['id']);
        $storeSettings = $this->storeSettingModel->findByStoreId($store['id']);

        $this->view('dashboard.customize-theme', [
            'pageTitle' => 'Customize Theme - ' . sanitize($store['name']),
            'store' => $store,
            'themes' => $themes,
            'themeConfig' => $themeConfig,
            'storeSettings' => $storeSettings,
            'success' => $_SESSION['flash_success'] ?? null,
            'error' => $_SESSION['flash_error'] ?? null
        ], 'dashboard.layout');
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);
    }

    public function update(): void {
        $store = TenantMiddleware::handle();
        if (!$store) return;
        CSRFMiddleware::handle();

        $themeId = (int)($_POST['theme_id'] ?? 1);
        $primaryColor = trim($_POST['primary_color'] ?? '#059669');
        $secondaryColor = trim($_POST['secondary_color'] ?? '#eab308');

        $headerConfig = [
            'show_search' => isset($_POST['show_search']),
            'show_cart' => isset($_POST['show_cart']),
            'announcement_bar' => trim($_POST['announcement_bar'] ?? '')
        ];

        $heroConfig = [
            'title' => trim($_POST['hero_title'] ?? 'Quality Products Delivered Fast'),
            'subtitle' => trim($_POST['hero_subtitle'] ?? ''),
            'button_text' => trim($_POST['hero_button_text'] ?? 'Shop Now'),
            'button_link' => trim($_POST['hero_button_link'] ?? '#products')
        ];

        $sectionOrder = [
            'hero', 'categories', 'featured_products', 'new_arrivals', 'footer'
        ];

        $footerConfig = [
            'copyright_text' => trim($_POST['copyright_text'] ?? ''),
            'facebook_url' => trim($_POST['facebook_url'] ?? ''),
            'instagram_url' => trim($_POST['instagram_url'] ?? '')
        ];

        // Update Theme Settings
        $this->themeSettingModel->updateOrCreateForStore(
            $store['id'],
            $themeId,
            $headerConfig,
            $heroConfig,
            $sectionOrder,
            $footerConfig
        );

        // Update Store Brand Colors
        $stmt = $this->storeSettingModel->getDb()->prepare("UPDATE store_settings SET primary_color = ?, secondary_color = ? WHERE store_id = ?");
        $stmt->execute([$primaryColor, $secondaryColor, $store['id']]);

        $_SESSION['flash_success'] = 'Theme settings and brand styling updated successfully!';
        redirect('/dashboard/customize-theme');
    }
}
