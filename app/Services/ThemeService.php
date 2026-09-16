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

        $headerConfig = (!empty($setting['header_config']) && is_string($setting['header_config'])) ? json_decode($setting['header_config'], true) : [];
        if (!is_array($headerConfig)) $headerConfig = [];
        $headerConfig = array_merge([
            'show_search' => true,
            'show_cart' => true,
            'announcement_bar' => 'Welcome to our online store! Fast delivery across Bangladesh.'
        ], $headerConfig);

        $heroConfig = (!empty($setting['hero_config']) && is_string($setting['hero_config'])) ? json_decode($setting['hero_config'], true) : [];
        if (!is_array($heroConfig)) $heroConfig = [];
        $heroConfig = array_merge([
            'title' => 'Quality Products Delivered Fast',
            'subtitle' => 'Browse our latest collection with best price guarantee.',
            'button_text' => 'Shop Now',
            'button_link' => '#products',
            'bg_image' => ''
        ], $heroConfig);

        $sectionOrder = (!empty($setting['section_order']) && is_string($setting['section_order'])) ? json_decode($setting['section_order'], true) : [];
        if (!is_array($sectionOrder) || empty($sectionOrder)) {
            $sectionOrder = ['hero', 'categories', 'featured_products', 'new_arrivals', 'footer'];
        }

        $footerConfig = (!empty($setting['footer_config']) && is_string($setting['footer_config'])) ? json_decode($setting['footer_config'], true) : [];
        if (!is_array($footerConfig)) $footerConfig = [];
        $footerConfig = array_merge([
            'copyright_text' => 'All rights reserved.',
            'show_social_links' => true,
            'facebook_url' => '',
            'instagram_url' => ''
        ], $footerConfig);

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
