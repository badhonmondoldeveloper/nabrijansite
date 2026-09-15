<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="page_title">নবরিজান — বাংলাদেশের স্মার্ট ই-কমার্স স্টোর বিল্ডার প্যাটফর্ম</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/nabrijan-design-system.css">
    <style>
        .announcement-bar { height: 36px; background: linear-gradient(90deg, #075F3E, #0A9460); color: #ffffff; font-size: 13px; font-weight: 600; text-decoration: none; }
        .sticky-navbar { height: 74px; background: rgba(255, 255, 255, 0.90); backdrop-filter: blur(14px); border-bottom: 1px solid var(--border-soft); position: sticky; top: 0; z-index: 1000; }
        .hero-section { position: relative; min-height: 850px; padding-top: 50px; padding-bottom: 80px; overflow: hidden; background: radial-gradient(circle at 50% 0%, rgba(10, 148, 96, 0.15), rgba(37, 99, 235, 0.05) 50%, transparent 80%); }
        .hero-title span { color: var(--brand-600); }
        .hero-title .highlight-accent { background: linear-gradient(120deg, #D8F34A, #A6E22E); color: #071A13; padding: 2px 12px; border-radius: 8px; display: inline-block; }
        .trust-strip { background: #071A13; color: #F3FAF6; border-y: 1px solid rgba(255,255,255,0.1); padding: 20px 0; }
        .niche-btn { border: 1px solid var(--border); background: var(--surface); color: var(--text-secondary); padding: 10px 20px; border-radius: 999px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .niche-btn.active, .niche-btn:hover { background: var(--brand-600); color: #fff; border-color: var(--brand-600); box-shadow: 0 4px 14px rgba(8,122,75,0.3); }
        .dashboard-dark-section { background: linear-gradient(180deg, #071A13 0%, #06140F 100%); color: #F3FAF6; padding: 96px 0; }
    </style>
</head>
<body>

    <!-- 1. Announcement Bar -->
    <a href="/register" class="announcement-bar d-flex align-items-center justify-content-center gap-2">
        <span class="d-inline-block rounded-circle bg-warning" style="width: 8px; height: 8px;"></span>
        <span data-i18n="announcement">নতুন স্পেশাল অফার → আজই আপনার অনলাইন স্টোর তৈরি করুন মাত্র ২ মিনিটে!</span>
        <i class="bi bi-arrow-right"></i>
    </a>

    <!-- 2. Navbar -->
    <header class="sticky-navbar d-flex align-items-center">
        <div class="nj-container d-flex justify-content-between align-items-center w-100">
            <a href="/" class="d-flex align-items-center gap-2 text-decoration-none">
                <span class="font-display fw-extrabold fs-3 text-dark">NABRI<span style="color: var(--brand-600);">JAN</span></span>
                <span class="badge rgb-badge-glow px-2 py-1" style="font-size:0.65rem;">Commerce OS</span>
            </a>

            <nav class="d-none d-lg-flex align-items-center gap-4">
                <a href="#features" class="text-decoration-none text-secondary fw-semibold" data-i18n="nav_features">ফিচারসমূহ</a>
                <a href="#how-it-works" class="text-decoration-none text-secondary fw-semibold" data-i18n="nav_how_it_works">যেভাবে কাজ করে</a>
                <a href="#showcase" class="text-decoration-none text-secondary fw-semibold" data-i18n="nav_showcase">ডেমো স্টোর</a>
                <a href="#pricing" class="text-decoration-none text-secondary fw-semibold" data-i18n="nav_pricing">প্রাইসিং প্ল্যান</a>
                <a href="#faq" class="text-decoration-none text-secondary fw-semibold" data-i18n="nav_faq">প্রশ্নোত্তর</a>
            </nav>

            <div class="d-flex align-items-center gap-3">
                <!-- Language Toggle Button -->
                <button type="button" class="lang-toggle-btn" id="langToggleBtn" onclick="toggleLanguage()">
                    <span id="langFlag">🇬🇧</span> <span id="langText">English</span>
                </button>
                <a href="/login" class="btn-nj btn-nj-ghost fw-bold" data-i18n="nav_login">লগইন</a>
            </div>
        </div>
    </header>

    <!-- 3. Hero Section -->
    <section class="hero-section text-center">
        <div class="nj-container">
            <div class="max-w-800 mx-auto mb-4">
                <div class="mb-3">
                    <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill fw-bold" data-i18n="hero_badge">
                        <i class="bi bi-stars me-1 text-warning"></i> বাংলাদেশের নম্বর ১ ই-কমার্স প্ল্যাটফর্ম
                    </span>
                </div>
                <h1 class="display-hero hero-title mb-4 fw-extrabold" data-i18n="hero_title">
                    আপনার অনলাইন বিজনেসের <br>
                    <span class="highlight-accent">স্মার্ট ই-কমার্স স্টোর</span> তৈরি করুন
                </h1>
                <p class="fs-5 text-secondary mb-4 mx-auto" style="max-width: 680px;" data-i18n="hero_subtitle">
                    নবরিজান হল অল-ইন-ওয়ান ই-কমার্স প্ল্যাটফর্ম। কোন কোডিং ছাড়াই আপনার নিজস্ব স্টোর খুলুন, বিকাশ/নগদে পেমেন্ট নিন এবং অটোমেটিক কুরিয়ার ডেলিভারি ম্যানেজ করুন।
                </p>

                <!-- Stacked Vertical Hero Action Buttons -->
                <div class="hero-cta-vertical mb-5">
                    <a href="/register" class="btn-nj btn-nj-primary btn-lg shadow-lg" data-i18n="hero_create_store">
                        <i class="bi bi-shop me-1"></i> এখনি আপনার স্টোর তৈরি করুন →
                    </a>
                    <a href="/register" class="btn-nj btn-nj-accent btn-lg shadow-lg" data-i18n="hero_start_now">
                        <i class="bi bi-rocket-takeoff-fill me-1"></i> এখনি শুরু করুন
                    </a>
                    <a href="#showcase" class="btn-nj btn-nj-secondary btn-lg" data-i18n="hero_explore_demo">
                        <i class="bi bi-play-circle-fill me-1 text-success"></i> ডেমো দেখুন
                    </a>
                </div>
            </div>

            <!-- RGB Glowing Hero Visual Panel (Interactive Dashboard Preview) -->
            <div class="position-relative mx-auto animate-float rgb-glow-card" style="max-width: 1000px; border-radius: 24px; overflow: hidden; background: #071A13; box-shadow: var(--shadow-lg);">
                <div class="bg-dark px-3 py-2.5 d-flex align-items-center justify-content-between border-bottom border-secondary">
                    <div class="d-flex align-items-center gap-2">
                        <span class="rounded-circle bg-danger" style="width:10px; height:10px;"></span>
                        <span class="rounded-circle bg-warning" style="width:10px; height:10px;"></span>
                        <span class="rounded-circle bg-success" style="width:10px; height:10px;"></span>
                        <small class="text-secondary ms-2" style="font-size:0.75rem;">admin.nabrijan.site/dashboard</small>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success" style="font-size: 0.7rem;">● LIVE REALTIME OS</span>
                </div>
                <div class="p-4 text-start">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4">
                            <div class="p-3 rounded border border-secondary" style="background: rgba(255,255,255,0.04);">
                                <small class="text-secondary d-block mb-1" data-i18n="stat_today_sales">আজকের মোট বিক্রি</small>
                                <h4 class="fw-bold text-success mb-0">৳৮৪,৫২০ <small class="fs-6 text-success"><i class="bi bi-arrow-up-right"></i> +১৪.২%</small></h4>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="p-3 rounded border border-secondary" style="background: rgba(255,255,255,0.04);">
                                <small class="text-secondary d-block mb-1" data-i18n="stat_live_orders">চলতি অর্ডার</small>
                                <h4 class="fw-bold text-light mb-0">১২৮ টি অর্ডার</h4>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="p-3 rounded border border-secondary" style="background: rgba(255,255,255,0.04);">
                                <small class="text-secondary d-block mb-1" data-i18n="stat_active_users">এক্টিভ কাস্টমার</small>
                                <h4 class="fw-bold text-info mb-0">১,৪২০ জন</h4>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 rounded border border-success bg-success bg-opacity-10 text-light small d-flex align-items-center justify-content-between">
                        <div>
                            <i class="bi bi-lightning-charge-fill text-warning me-2 fs-5"></i>
                            <span data-i18n="stat_live_feed">রিয়েল-টাইম অনলাইন অর্ডার ও বিকাশ ট্রানজেকশন অটো ভেরিফিকেশন সক্রিয়।</span>
                        </div>
                        <span class="badge bg-success text-dark font-weight-bold" data-i18n="stat_status_active">সক্রিয়</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Trust & Feature Strip -->
    <section class="trust-strip">
        <div class="nj-container d-flex flex-wrap justify-content-between align-items-center gap-3 font-display fw-bold small">
            <span><i class="bi bi-shop text-success me-1"></i> <span data-i18n="strip_1">স্টোর বিল্ডার</span></span>
            <span><i class="bi bi-box-seam text-success me-1"></i> <span data-i18n="strip_2">প্রোডাক্ট ক্যাটালগ</span></span>
            <span><i class="bi bi-cart-check text-success me-1"></i> <span data-i18n="strip_3">অর্ডার ম্যানেজমেন্ট</span></span>
            <span><i class="bi bi-wallet2 text-success me-1"></i> <span data-i18n="strip_4">বিকাশ/নগদ পেমেন্ট</span></span>
            <span><i class="bi bi-truck text-success me-1"></i> <span data-i18n="strip_5">কুরিয়ার ইন্টিগ্রেশন</span></span>
            <span><i class="bi bi-bar-chart-line text-success me-1"></i> <span data-i18n="strip_6">লাইভ এনালাইটিক্স</span></span>
            <span><i class="bi bi-shield-check text-success me-1"></i> <span data-i18n="strip_7">৯৯.৯% আপটাইম</span></span>
        </div>
    </section>

    <!-- 5. Problem -> Solution Section -->
    <section class="py-5 bg-white">
        <div class="nj-container py-5">
            <div class="text-center max-w-700 mx-auto mb-5">
                <h2 class="h2-heading mb-3" data-i18n="prob_heading">অনলাইন ব্যবসা চালানো এখন আর কঠিন কিছু নয়!</h2>
                <p class="text-secondary" data-i18n="prob_subheading">ফেসবুক ইনবক্সে অর্ডার গুছানো বা খাতার হিসাব রাখার ঝামেলার দিন শেষ।</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="nj-card h-100">
                        <i class="bi bi-x-circle fs-1 text-danger mb-3 d-block"></i>
                        <h5 class="fw-bold mb-2" data-i18n="prob_1_title">একাধিক টুলের ঝামেলা</h5>
                        <p class="text-secondary small mb-0" data-i18n="prob_1_desc">ফেসবুক মেসেজ, খাতার হিসাব আর ফোন কলের গ্যাঁড়াকলে পড়ে প্রায়ই ভুল অর্ডার ও ডেলিভারি দেরি হয়।</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="nj-card h-100">
                        <i class="bi bi-exclamation-triangle fs-1 text-warning mb-3 d-block"></i>
                        <h5 class="fw-bold mb-2" data-i18n="prob_2_title">পেমেন্ট ট্র্যাকিং সমস্যা</h5>
                        <p class="text-secondary small mb-0" data-i18n="prob_2_desc">বিকাশ ও নগদ TrxID ম্যানুয়ালি মেলাতে গিয়ে ভুয়া পেমেন্ট ও লোকসানের ঝুঁকি তৈরি হয়।</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="nj-card h-100 text-white" style="background: var(--brand-900);">
                        <i class="bi bi-check-circle-fill fs-1 text-success mb-3 d-block"></i>
                        <h5 class="fw-bold mb-2 text-light" data-i18n="prob_3_title">নবরিজান স্মার্ট সলিউশন</h5>
                        <p class="text-secondary small mb-0" data-i18n="prob_3_desc">স্টোর ওয়েবসাইট, অটো পেমেন্ট মেলানো, প্রোডাক্ট স্টক ও ডেলিভারি সব একসাথে একই ড্যাশবোর্ডে।</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Features Grid -->
    <section id="features" class="py-5" style="background: var(--surface-soft);">
        <div class="nj-container py-5">
            <div class="text-center mb-5">
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 fw-bold mb-2" data-i18n="feat_badge">প্লাটফর্ম ফিচারসমূহ</span>
                <h2 class="h2-heading" data-i18n="feat_heading">ব্যবসা দ্রুত বড় করতে যা যা প্রয়োজন</h2>
            </div>

            <div class="bento-grid">
                <div class="bento-col-8">
                    <div class="nj-card nj-card-interactive h-100">
                        <span class="badge bg-success text-white mb-3" data-i18n="feat_1_tag">স্টোর ইনজিন</span>
                        <h3 class="h3-heading mb-2" data-i18n="feat_1_title">নো-কোড ওয়েবসাইট বিল্ডার</h3>
                        <p class="text-secondary mb-4" data-i18n="feat_1_desc">পছন্দমতো কালার, ব্যানার, থিম এবং লেআউট কাস্টমাইজ করুন কোন কোডিং ছাড়াই। মোবাইল ব্যবহারকারীদের জন্য সুপার ফাস্ট।</p>
                        <div class="p-3 bg-light rounded border"><code class="text-success">https://yourstore.nabrijan.site</code></div>
                    </div>
                </div>
                <div class="bento-col-4">
                    <div class="nj-card nj-card-interactive h-100">
                        <span class="badge bg-warning text-dark mb-3" data-i18n="feat_2_tag">পেমেন্ট</span>
                        <h3 class="h4-heading mb-2" data-i18n="feat_2_title">বিকাশ ও নগদ ভেরিফিকেশন</h3>
                        <p class="text-secondary small mb-0" data-i18n="feat_2_desc">ক্যাশ অন ডেলিভারি সহ বিকাশ, নগদ, রকেটের মাধ্যমে ম্যানুয়াল পেমেন্ট গ্রহণ ও অটোমেটিক TrxID ট্র্যাকিং।</p>
                    </div>
                </div>
                <div class="bento-col-4">
                    <div class="nj-card nj-card-interactive h-100">
                        <span class="badge bg-info text-white mb-3" data-i18n="feat_3_tag">এনালাইটিক্স</span>
                        <h3 class="h4-heading mb-2" data-i18n="feat_3_title">বিজনেস রিপোর্ট ও ডাটা</h3>
                        <p class="text-secondary small mb-0" data-i18n="feat_3_desc">মোট বিক্রি, লাভ-ক্ষতি, সেরা বিক্রি হওয়া প্রোডাক্ট ও কাস্টমার কেনাকাটার হিসাব রাখুন সহজেই।</p>
                    </div>
                </div>
                <div class="bento-col-8">
                    <div class="nj-card nj-card-interactive h-100">
                        <span class="badge bg-dark text-white mb-3" data-i18n="feat_4_tag">মার্কেটিং</span>
                        <h3 class="h3-heading mb-2" data-i18n="feat_4_title">কুপন কোড ও প্রমোশন টুলস</h3>
                        <p class="text-secondary mb-0" data-i18n="feat_4_desc">ডিসকাউন্ট কুপন তৈরি করুন, কাস্টমার রিভিউ ম্যানেজ করুন এবং গ্রাহকদের অফার ইমেইল/মেসেজ পাঠান।</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. Store Showcase (Niche Switcher) -->
    <section id="showcase" class="py-5 bg-white">
        <div class="nj-container py-5 text-center">
            <h2 class="h2-heading mb-3" data-i18n="showcase_heading">একটি প্ল্যাটফর্ম। আপনার নিজস্ব ব্র্যান্ড।</h2>
            <p class="text-secondary mb-4" data-i18n="showcase_subheading">যেকোনো ক্যাটাগরির ই-কমার্স বিজনেসের উপযোগী থিম লেআউট।</p>

            <div class="d-flex justify-content-center gap-2 mb-5 flex-wrap">
                <button class="niche-btn active" onclick="switchNiche('fashion')" data-i18n="cat_fashion">ফ্যাশন ও ক্লোথিং</button>
                <button class="niche-btn" onclick="switchNiche('electronics')" data-i18n="cat_electronics">ইলেকট্রনিক্স ও গ্যাজেট</button>
                <button class="niche-btn" onclick="switchNiche('grocery')" data-i18n="cat_grocery">গ্রোসারী ও সুপারশপ</button>
                <button class="niche-btn" onclick="switchNiche('beauty')" data-i18n="cat_beauty">বিউটি ও কসমোটিক্স</button>
            </div>

            <div class="nj-card p-0 overflow-hidden mx-auto shadow-lg" style="max-width: 900px; border-radius: 20px;">
                <div class="bg-light px-3 py-2 border-bottom text-start small text-secondary">
                    ● ● ● <span id="nicheDomain">demo-fashion.nabrijan.site</span>
                </div>
                <div class="p-5 text-center bg-dark text-light" id="nichePreviewArea">
                    <h3 class="fw-bold text-warning mb-2" id="nicheTitle">ট্রেন্ডি ফ্যাশন স্টোর</h3>
                    <p class="text-secondary mb-4" id="nicheDesc">সুপারফাস্ট মোবাইল শপিং এবং সহজ বিকাশ চেকআউট এক্সপেরিয়েন্স।</p>
                    <a href="/register" class="btn-nj btn-nj-accent" data-i18n="launch_store">এখনি স্টোর তৈরি করুন →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. Pricing Section -->
    <section id="pricing" class="py-5 bg-white">
        <div class="nj-container py-5">
            <div class="text-center max-w-700 mx-auto mb-5">
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 fw-bold mb-2" data-i18n="price_badge">সহজ ও সাশ্রয়ী প্রাইসিং</span>
                <h2 class="h2-heading mb-3" data-i18n="price_heading">আপনার ব্যবসার সাইজ অনুযায়ী সেরা প্ল্যানটি বেছে নিন</h2>
                <p class="text-secondary" data-i18n="price_subheading">কোনো হিডেন চার্জ নেই। যেকোনো সময় প্ল্যান পরিবর্তন বা বাতিল করা যাবে।</p>
            </div>

            <div class="row g-4 align-items-stretch">
                <!-- FREE -->
                <div class="col-lg-3 col-md-6">
                    <div class="nj-card h-100 d-flex flex-column">
                        <h4 class="fw-bold mb-2">FREE</h4>
                        <div class="h2 fw-bold text-success mb-3">৳০ <small class="fs-6 text-secondary">/মাস</small></div>
                        <ul class="list-unstyled text-secondary small mb-4 flex-grow-1">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> ১০ টি প্রোডাক্ট</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> স্ট্যান্ডার্ড থিম</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> বিকাশ/নগদ ম্যানুয়াল</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> ফ্রি সাবডোমেইন</li>
                        </ul>
                        <a href="/register" class="btn-nj btn-nj-secondary w-100" data-i18n="plan_start_free">ফ্রি শুরু করুন</a>
                    </div>
                </div>

                <!-- STARTER -->
                <div class="col-lg-3 col-md-6">
                    <div class="nj-card h-100 d-flex flex-column">
                        <h4 class="fw-bold mb-2">STARTER</h4>
                        <div class="h2 fw-bold text-success mb-3">৳৪৯৯ <small class="fs-6 text-secondary">/মাস</small></div>
                        <ul class="list-unstyled text-secondary small mb-4 flex-grow-1">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> ১০০ টি প্রোডাক্ট</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> ২ টি প্রিমিয়াম থিম</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> বিকাশ/নগদ পেমেন্ট</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> বেসিক এনালাইটিক্স</li>
                        </ul>
                        <a href="/register" class="btn-nj btn-nj-secondary w-100" data-i18n="plan_starter">স্টার্টার নিন</a>
                    </div>
                </div>

                <!-- BUSINESS (MOST POPULAR) -->
                <div class="col-lg-3 col-md-6">
                    <div class="nj-card h-100 d-flex flex-column border-success position-relative shadow-lg rgb-glow-card" style="border-width: 2px;">
                        <span class="badge bg-warning text-dark fw-bold position-absolute top-0 start-50 translate-middle px-3 py-1" data-i18n="popular">সর্বাধিক জনপ্রিয়</span>
                        <h4 class="fw-bold mb-2 mt-2">BUSINESS</h4>
                        <div class="h2 fw-bold text-success mb-3">৳৯৯৯ <small class="fs-6 text-secondary">/মাস</small></div>
                        <ul class="list-unstyled text-secondary small mb-4 flex-grow-1">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> ৫০০ টি প্রোডাক্ট</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> কাস্টম ডোমেইন সংযোগ</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> ৫ টি প্রিমিয়াম থিম</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> কুপন ও ফুল এনালাইটিক্স</li>
                        </ul>
                        <a href="/register" class="btn-nj btn-nj-primary w-100" data-i18n="plan_biz">বিজনেস শুরু করুন</a>
                    </div>
                </div>

                <!-- PRO -->
                <div class="col-lg-3 col-md-6">
                    <div class="nj-card h-100 d-flex flex-column">
                        <h4 class="fw-bold mb-2">PRO</h4>
                        <div class="h2 fw-bold text-success mb-3">৳১,৯৯৯ <small class="fs-6 text-secondary">/মাস</small></div>
                        <ul class="list-unstyled text-secondary small mb-4 flex-grow-1">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> আনলিমিটেড প্রোডাক্ট</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> কাস্টম ডোমেইন + ফ্রি SSL</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> সব থিম আনলকড</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> ২৪/৭ ডেডিকেটেড সাপোর্ট</li>
                        </ul>
                        <a href="/register" class="btn-nj btn-nj-secondary w-100" data-i18n="plan_pro">প্রো প্ল্যান নিন</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. FAQ Section -->
    <section id="faq" class="py-5" style="background: var(--surface-soft);">
        <div class="nj-container py-5 max-w-800 mx-auto">
            <h2 class="h2-heading text-center mb-5" data-i18n="faq_title">সাধারণ কিছু প্রশ্ন ও উত্তর</h2>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item mb-3 border-0 rounded-3 overflow-hidden shadow-sm">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" data-i18n="faq_1_q">
                            বিকাশ ও নগদ ম্যানুয়াল পেমেন্ট কিভাবে কাজ করে?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-secondary small" data-i18n="faq_1_a">
                            মার্চেন্ট তার পার্সোনাল বা এজেন্ট নম্বর সেট করে রাখেন। চেকআউট করার সময় কাস্টমার টাকা পাঠিয়ে TrxID ইনপুট দেয় এবং মার্চেন্ট ড্যাশবোর্ড থেকে সহজেই ভেরিফাই করতে পারেন।
                        </div>
                    </div>
                </div>
                <div class="accordion-item mb-3 border-0 rounded-3 overflow-hidden shadow-sm">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" data-i18n="faq_2_q">
                            আমি কি নিজস্ব কাস্টম ডোমেইন (যেমন mybrand.com) ব্যবহার করতে পারব?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-secondary small" data-i18n="faq_2_a">
                            হ্যাঁ! বিজনেস এবং প্রো প্ল্যানে কাস্টম ডোমেইন কানেক্ট করার অপশন রয়েছে। এছাড়া রেজিস্টার করার সাথে সাথেই একটি ফ্রি সাবডোমেইন পাওয়া যাবে।
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 10. Live Animated Order Notification Toast -->
    <div class="live-order-toast" id="liveOrderToast">
        <i class="bi bi-bag-check-fill text-success fs-5"></i>
        <div>
            <div class="fw-bold" id="toastText">নতুন অর্ডার: ৳২,৪৫০</div>
            <div class="text-secondary" style="font-size: 0.75rem;" id="toastSub">ধানমন্ডি, ঢাকা • ১০ সেকেন্ড আগে</div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-5 bg-dark text-light border-top border-secondary">
        <div class="nj-container text-center">
            <h4 class="font-display fw-bold mb-3 text-success">NABRIJAN</h4>
            <p class="text-secondary small mb-4" data-i18n="footer_sub">বাংলাদেশের আধুনিক অনলাইন ব্যবসার নির্ভরযোগ্য ই-কমার্স প্ল্যাটফর্ম।</p>
            <div class="text-secondary small">© <?= date('Y') ?> Nabrijan Tech Ltd. All rights reserved.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Internationalization / Language Switcher Dictionary
        const translations = {
            bn: {
                page_title: "নবরিজান — বাংলাদেশের স্মার্ট ই-কমার্স স্টোর বিল্ডার প্যাটফর্ম",
                announcement: "নতুন স্পেশাল অফার → আজই আপনার অনলাইন স্টোর তৈরি করুন মাত্র ২ মিনিটে!",
                nav_features: "ফিচারসমূহ",
                nav_how_it_works: "যেভাবে কাজ করে",
                nav_showcase: "ডেমো স্টোর",
                nav_pricing: "প্রাইসিং প্ল্যান",
                nav_faq: "প্রশ্নোত্তর",
                nav_login: "লগইন",
                hero_badge: "<i class=\"bi bi-stars me-1 text-warning\"></i> বাংলাদেশের নম্বর ১ ই-কমার্স প্ল্যাটফর্ম",
                hero_title: "আপনার অনলাইন বিজনেসের <br><span class=\"highlight-accent\">স্মার্ট ই-কমার্স স্টোর</span> তৈরি করুন",
                hero_subtitle: "নবরিজান হল অল-ইন-ওয়ান ই-কমার্স প্ল্যাটফর্ম। কোন কোডিং ছাড়াই আপনার নিজস্ব স্টোর খুলুন, বিকাশ/নগদে পেমেন্ট নিন এবং অটোমেটিক কুরিয়ার ডেলিভারি ম্যানেজ করুন।",
                hero_create_store: "<i class=\"bi bi-shop me-1\"></i> এখনি আপনার স্টোর তৈরি করুন →",
                hero_start_now: "<i class=\"bi bi-rocket-takeoff-fill me-1\"></i> এখনি শুরু করুন",
                hero_explore_demo: "<i class=\"bi bi-play-circle-fill me-1 text-success\"></i> ডেমো দেখুন",
                stat_today_sales: "আজকের মোট বিক্রি",
                stat_live_orders: "চলতি অর্ডার",
                stat_active_users: "এক্টিভ কাস্টমার",
                stat_live_feed: "রিয়েল-টাইম অনলাইন অর্ডার ও বিকাশ ট্রানজেকশন অটো ভেরিফিকেশন সক্রিয়।",
                stat_status_active: "সক্রিয়",
                strip_1: "স্টোর বিল্ডার",
                strip_2: "প্রোডাক্ট ক্যাটালগ",
                strip_3: "অর্ডার ম্যানেজমেন্ট",
                strip_4: "বিকাশ/নগদ পেমেন্ট",
                strip_5: "কুরিয়ার ইন্টিগ্রেশন",
                strip_6: "লাইভ এনালাইটিক্স",
                strip_7: "৯৯.৯% আপটাইম",
                prob_heading: "অনলাইন ব্যবসা চালানো এখন আর কঠিন কিছু নয়!",
                prob_subheading: "ফেসবুক ইনবক্সে অর্ডার গুছানো বা খাতার হিসাব রাখার ঝামেলার দিন শেষ।",
                prob_1_title: "একাধিক টুলের ঝামেলা",
                prob_1_desc: "ফেসবুক মেসেজ, খাতার হিসাব আর ফোন কলের গ্যাঁড়াকলে পড়ে প্রায়ই ভুল অর্ডার ও ডেলিভারি দেরি হয়।",
                prob_2_title: "পেমেন্ট ট্র্যাকিং সমস্যা",
                prob_2_desc: "বিকাশ ও নগদ TrxID ম্যানুয়ালি মেলাতে গিয়ে ভুয়া পেমেন্ট ও লোকসানের ঝুঁকি তৈরি হয়।",
                prob_3_title: "নবরিজান স্মার্ট সলিউশন",
                prob_3_desc: "স্টোর ওয়েবসাইট, অটো পেমেন্ট মেলানো, প্রোডাক্ট স্টক ও ডেলিভারি সব একসাথে একই ড্যাশবোর্ডে।",
                feat_badge: "প্লাটফর্ম ফিচারসমূহ",
                feat_heading: "ব্যবসা দ্রুত বড় করতে যা যা প্রয়োজন",
                feat_1_tag: "স্টোর ইনজিন",
                feat_1_title: "নো-কোড ওয়েবসাইট বিল্ডার",
                feat_1_desc: "পছন্দমতো কালার, ব্যানার, থিম এবং লেআউট কাস্টমাইজ করুন কোন কোডিং ছাড়াই। মোবাইল ব্যবহারকারীদের জন্য সুপার ফাস্ট।",
                feat_2_tag: "পেমেন্ট",
                feat_2_title: "বিকাশ ও নগদ ভেরিফিকেশন",
                feat_2_desc: "ক্যাশ অন ডেলিভারি সহ বিকাশ, নগদ, রকেটের মাধ্যমে ম্যানুয়াল পেমেন্ট গ্রহণ ও অটোমেটিক TrxID ট্র্যাকিং।",
                feat_3_tag: "এনালাইটিক্স",
                feat_3_title: "বিজনেস রিপোর্ট ও ডাটা",
                feat_3_desc: "মোট বিক্রি, লাভ-ক্ষতি, সেরা বিক্রি হওয়া প্রোডাক্ট ও কাস্টমার কেনাকাটার হিসাব রাখুন সহজেই।",
                feat_4_tag: "মার্কেটিং",
                feat_4_title: "কুপন কোড ও প্রমোশন টুলস",
                feat_4_desc: "ডিসকাউন্ট কুপন তৈরি করুন, কাস্টমার রিভিউ ম্যানেজ করুন এবং গ্রাহকদের অফার ইমেইল/মেসেজ পাঠান।",
                showcase_heading: "একটি প্ল্যাটফর্ম। আপনার নিজস্ব ব্র্যান্ড।",
                showcase_subheading: "যেকোনো ক্যাটাগরির ই-কমার্স বিজনেসের উপযোগী থিম লেআউট।",
                cat_fashion: "ফ্যাশন ও ক্লোথিং",
                cat_electronics: "ইলেকট্রনিক্স ও গ্যাজেট",
                cat_grocery: "গ্রোসারী ও সুপারশপ",
                cat_beauty: "বিউটি ও কসমোটিক্স",
                launch_store: "এখনি স্টোর তৈরি করুন →",
                price_badge: "সহজ ও সাশ্রয়ী প্রাইসিং",
                price_heading: "আপনার ব্যবসার সাইজ অনুযায়ী সেরা প্ল্যানটি বেছে নিন",
                price_subheading: "কোনো হিডেন চার্জ নেই। যেকোনো সময় প্ল্যান পরিবর্তন বা বাতিল করা যাবে।",
                plan_start_free: "ফ্রি শুরু করুন",
                plan_starter: "স্টার্টার নিন",
                popular: "সর্বাধিক জনপ্রিয়",
                plan_biz: "বিজনেস শুরু করুন",
                plan_pro: "প্রো প্ল্যান নিন",
                faq_title: "সাধারণ কিছু প্রশ্ন ও উত্তর",
                faq_1_q: "বিকাশ ও নগদ ম্যানুয়াল পেমেন্ট কিভাবে কাজ করে?",
                faq_1_a: "মার্চেন্ট তার পার্সোনাল বা এজেন্ট নম্বর সেট করে রাখেন। চেকআউট করার সময় কাস্টমার টাকা পাঠিয়ে TrxID ইনপুট দেয় এবং মার্চেন্ট ড্যাশবোর্ড থেকে সহজেই ভেরিফাই করতে পারেন।",
                faq_2_q: "আমি কি নিজস্ব কাস্টম ডোমেইন (যেমন mybrand.com) ব্যবহার করতে পারব?",
                faq_2_a: "হ্যাঁ! বিজনেস এবং প্রো প্ল্যানে কাস্টম ডোমেইন কানেক্ট করার অপশন রয়েছে। এছাড়া রেজিস্টার করার সাথে সাথেই একটি ফ্রি সাবডোমেইন পাওয়া যাবে।",
                footer_sub: "বাংলাদেশের আধুনিক অনলাইন ব্যবসার নির্ভরযোগ্য ই-কমার্স প্ল্যাটফর্ম।"
            },
            en: {
                page_title: "Nabrijan — All-in-One E-Commerce Store Builder Platform in Bangladesh",
                announcement: "Special New Offer → Build your automated online store in just 2 minutes!",
                nav_features: "Features",
                nav_how_it_works: "How It Works",
                nav_showcase: "Demo Stores",
                nav_pricing: "Pricing",
                nav_faq: "FAQ",
                nav_login: "Sign In",
                hero_badge: "<i class=\"bi bi-stars me-1 text-warning\"></i> #1 E-Commerce Commerce OS in Bangladesh",
                hero_title: "Build Your Online Business <br><span class=\"highlight-accent\">Smart E-Commerce Store</span>",
                hero_subtitle: "Nabrijan is Bangladesh's first all-in-one AI-ready Commerce OS. Build your store, process bKash/Nagad payments, & dispatch courier deliveries effortlessly.",
                hero_create_store: "<i class=\"bi bi-shop me-1\"></i> Create Your Store Now →",
                hero_start_now: "<i class=\"bi bi-rocket-takeoff-fill me-1\"></i> Start Now",
                hero_explore_demo: "<i class=\"bi bi-play-circle-fill me-1 text-success\"></i> Explore Demo",
                stat_today_sales: "Today's Total Revenue",
                stat_live_orders: "Active Orders",
                stat_active_users: "Active Customers",
                stat_live_feed: "Real-time order monitoring and automated bKash/Nagad TrxID verification active.",
                stat_status_active: "Active",
                strip_1: "Store Builder",
                strip_2: "Product Catalog",
                strip_3: "Order Management",
                strip_4: "bKash/Nagad Payments",
                strip_5: "Courier Dispatch",
                strip_6: "Real-Time Analytics",
                strip_7: "99.9% Uptime",
                prob_heading: "Running an online store shouldn't feel complicated.",
                prob_subheading: "Say goodbye to scattered Facebook inbox orders and manual paper logbooks.",
                prob_1_title: "Too Many Tools",
                prob_1_desc: "Juggling Facebook messages, manual spreadsheets, and phone calls creates order errors.",
                prob_2_title: "Manual Payment Tracing",
                prob_2_desc: "Tracking bKash and Nagad TrxIDs manually leads to unverified payments and fraud risks.",
                prob_3_title: "Nabrijan Smart Solution",
                prob_3_desc: "Brings store builder, automated manual payments, inventory, and order dispatch into one dashboard.",
                feat_badge: "Platform Features",
                feat_heading: "Everything You Need To Scale Commerce",
                feat_1_tag: "Storefront Engine",
                feat_1_title: "No-Code Store Builder",
                feat_1_desc: "Customize colors, banners, themes, and layouts with real-time preview designed specifically for mobile checkout.",
                feat_2_tag: "Payments",
                feat_2_title: "bKash & Nagad Verification",
                feat_2_desc: "Accept manual payments via bKash, Nagad, Rocket, or COD with automated TrxID logging.",
                feat_3_tag: "Analytics",
                feat_3_title: "Business Intelligence",
                feat_3_desc: "Track revenue, order conversion, top-selling products, and customer repeat purchase rate.",
                feat_4_tag: "Marketing",
                feat_4_title: "Coupons & Growth Tools",
                feat_4_desc: "Run percentage or fixed discount promotional campaigns, manage reviews, and send automated notifications.",
                showcase_heading: "One Platform. Your Own Brand.",
                showcase_subheading: "Tailored for every major retail sector in Bangladesh.",
                cat_fashion: "Fashion & Apparel",
                cat_electronics: "Electronics & Gadgets",
                cat_grocery: "Grocery & Superstore",
                cat_beauty: "Beauty & Cosmetics",
                launch_store: "Create Store Now →",
                price_badge: "Transparent Pricing",
                price_heading: "Simple Plans. Built To Grow With You.",
                price_subheading: "Choose the tier that matches your business size. No hidden transaction fees.",
                plan_start_free: "Get Started Free",
                plan_starter: "Get Starter Plan",
                popular: "Most Popular",
                plan_biz: "Start Business Tier",
                plan_pro: "Choose Pro Tier",
                faq_title: "Frequently Asked Questions",
                faq_1_q: "How do bKash & Nagad manual payments work?",
                faq_1_a: "Merchants set their personal/agent bKash and Nagad numbers in their dashboard. During checkout, customers send money, enter their TrxID, and merchants verify the transaction ID directly from their orders panel.",
                faq_2_q: "Can I connect a custom domain like mybrand.com?",
                faq_2_a: "Yes! Business and Pro plan tiers allow custom domain binding. Every merchant also gets a free subdomain (`yourstore.nabrijan.site`) immediately upon registration.",
                footer_sub: "Commerce OS for Modern Businesses in Bangladesh. Built with speed and reliability."
            }
        };

        let currentLang = localStorage.getItem('nabrijan_lang') || 'bn';

        function applyLanguage(lang) {
            currentLang = lang;
            localStorage.setItem('nabrijan_lang', lang);
            
            const btnFlag = document.getElementById('langFlag');
            const btnText = document.getElementById('langText');

            if (lang === 'bn') {
                btnFlag.innerText = '🇬🇧';
                btnText.innerText = 'English';
            } else {
                btnFlag.innerText = '🇧🇩';
                btnText.innerText = 'বাংলা';
            }

            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (translations[lang] && translations[lang][key]) {
                    el.innerHTML = translations[lang][key];
                }
            });
        }

        function toggleLanguage() {
            applyLanguage(currentLang === 'bn' ? 'en' : 'bn');
        }

        function switchNiche(niche) {
            const btns = document.querySelectorAll('.niche-btn');
            btns.forEach(b => b.classList.remove('active'));
            event.target.classList.add('active');

            const domain = document.getElementById('nicheDomain');
            const title = document.getElementById('nicheTitle');
            const desc = document.getElementById('nicheDesc');

            if (niche === 'fashion') {
                domain.innerText = 'demo-fashion.nabrijan.site';
                title.innerText = currentLang === 'bn' ? 'ট্রেন্ডি ফ্যাশন স্টোর' : 'Trendy Fashion Store';
                desc.innerText = currentLang === 'bn' ? 'সুপারফাস্ট মোবাইল শপিং এবং সহজ বিকাশ চেকআউট এক্সপেরিয়েন্স।' : 'Fast mobile shopping experience with clean product cards and instant bKash checkout.';
            } else if (niche === 'electronics') {
                domain.innerText = 'demo-gadgets.nabrijan.site';
                title.innerText = currentLang === 'bn' ? 'আধুনিক গ্যাজেট ও টেক' : 'Modern Tech & Gadgets';
                desc.innerText = currentLang === 'bn' ? 'প্রোডাক্ট ভ্যারিয়েন্ট ফিল্টার, ওয়ারেন্টি ট্যাগ এবং দ্রুত হোম ডেলিভারি।' : 'Filter variants by specs, warranty tags, and direct delivery options.';
            } else if (niche === 'grocery') {
                domain.innerText = 'demo-grocery.nabrijan.site';
                title.innerText = currentLang === 'bn' ? 'ডেইলি সুপারস্টোর' : 'Daily Superstore';
                desc.innerText = currentLang === 'bn' ? 'দ্রুত কার্টে যোগ এবং সেম-ডে হোম ডেলিভারি অর্ডার সুবিধা।' : 'Optimized for quick cart additions and same-day home delivery dispatch.';
            } else if (niche === 'beauty') {
                domain.innerText = 'demo-beauty.nabrijan.site';
                title.innerText = currentLang === 'bn' ? 'কসমোটিক্স ও রূপচর্চা' : 'Cosmetics & Beauty Care';
                desc.innerText = currentLang === 'bn' ? 'হাই-রেজুলেশন ইমেজ গ্যালারি ও আসল কাস্টমার রিভিউ রেইটিং।' : 'High-resolution image galleries and customer review ratings.';
            }
        }

        // Live Order Toast Animation Ticker
        const simulatedToasts = [
            { text: "নতুন অর্ডার: ৳২,৪৫০", sub: "ধানমন্ডি, ঢাকা • ১০ সেকেন্ড আগে", enText: "New Order: ৳2,450", enSub: "Dhanmondi, Dhaka • 10s ago" },
            { text: "নতুন অর্ডার: ৳৩,২০০", sub: "গুলশান, ঢাকা • ২ মিনিট আগে", enText: "New Order: ৳3,200", enSub: "Gulshan, Dhaka • 2m ago" },
            { text: "নতুন অর্ডার: ৳১,৮৫০", sub: "জিইসি, চট্টগ্রাম • ৫ মিনিট আগে", enText: "New Order: ৳1,850", enSub: "GEC, Chattogram • 5m ago" }
        ];
        let toastIdx = 0;
        setInterval(() => {
            toastIdx = (toastIdx + 1) % simulatedToasts.length;
            const t = simulatedToasts[toastIdx];
            document.getElementById('toastText').innerText = currentLang === 'bn' ? t.text : t.enText;
            document.getElementById('toastSub').innerText = currentLang === 'bn' ? t.sub : t.enSub;
        }, 6000);

        // Initialize language on load
        document.addEventListener('DOMContentLoaded', () => {
            applyLanguage(currentLang);
        });
    </script>
</body>
</html>
