<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title data-i18n="page_title">NABRIJAN — Build, Launch & Grow Your Online Store in Bangladesh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/nabrijan-design-system.css">
    <style>
        :root {
            --brand-green: #087A4B;
            --brand-green-hover: #06633D;
            --brand-green-soft: #E7F8EF;
            --accent-yellow: #D8F34A;
            --accent-yellow-dark: #B8D628;
            --neutral-bg: #F7F9F7;
            --neutral-surface: #FFFFFF;
            --text-dark: #0F172A;
            --text-muted: #64748B;
            --border-light: #E2E8F0;
        }

        body {
            background-color: var(--neutral-bg);
            color: var(--text-dark);
            font-family: 'Inter', 'Noto Sans Bengali', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
        }

        /* Responsive Navbar */
        .nj-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-light);
            position: sticky;
            top: 0;
            z-index: 1040;
            padding: 14px 0;
        }

        .nj-brand-logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--brand-green);
            text-decoration: none;
            letter-spacing: -0.03em;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nj-nav-link {
            color: var(--text-dark);
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 6px;
            transition: color 0.2s;
        }

        .nj-nav-link:hover {
            color: var(--brand-green);
        }

        /* Hero Section */
        .nj-hero {
            padding: 60px 0 80px 0;
            background: linear-gradient(180deg, #FFFFFF 0%, var(--neutral-bg) 100%);
        }

        .nj-hero-title {
            font-size: clamp(2.2rem, 5vw, 3.5rem);
            font-weight: 800;
            line-height: 1.15;
            color: var(--text-dark);
            letter-spacing: -0.03em;
        }

        .nj-hero-title span {
            color: var(--brand-green);
        }

        .nj-hero-subtitle {
            font-size: clamp(1rem, 2vw, 1.2rem);
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 32px;
            max-width: 600px;
        }

        .btn-brand-primary {
            background-color: var(--brand-green);
            color: #FFFFFF !important;
            font-weight: 700;
            padding: 14px 28px;
            border-radius: 50px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(8, 122, 75, 0.25);
            border: none;
        }

        .btn-brand-primary:hover {
            background-color: var(--brand-green-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(8, 122, 75, 0.35);
        }

        .btn-brand-accent {
            background-color: var(--accent-yellow);
            color: #071A13 !important;
            font-weight: 700;
            padding: 14px 28px;
            border-radius: 50px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(216, 243, 74, 0.3);
            border: none;
        }

        .btn-brand-accent:hover {
            background-color: var(--accent-yellow-dark);
            transform: translateY(-2px);
        }

        .btn-brand-secondary {
            background-color: #FFFFFF;
            color: var(--text-dark) !important;
            font-weight: 600;
            padding: 14px 28px;
            border-radius: 50px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--border-light);
            transition: all 0.2s;
        }

        .btn-brand-secondary:hover {
            background-color: var(--neutral-bg);
            border-color: var(--brand-green);
            color: var(--brand-green) !important;
        }

        /* UI Preview Card */
        .nj-hero-preview-card {
            background: #FFFFFF;
            border: 1px solid var(--border-light);
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .nj-preview-header {
            background: #F8FAFC;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nj-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        /* Trust Strip */
        .nj-trust-strip {
            background: #FFFFFF;
            border-y: 1px solid var(--border-light);
            padding: 24px 0;
        }

        .nj-trust-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-dark);
        }

        /* Features Section */
        .nj-feature-card {
            background: #FFFFFF;
            border: 1px solid var(--border-light);
            border-radius: 16px;
            padding: 28px 24px;
            height: 100%;
            transition: all 0.2s;
        }

        .nj-feature-card:hover {
            transform: translateY(-4px);
            border-color: var(--brand-green);
            box-shadow: 0 12px 24px rgba(8, 122, 75, 0.08);
        }

        .nj-feature-icon {
            width: 48px;
            height: 48px;
            background: var(--brand-green-soft);
            color: var(--brand-green);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 18px;
        }

        /* How It Works Steps */
        .nj-step-card {
            background: #FFFFFF;
            border: 1px solid var(--border-light);
            border-radius: 16px;
            padding: 32px 24px;
            text-align: center;
            position: relative;
            height: 100%;
        }

        .nj-step-number {
            width: 44px;
            height: 44px;
            background: var(--brand-green);
            color: #FFFFFF;
            font-weight: 800;
            font-size: 1.1rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
        }

        /* Final CTA Card */
        .nj-cta-card {
            background: linear-gradient(135deg, var(--brand-green) 0%, #054B2F 100%);
            border-radius: 24px;
            color: #FFFFFF;
            padding: 60px 32px;
            text-align: center;
        }

        /* Footer */
        .nj-footer {
            background: #0F172A;
            color: #94A3B8;
            padding: 60px 0 30px 0;
            font-size: 0.9rem;
        }

        .nj-footer a {
            color: #94A3B8;
            text-decoration: none;
            transition: color 0.2s;
        }

        .nj-footer a:hover {
            color: #FFFFFF;
        }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <header class="nj-navbar">
        <div class="nj-container d-flex align-items-center justify-content-between">
            <a href="/" class="nj-brand-logo">
                <i class="bi bi-shop text-success"></i> NABRIJAN
            </a>

            <!-- Desktop Links -->
            <nav class="d-none d-lg-flex align-items-center gap-3">
                <a href="/" class="nj-nav-link" data-i18n="nav_home">Home</a>
                <a href="#features" class="nj-nav-link" data-i18n="nav_features">Features</a>
                <a href="#how-it-works" class="nj-nav-link" data-i18n="nav_how_it_works">How It Works</a>
                <a href="#showcase" class="nj-nav-link" data-i18n="nav_showcase">Showcase</a>
                <a href="#pricing" class="nj-nav-link" data-i18n="nav_pricing">Pricing</a>
                <a href="#about" class="nj-nav-link" data-i18n="nav_about">About</a>
                <a href="#contact" class="nj-nav-link" data-i18n="nav_contact">Contact</a>
            </nav>

            <!-- Actions & Language -->
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="lang-toggle-btn" onclick="toggleLanguage()">
                    <span id="langFlag">🇬🇧</span> <span id="langText">English</span>
                </button>
                <a href="/login" class="btn btn-link text-dark fw-bold text-decoration-none d-none d-sm-inline-block" data-i18n="nav_login">Sign In</a>
                <a href="/register" class="btn-brand-primary py-2 px-3 fs-6" data-i18n="nav_get_started">Get Started</a>

                <!-- Mobile Hamburger Button -->
                <button class="btn d-lg-none p-1 ms-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenuOffcanvas">
                    <i class="bi bi-list fs-2 text-dark"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Offcanvas Menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenuOffcanvas">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold text-success"><i class="bi bi-shop me-2"></i> NABRIJAN</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column gap-3">
            <a href="/" class="nj-nav-link fs-5" data-bs-dismiss="offcanvas">Home</a>
            <a href="#features" class="nj-nav-link fs-5" data-bs-dismiss="offcanvas">Features</a>
            <a href="#how-it-works" class="nj-nav-link fs-5" data-bs-dismiss="offcanvas">How It Works</a>
            <a href="#showcase" class="nj-nav-link fs-5" data-bs-dismiss="offcanvas">Showcase</a>
            <a href="#pricing" class="nj-nav-link fs-5" data-bs-dismiss="offcanvas">Pricing</a>
            <a href="#about" class="nj-nav-link fs-5" data-bs-dismiss="offcanvas">About</a>
            <a href="#contact" class="nj-nav-link fs-5" data-bs-dismiss="offcanvas">Contact</a>
            <hr>
            <a href="/login" class="btn btn-outline-dark fw-bold rounded-pill w-100 py-2.5">Sign In</a>
            <a href="/register" class="btn-brand-primary w-100 justify-content-center py-2.5">Get Started</a>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="nj-hero">
        <div class="nj-container">
            <div class="row align-items-center g-4 g-lg-5">
                <!-- Left Hero Text -->
                <div class="col-lg-6">
                    <div class="mb-3">
                        <span class="badge bg-success-subtle text-success border border-success px-3 py-1.5 rounded-pill fw-bold">
                            <i class="bi bi-check-circle-fill me-1 text-success"></i> Smart E-Commerce Platform for Bangladesh
                        </span>
                    </div>
                    <h1 class="nj-hero-title mb-3" data-i18n="hero_title">
                        Build, Launch & Grow Your <span>Online Store</span>
                    </h1>
                    <p class="nj-hero-subtitle" data-i18n="hero_subtitle">
                        Everything you need to create a modern online store, manage products, receive orders, and grow your business — built for Bangladesh.
                    </p>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <a href="/register" class="btn-brand-primary" data-i18n="hero_cta_primary">
                            Start Building <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="#features" class="btn-brand-secondary" data-i18n="hero_cta_secondary">
                            Explore Features
                        </a>
                    </div>
                </div>

                <!-- Right Hero UI Mockup -->
                <div class="col-lg-6">
                    <div class="nj-hero-preview-card">
                        <div class="nj-preview-header">
                            <div class="d-flex align-items-center gap-1.5">
                                <span class="nj-dot bg-danger"></span>
                                <span class="nj-dot bg-warning"></span>
                                <span class="nj-dot bg-success"></span>
                                <small class="text-muted ms-2" style="font-size: 0.75rem;">admin.nabrijan.site</small>
                            </div>
                            <span class="badge bg-success text-white px-2 py-0.5" style="font-size: 0.7rem;">Active Storefront</span>
                        </div>
                        <div class="p-3 p-md-4">
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="p-3 rounded border bg-light">
                                        <small class="text-muted d-block mb-1">Today's Sales</small>
                                        <div class="fw-bold fs-5 text-success">৳৪৫,২০০</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded border bg-light">
                                        <small class="text-muted d-block mb-1">Total Orders</small>
                                        <div class="fw-bold fs-5 text-dark">৬৮ Orders</div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 rounded border border-success bg-success-subtle text-dark small d-flex align-items-center justify-content-between">
                                <div>
                                    <i class="bi bi-bag-check-fill text-success me-2"></i>
                                    <strong>bKash / Nagad Instant Order Checkout Active</strong>
                                </div>
                                <span class="badge bg-success text-white">Live</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust / Value Strip -->
    <section class="nj-trust-strip">
        <div class="nj-container">
            <div class="row g-3 text-center text-md-start">
                <div class="col-6 col-md-3">
                    <div class="nj-trust-item justify-content-center justify-content-md-start">
                        <i class="bi bi-rocket-takeoff text-success fs-4"></i>
                        <span>Easy Store Setup</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="nj-trust-item justify-content-center justify-content-md-start">
                        <i class="bi bi-shield-check text-success fs-4"></i>
                        <span>Secure Orders</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="nj-trust-item justify-content-center justify-content-md-start">
                        <i class="bi bi-phone text-success fs-4"></i>
                        <span>Mobile Ready</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="nj-trust-item justify-content-center justify-content-md-start">
                        <i class="bi bi-wallet2 text-success fs-4"></i>
                        <span>BD Payments</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="nj-container py-4">
            <div class="text-center max-w-700 mx-auto mb-5">
                <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-bold mb-2">Platform Capabilities</span>
                <h2 class="fw-bold fs-2 mb-3">Everything You Need to Sell Online</h2>
                <p class="text-muted fs-6">A complete suite of tools built specifically for merchants in Bangladesh to manage products, take orders, and grow revenue.</p>
            </div>

            <div class="row g-3 g-md-4">
                <div class="col-md-6 col-lg-3">
                    <div class="nj-feature-card">
                        <div class="nj-feature-icon"><i class="bi bi-shop"></i></div>
                        <h5 class="fw-bold mb-2">Store Builder</h5>
                        <p class="text-muted small mb-0">Create your branded store front with zero coding required. Optimized for fast mobile loading.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="nj-feature-card">
                        <div class="nj-feature-icon"><i class="bi bi-box-seam"></i></div>
                        <h5 class="fw-bold mb-2">Product Management</h5>
                        <p class="text-muted small mb-0">Easily create products, upload multiple images, manage SKUs, pricing, discounts, and categories.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="nj-feature-card">
                        <div class="nj-feature-icon"><i class="bi bi-tags"></i></div>
                        <h5 class="fw-bold mb-2">Size & Color Variants</h5>
                        <p class="text-muted small mb-0">Full support for custom size and color option combinations with variant-level stock and pricing.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="nj-feature-card">
                        <div class="nj-feature-icon"><i class="bi bi-layers"></i></div>
                        <h5 class="fw-bold mb-2">Inventory Control</h5>
                        <p class="text-muted small mb-0">Real-time stock decrementing upon order placement with automated low-stock warnings.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="nj-feature-card">
                        <div class="nj-feature-icon"><i class="bi bi-cart-check"></i></div>
                        <h5 class="fw-bold mb-2">Order Management</h5>
                        <p class="text-muted small mb-0">Receive, filter, and track orders from Pending to Delivered with complete customer history.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="nj-feature-card">
                        <div class="nj-feature-icon"><i class="bi bi-wallet2"></i></div>
                        <h5 class="fw-bold mb-2">Payment Processing</h5>
                        <p class="text-muted small mb-0">Integrated Cash on Delivery, bKash, and Nagad manual payment workflows with TrxID logging.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="nj-feature-card">
                        <div class="nj-feature-icon"><i class="bi bi-bar-chart-line"></i></div>
                        <h5 class="fw-bold mb-2">Analytics & Insights</h5>
                        <p class="text-muted small mb-0">Monitor total sales revenue, order completion rate, top products, and customer trends.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="nj-feature-card">
                        <div class="nj-feature-icon"><i class="bi bi-people"></i></div>
                        <h5 class="fw-bold mb-2">Customer Management</h5>
                        <p class="text-muted small mb-0">Keep detailed records of customer contact details, spending totals, and order history.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-5 bg-white">
        <div class="nj-container py-4">
            <div class="text-center max-w-700 mx-auto mb-5">
                <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-bold mb-2">Simple 3-Step Process</span>
                <h2 class="fw-bold fs-2 mb-3">How Nabrijan Works</h2>
                <p class="text-muted fs-6">Get your business online and start receiving customer orders in minutes.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="nj-step-card">
                        <div class="nj-step-number">01</div>
                        <h4 class="fw-bold mb-2">Create Your Store</h4>
                        <p class="text-muted small mb-0">Sign up and choose your store name & slug. Your storefront is instantly live.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="nj-step-card">
                        <div class="nj-step-number">02</div>
                        <h4 class="fw-bold mb-2">Add Products</h4>
                        <p class="text-muted small mb-0">Upload product photos, set prices, add size/color variants, and organize categories.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="nj-step-card">
                        <div class="nj-step-number">03</div>
                        <h4 class="fw-bold mb-2">Start Selling</h4>
                        <p class="text-muted small mb-0">Share your store link with customers, accept bKash/COD payments, and process orders.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Storefront Showcase -->
    <section id="showcase" class="py-5">
        <div class="nj-container py-4 text-center">
            <div class="max-w-700 mx-auto mb-4">
                <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-bold mb-2">Storefront Experience</span>
                <h2 class="fw-bold fs-2 mb-3">Designed for Every Retail Industry</h2>
                <p class="text-muted fs-6">See how clean, fast, and responsive your store looks to your customers.</p>
            </div>

            <div class="d-flex justify-content-center gap-2 mb-4 flex-wrap">
                <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3 active" onclick="switchNiche('fashion')">Fashion & Clothing</button>
                <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3" onclick="switchNiche('electronics')">Electronics & Gadgets</button>
                <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3" onclick="switchNiche('grocery')">Grocery & Superstore</button>
                <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3" onclick="switchNiche('beauty')">Beauty & Cosmetics</button>
            </div>

            <div class="nj-hero-preview-card max-w-900 mx-auto">
                <div class="nj-preview-header">
                    <span class="text-muted small" id="nicheDomain">demo-fashion.nabrijan.site</span>
                    <span class="badge bg-success text-white">Live Storefront Mockup</span>
                </div>
                <div class="p-4 p-md-5 text-center bg-white" id="nichePreviewArea">
                    <h3 class="fw-bold text-success mb-2" id="nicheTitle">Trendy Fashion Store</h3>
                    <p class="text-muted mb-4" id="nicheDesc">Fast mobile shopping with instant bKash & Cash on Delivery checkout.</p>
                    <a href="/register" class="btn-brand-primary">Create Your Store Now <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Admin Dashboard Showcase Section -->
    <section class="py-5 bg-white">
        <div class="nj-container py-4">
            <div class="row align-items-center g-4 g-lg-5">
                <div class="col-lg-5">
                    <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-bold mb-2">Merchant Control Center</span>
                    <h2 class="fw-bold fs-2 mb-3">Control Your Business From One Dashboard</h2>
                    <p class="text-muted mb-4">Manage orders, update inventory stock, track customer spending, and configure payment methods effortlessly from a single interface.</p>
                    <ul class="list-unstyled d-flex flex-column gap-2 text-dark font-weight-semibold">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i> Real-time order notifications</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i> Easy bKash / Nagad number configuration</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i> Automated stock management</li>
                    </ul>
                </div>
                <div class="col-lg-7">
                    <div class="nj-hero-preview-card">
                        <div class="nj-preview-header">
                            <span class="fw-bold small text-dark"><i class="bi bi-speedometer2 text-success me-1"></i> Merchant Dashboard Preview</span>
                            <span class="badge bg-light text-dark border">Real Interface Example</span>
                        </div>
                        <div class="p-3 p-md-4 bg-light">
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <div class="p-3 bg-white rounded border">
                                        <small class="text-muted d-block">Total Revenue</small>
                                        <div class="fw-bold fs-5 text-success">৳১,২৪,৫০০</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 bg-white rounded border">
                                        <small class="text-muted d-block">Pending Orders</small>
                                        <div class="fw-bold fs-5 text-warning">১২ Orders</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 bg-white rounded border">
                                        <small class="text-muted d-block">Total Products</small>
                                        <div class="fw-bold fs-5 text-dark">৪৫ Items</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Nabrijan Section -->
    <section id="about" class="py-5">
        <div class="nj-container py-4">
            <div class="text-center max-w-700 mx-auto mb-5">
                <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-bold mb-2">Built for Bangladesh</span>
                <h2 class="fw-bold fs-2 mb-3">Why Choose Nabrijan?</h2>
                <p class="text-muted fs-6">Purpose-built features tailored to modern commerce needs in Bangladesh.</p>
            </div>

            <div class="row g-3 g-md-4">
                <div class="col-md-4">
                    <div class="nj-feature-card">
                        <i class="bi bi-geo-alt-fill text-success fs-2 mb-3 d-block"></i>
                        <h5 class="fw-bold mb-2">Built for Bangladesh</h5>
                        <p class="text-muted small mb-0">Native support for BDT currency, Dhaka vs Outside Dhaka shipping rates, and bKash/Nagad.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="nj-feature-card">
                        <i class="bi bi-phone-fill text-success fs-2 mb-3 d-block"></i>
                        <h5 class="fw-bold mb-2">Mobile-First Engineering</h5>
                        <p class="text-muted small mb-0">Storefronts load in under 1 second on mobile networks with smooth sliding cart drawers.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="nj-feature-card">
                        <i class="bi bi-shield-lock-fill text-success fs-2 mb-3 d-block"></i>
                        <h5 class="fw-bold mb-2">Secure Order Management</h5>
                        <p class="text-muted small mb-0">Transactional database records with multi-tenant data isolation protecting customer information.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-5">
        <div class="nj-container">
            <div class="nj-cta-card">
                <h2 class="fw-bold fs-1 mb-3">Your Online Store Starts Here</h2>
                <p class="fs-5 opacity-90 mb-4 max-w-600 mx-auto">Build your store, manage your products, and start selling with Nabrijan today.</p>
                <a href="/register" class="btn-brand-accent fs-5 py-3 px-4" data-i18n="cta_final">
                    Get Started <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="nj-footer">
        <div class="nj-container">
            <div class="row g-4 mb-5">
                <div class="col-lg-4">
                    <a href="/" class="nj-brand-logo text-white mb-3 d-inline-flex">
                        <i class="bi bi-shop text-success"></i> NABRIJAN
                    </a>
                    <p class="small text-muted mb-0">Smart e-commerce technology platform for Bangladesh. Empowering merchants to launch, manage, and scale online stores effortlessly.</p>
                </div>
                <div class="col-6 col-md-3 col-lg-2">
                    <h6 class="fw-bold text-white mb-3">Product</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2 small">
                        <li><a href="#features">Features</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                        <li><a href="#showcase">Demo Store</a></li>
                        <li><a href="/register">Store Builder</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3 col-lg-2">
                    <h6 class="fw-bold text-white mb-3">Company</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2 small">
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="/login">Merchant Login</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3 col-lg-2">
                    <h6 class="fw-bold text-white mb-3">Resources</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2 small">
                        <li><a href="#how-it-works">How It Works</a></li>
                        <li><a href="#faq">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3 col-lg-2">
                    <h6 class="fw-bold text-white mb-3">Support</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2 small">
                        <li><a href="#contact">Help Center</a></li>
                        <li><a href="/register">Get Started</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-top border-secondary pt-4 text-center small text-muted">
                © <?= date('Y') ?> Nabrijan. All rights reserved. Built for Bangladesh.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const nicheData = {
            fashion: { title: "Trendy Fashion Store", desc: "Fast mobile shopping with instant bKash & Cash on Delivery checkout.", domain: "demo-fashion.nabrijan.site" },
            electronics: { title: "Gadget & Tech Store", desc: "Showcase electronics, warranty badges, and variant size/color choices.", domain: "demo-tech.nabrijan.site" },
            grocery: { title: "Daily Superstore & Grocery", desc: "Quick catalog navigation, fast add to cart, and location shipping fees.", domain: "demo-grocery.nabrijan.site" },
            beauty: { title: "Beauty & Cosmetics Boutique", desc: "High quality product galleries and elegant brand storefront design.", domain: "demo-beauty.nabrijan.site" }
        };

        function switchNiche(nicheKey) {
            document.querySelectorAll('#showcase button').forEach(b => b.classList.remove('active'));
            event.target.classList.add('active');
            const data = nicheData[nicheKey] || nicheData.fashion;
            document.getElementById('nicheTitle').innerText = data.title;
            document.getElementById('nicheDesc').innerText = data.desc;
            document.getElementById('nicheDomain').innerText = data.domain;
        }

        const translations = {
            en: {
                page_title: "NABRIJAN — Build, Launch & Grow Your Online Store in Bangladesh",
                nav_home: "Home",
                nav_features: "Features",
                nav_how_it_works: "How It Works",
                nav_showcase: "Showcase",
                nav_pricing: "Pricing",
                nav_about: "About",
                nav_contact: "Contact",
                nav_login: "Sign In",
                nav_get_started: "Get Started",
                hero_title: "Build, Launch & Grow Your <span>Online Store</span>",
                hero_subtitle: "Everything you need to create a modern online store, manage products, receive orders, and grow your business — built for Bangladesh.",
                hero_cta_primary: "Start Building <i class=\"bi bi-arrow-right\"></i>",
                hero_cta_secondary: "Explore Features"
            },
            bn: {
                page_title: "নবরিজান — বাংলাদেশে আপনার ই-কমার্স অনলাইন স্টোর তৈরি করুন",
                nav_home: "হোম",
                nav_features: "ফিচারসমূহ",
                nav_how_it_works: "যেভাবে কাজ করে",
                nav_showcase: "ডেমো স্টোর",
                nav_pricing: "প্রাইসিং",
                nav_about: "আমাদের কথা",
                nav_contact: "যোগাযোগ",
                nav_login: "লগইন",
                nav_get_started: "শুরু করুন",
                hero_title: "আপনার অনলাইন বিজনেসের <span>স্মার্ট ই-কমার্স স্টোর</span> তৈরি করুন",
                hero_subtitle: "কোন কোডিং ছাড়াই আপনার নিজস্ব অনলাইন শপ খুলুন, প্রোডাক্ট সাজান, বিকাশ/নগদে পেমেন্ট নিন এবং অর্ডার পরিচালনা করুন।",
                hero_cta_primary: "এখনি স্টোর তৈরি করুন →",
                hero_cta_secondary: "ফিচারসমূহ দেখুন"
            }
        };

        let currentLang = 'en';
        function toggleLanguage() {
            currentLang = currentLang === 'en' ? 'bn' : 'en';
            document.getElementById('langFlag').innerText = currentLang === 'en' ? '🇬🇧' : '🇧🇩';
            document.getElementById('langText').innerText = currentLang === 'en' ? 'English' : 'বাংলা';
            const dict = translations[currentLang];
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (dict[key]) el.innerHTML = dict[key];
            });
        }
    </script>
</body>
</html>
