<?php

namespace App\Services;

use App\Models\Theme;
use App\Models\ThemeSetting;

class ThemeService {
    private Theme $themeModel;
    private ThemeSetting $themeSettingModel;

    public function __construct() {
        $this->themeModel = new Theme();
        $this->themeSettingModel = new ThemeSetting();
    }

    /**
     * Resolve active theme configuration array for a store.
     */
    public function getStoreThemeConfig(int $storeId): array {
        $setting = $this->themeSettingModel->findByStoreId($storeId);

        $defaultTheme = 'minimal';
        $themeId = 1;
        if ($setting) {
            $defaultTheme = $setting['folder_name'] ?? 'minimal';
            $themeId = (int)$setting['theme_id'];
        }

        $headerConfig = !empty($setting['header_config']) ? json_decode($setting['header_config'], true) : [
            'show_search' => true,
            'show_cart' => true,
            'announcement_bar' => 'Welcome to our online store! Fast delivery across Bangladesh.'
        ];

        $heroConfig = !empty($setting['hero_config']) ? json_decode($setting['hero_config'], true) : [
            'title' => 'Quality Products Delivered Fast',
            'subtitle' => 'Browse our latest collection with best price guarantee.',
            'button_text' => 'Shop Now',
            'button_link' => '#products',
            'bg_image' => ''
        ];

        $sectionOrder = !empty($setting['section_order']) ? json_decode($setting['section_order'], true) : [
            'hero', 'categories', 'featured_products', 'new_arrivals', 'footer'
        ];

        $footerConfig = !empty($setting['footer_config']) ? json_decode($setting['footer_config'], true) : [
            'copyright_text' => 'All rights reserved.',
            'show_social_links' => true,
            'facebook_url' => '',
            'instagram_url' => ''
        ];

        return [
            'theme_id' => $themeId,
            'theme_folder' => $defaultTheme,
            'header' => $headerConfig,
            'hero' => $heroConfig,
            'sections' => $sectionOrder,
            'footer' => $footerConfig
        ];
    }
}
