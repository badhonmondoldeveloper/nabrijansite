-- Nabrijan Initial Seed Data

-- 1. Default Super Admin User (Password: SuperAdmin123!)
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `status`, `email_verified_at`) VALUES
(1, 'Super Admin', 'admin@nabrijan.site', '01700000000', '$2y$12$nwch8VvBd7kzlBt8sqhiCOHGUHaqs2A2TphhfpVjUmOIsJbmXQ.fW', 'super_admin', 'active', NOW());

-- 2. SaaS Subscription Plans
INSERT INTO `plans` (`id`, `name`, `slug`, `price`, `product_limit`, `theme_limit`, `custom_domain_allowed`, `analytics_allowed`, `is_active`) VALUES
(1, 'FREE', 'free', 0.00, 10, 1, 0, 0, 1),
(2, 'STARTER', 'starter', 499.00, 100, 2, 0, 1, 1),
(3, 'BUSINESS', 'business', 999.00, 500, 5, 1, 1, 1),
(4, 'PRO', 'pro', 1999.00, 99999, 10, 1, 1, 1);

-- 3. Default Themes
INSERT INTO `themes` (`id`, `name`, `slug`, `folder_name`, `preview_image`, `is_active`) VALUES
(1, 'Minimal', 'minimal', 'minimal', '/assets/images/themes/minimal.png', 1),
(2, 'Fashion', 'fashion', 'fashion', '/assets/images/themes/fashion.png', 1),
(3, 'Electronics', 'electronics', 'electronics', '/assets/images/themes/electronics.png', 1),
(4, 'Grocery', 'grocery', 'grocery', '/assets/images/themes/grocery.png', 1);
