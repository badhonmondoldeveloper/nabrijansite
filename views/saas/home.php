<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nabrijan — Commerce OS for Modern Businesses in Bangladesh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/nabrijan-design-system.css">
    <style>
        /* Specific Page Enhancements */
        .announcement-bar { height: 36px; background-color: var(--brand-100); color: var(--brand-700); font-size: 13px; font-weight: 600; text-decoration: none; }
        .sticky-navbar { height: 72px; background: rgba(255, 255, 255, 0.82); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border-soft); position: sticky; top: 0; z-index: 1000; }
        .hero-section { position: relative; min-height: 800px; padding-top: 60px; padding-bottom: 80px; overflow: hidden; background: radial-gradient(circle at 50% 0%, rgba(10, 148, 96, 0.12), transparent 55%); }
        .hero-title span { color: var(--brand-600); }
        .hero-title .highlight-lime { background-color: var(--accent-500); color: var(--brand-950); padding: 0 8px; border-radius: 6px; }
        .trust-strip { background: var(--surface); border-y: 1px solid var(--border-soft); padding: 24px 0; }
        .niche-btn { border: 1px solid var(--border); background: var(--surface); color: var(--text-secondary); padding: 8px 16px; border-radius: 999px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .niche-btn.active, .niche-btn:hover { background: var(--brand-600); color: #fff; border-color: var(--brand-600); }
        .dashboard-dark-section { background-color: var(--brand-900); color: #F3FAF6; padding: 96px 0; }
        .tab-btn { padding: 6px 16px; border-radius: 8px; border: 1px solid var(--border); background: var(--surface); color: var(--text-secondary); font-size: 13px; font-weight: 600; cursor: pointer; }
        .tab-btn.active { background: var(--brand-600); color: #fff; border-color: var(--brand-600); }
    </style>
</head>
<body>

    <!-- 12. Announcement Bar -->
    <a href="/register" class="announcement-bar d-flex align-items-center justify-content-center gap-2">
        <span class="d-inline-block rounded-circle bg-success" style="width: 8px; height: 8px;"></span>
        <span>New → Build your online store with Nabrijan Commerce OS</span>
        <i class="bi bi-arrow-right"></i>
    </a>

    <!-- 11. Navbar -->
    <header class="sticky-navbar d-flex align-items-center">
        <div class="nj-container d-flex justify-content-between align-items-center w-100">
            <a href="/" class="d-flex align-items-center gap-2 text-decoration-none">
                <span class="font-display fw-extrabold fs-3 text-dark">NABRI<span style="color: var(--brand-600);">JAN</span></span>
                <span class="badge bg-light text-dark border px-2 py-1" style="font-size:0.65rem;">Commerce OS</span>
            </a>

            <nav class="d-none d-lg-flex align-items-center gap-4">
                <a href="#features" class="text-decoration-none text-secondary fw-semibold">Features</a>
                <a href="#how-it-works" class="text-decoration-none text-secondary fw-semibold">How It Works</a>
                <a href="#showcase" class="text-decoration-none text-secondary fw-semibold">Store Showcase</a>
                <a href="#pricing" class="text-decoration-none text-secondary fw-semibold">Pricing</a>
                <a href="#faq" class="text-decoration-none text-secondary fw-semibold">FAQ</a>
            </nav>

            <div class="d-flex align-items-center gap-3">
                <a href="/login" class="btn-nj btn-nj-ghost">Sign In</a>
                <a href="/register" class="btn-nj btn-nj-primary">Create Store →</a>
            </div>
        </div>
    </header>

    <!-- 13 & 14. Hero Section -->
    <section class="hero-section">
        <div class="nj-container text-center">
            <div class="max-w-800 mx-auto mb-5">
                <h1 class="display-hero hero-title mb-4">
                    Build Your Online Business.<br>
                    <span>Store. Products. Orders. Payments.</span>
                </h1>
                <p class="fs-5 text-secondary mb-4 mx-auto" style="max-width: 680px;">
                    Nabrijan is Bangladesh's first all-in-one AI-ready Commerce OS. Build your automated storefront, process bKash/Nagad payments, manage courier deliveries & scale faster.
                </p>
                <div class="d-flex justify-content-center gap-3 mb-5">
                    <a href="/register" class="btn-nj btn-nj-primary btn-lg">Create Your Store Now →</a>
                    <a href="#showcase" class="btn-nj btn-nj-accent btn-lg">Explore Demo <i class="bi bi-play-circle-fill"></i></a>
                </div>
            </div>

            <!-- Hero Visual Panel (Actual Nabrijan Dashboard Preview with Float Animation) -->
            <div class="position-relative mx-auto animate-float controlled-glow" style="max-width: 1000px; border-radius: 24px; border: 1px solid var(--border); overflow: hidden; background: #0D1C16; box-shadow: var(--shadow-lg);">
                <div class="bg-dark px-3 py-2 d-flex align-items-center gap-2 border-bottom border-secondary">
                    <span class="rounded-circle bg-danger" style="width:10px; height:10px;"></span>
                    <span class="rounded-circle bg-warning" style="width:10px; height:10px;"></span>
                    <span class="rounded-circle bg-success" style="width:10px; height:10px;"></span>
                    <small class="text-secondary ms-2" style="font-size:0.75rem;">admin.nabrijan.site/dashboard</small>
                </div>
                <div class="p-4 text-start">
                    <div class="row g-3 mb-3">
                        <div class="col-4">
                            <div class="p-3 bg-dark rounded border border-secondary">
                                <small class="text-secondary">Today's Revenue</small>
                                <h4 class="fw-bold text-success mb-0">৳84,520 <small class="fs-6 text-success"><i class="bi bi-arrow-up-right"></i> 12.8%</small></h4>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 bg-dark rounded border border-secondary">
                                <small class="text-secondary">Live Orders</small>
                                <h4 class="fw-bold text-light mb-0">128 Orders</h4>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 bg-dark rounded border border-secondary">
                                <small class="text-secondary">Active Customers</small>
                                <h4 class="fw-bold text-info mb-0">1,420 Users</h4>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 bg-dark rounded border border-secondary text-secondary small">
                        <i class="bi bi-graph-up-arrow text-warning me-2"></i> Real-time multi-tenant analytics live monitoring feed active.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 15. Trust / Platform Capability Strip -->
    <section class="trust-strip">
        <div class="nj-container d-flex flex-wrap justify-content-between align-items-center gap-3 text-secondary font-display fw-bold small">
            <span><i class="bi bi-shop text-success me-1"></i> Store Builder</span>
            <span><i class="bi bi-box-seam text-success me-1"></i> Products Catalog</span>
            <span><i class="bi bi-cart-check text-success me-1"></i> Order Management</span>
            <span><i class="bi bi-wallet2 text-success me-1"></i> bKash/Nagad Payments</span>
            <span><i class="bi bi-truck text-success me-1"></i> Automated Delivery</span>
            <span><i class="bi bi-bar-chart-line text-success me-1"></i> Real-Time Analytics</span>
            <span><i class="bi bi-shield-check text-success me-1"></i> 99.9% Uptime</span>
        </div>
    </section>

    <!-- 16. Problem -> Solution Section -->
    <section class="py-5 bg-white">
        <div class="nj-container py-5">
            <div class="text-center max-w-700 mx-auto mb-5">
                <h2 class="h2-heading mb-3">Running an online business shouldn't feel complicated.</h2>
                <p class="text-secondary">Say goodbye to scattered Facebook inbox orders, manual paper tracking, and lost payments.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="nj-card h-100">
                        <i class="bi bi-x-circle fs-1 text-danger mb-3 d-block"></i>
                        <h5 class="fw-bold mb-2">Too Many Tools</h5>
                        <p class="text-secondary small mb-0">Juggling Facebook messages, manual spreadsheets, and phone calls creates order errors and delays.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="nj-card h-100">
                        <i class="bi bi-exclamation-triangle fs-1 text-warning mb-3 d-block"></i>
                        <h5 class="fw-bold mb-2">Manual Payment Tracing</h5>
                        <p class="text-secondary small mb-0">Tracking bKash and Nagad TrxIDs manually leads to unverified payments and fraud risks.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="nj-card h-100 text-white" style="background: var(--brand-900);">
                        <i class="bi bi-check-circle-fill fs-1 text-success mb-3 d-block"></i>
                        <h5 class="fw-bold mb-2 text-light">Nabrijan Solution</h5>
                        <p class="text-secondary small mb-0">Brings store builder, automated manual payments, inventory, and order dispatch into one dashboard.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 17. Feature Bento Grid -->
    <section id="features" class="py-5" style="background: var(--surface-soft);">
        <div class="nj-container py-5">
            <div class="text-center mb-5">
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 fw-bold mb-2">FEATURES ARCHITECTURE</span>
                <h2 class="h2-heading">Everything You Need To Scale Commerce</h2>
            </div>

            <div class="bento-grid">
                <div class="bento-col-8">
                    <div class="nj-card nj-card-interactive h-100">
                        <span class="badge bg-success text-white mb-3">Storefront Engine</span>
                        <h3 class="h3-heading mb-2">No-Code Store Builder</h3>
                        <p class="text-secondary mb-4">Customize colors, banners, themes, and layouts with real-time preview designed specifically for fast mobile checkout in Bangladesh.</p>
                        <div class="p-3 bg-light rounded border"><code class="text-success">https://yourstore.nabrijan.site</code></div>
                    </div>
                </div>
                <div class="bento-col-4">
                    <div class="nj-card nj-card-interactive h-100">
                        <span class="badge bg-warning text-dark mb-3">Payments</span>
                        <h3 class="h4-heading mb-2">bKash & Nagad Verification</h3>
                        <p class="text-secondary small mb-0">Accept manual payments via bKash, Nagad, Rocket, or COD with automated TrxID logging.</p>
                    </div>
                </div>
                <div class="bento-col-4">
                    <div class="nj-card nj-card-interactive h-100">
                        <span class="badge bg-info text-white mb-3">Analytics</span>
                        <h3 class="h4-heading mb-2">Business Intelligence</h3>
                        <p class="text-secondary small mb-0">Track revenue, order conversion, top-selling products, and customer repeat purchase rate.</p>
                    </div>
                </div>
                <div class="bento-col-8">
                    <div class="nj-card nj-card-interactive h-100">
                        <span class="badge bg-dark text-white mb-3">Marketing</span>
                        <h3 class="h3-heading mb-2">Coupons & Growth Tools</h3>
                        <p class="text-secondary mb-0">Run percentage or fixed discount promotional campaigns, manage reviews, and send automated notifications.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 19. Store Showcase (Niche Switcher) -->
    <section id="showcase" class="py-5 bg-white">
        <div class="nj-container py-5 text-center">
            <h2 class="h2-heading mb-3">One Platform. Your Own Brand.</h2>
            <p class="text-secondary mb-4">Tailored for every major retail sector in Bangladesh.</p>

            <div class="d-flex justify-content-center gap-2 mb-5 flex-wrap">
                <button class="niche-btn active" onclick="switchNiche('fashion')">Fashion & Apparel</button>
                <button class="niche-btn" onclick="switchNiche('electronics')">Electronics & Gadgets</button>
                <button class="niche-btn" onclick="switchNiche('grocery')">Grocery & Superstore</button>
                <button class="niche-btn" onclick="switchNiche('beauty')">Beauty & Cosmetics</button>
            </div>

            <div class="nj-card p-0 overflow-hidden mx-auto shadow-lg" style="max-width: 900px; border-radius: 20px;">
                <div class="bg-light px-3 py-2 border-bottom text-start small text-secondary">
                    ● ● ● <span id="nicheDomain">demo-fashion.nabrijan.site</span>
                </div>
                <div class="p-5 text-center bg-dark text-light" id="nichePreviewArea">
                    <h3 class="fw-bold text-warning mb-2" id="nicheTitle">Trendy Fashion Store</h3>
                    <p class="text-secondary mb-4" id="nicheDesc">Fast mobile shopping experience with clean product cards and instant bKash checkout.</p>
                    <a href="/register" class="btn-nj btn-nj-accent">Launch This Store →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 20. Dashboard Showcase (Dark Green Section) -->
    <section class="dashboard-dark-section">
        <div class="nj-container text-center">
            <h2 class="h2-heading text-light mb-3">Your Business. One Powerful Dashboard.</h2>
            <p class="text-secondary max-w-700 mx-auto mb-5">Full operational control over products, live orders, customer records, and subscription tier settings.</p>
            
            <div class="p-4 bg-dark rounded border border-secondary text-start mx-auto shadow-lg" style="max-width: 960px; border-radius: 20px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-light mb-0"><i class="bi bi-speedometer2 text-warning me-2"></i> Merchant Command Panel</h5>
                    <span class="badge bg-success">● Store Active</span>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="p-3 bg-secondary bg-opacity-10 rounded border border-secondary">
                            <div class="small text-secondary">Total Orders</div>
                            <div class="h4 fw-bold text-light mb-0">1,280</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-secondary bg-opacity-10 rounded border border-secondary">
                            <div class="small text-secondary">Total Revenue</div>
                            <div class="h4 fw-bold text-success mb-0">৳458,900</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-secondary bg-opacity-10 rounded border border-secondary">
                            <div class="small text-secondary">Products Stocked</div>
                            <div class="h4 fw-bold text-info mb-0">340 Items</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-secondary bg-opacity-10 rounded border border-secondary">
                            <div class="small text-secondary">Avg Rating</div>
                            <div class="h4 fw-bold text-warning mb-0">4.9 / 5.0</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 23. Pricing Section -->
    <section id="pricing" class="py-5 bg-white">
        <div class="nj-container py-5">
            <div class="text-center max-w-700 mx-auto mb-5">
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 fw-bold mb-2">TRANSPARENT PRICING</span>
                <h2 class="h2-heading mb-3">Simple Plans. Built To Grow With You.</h2>
                <p class="text-secondary">Choose the tier that matches your business size. No hidden transaction fees.</p>
            </div>

            <div class="row g-4 align-items-stretch">
                <!-- FREE -->
                <div class="col-lg-3 col-md-6">
                    <div class="nj-card h-100 d-flex flex-column">
                        <h4 class="fw-bold mb-2">FREE</h4>
                        <div class="h2 fw-bold text-success mb-3">৳0 <small class="fs-6 text-secondary">/mo</small></div>
                        <ul class="list-unstyled text-secondary small mb-4 flex-grow-1">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> 10 Products</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Standard Theme</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> bKash/Nagad Manual</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Subdomain URL</li>
                        </ul>
                        <a href="/register" class="btn-nj btn-nj-secondary w-100">Get Started</a>
                    </div>
                </div>

                <!-- STARTER -->
                <div class="col-lg-3 col-md-6">
                    <div class="nj-card h-100 d-flex flex-column">
                        <h4 class="fw-bold mb-2">STARTER</h4>
                        <div class="h2 fw-bold text-success mb-3">৳499 <small class="fs-6 text-secondary">/mo</small></div>
                        <ul class="list-unstyled text-secondary small mb-4 flex-grow-1">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> 100 Products</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> 2 Themes</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> bKash/Nagad Manual</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Basic Analytics</li>
                        </ul>
                        <a href="/register" class="btn-nj btn-nj-secondary w-100">Start Free Trial</a>
                    </div>
                </div>

                <!-- BUSINESS (MOST POPULAR) -->
                <div class="col-lg-3 col-md-6">
                    <div class="nj-card h-100 d-flex flex-column border-success position-relative shadow-lg" style="border-width: 2px;">
                        <span class="badge bg-warning text-dark fw-bold position-absolute top-0 start-50 translate-middle px-3 py-1">MOST POPULAR</span>
                        <h4 class="fw-bold mb-2 mt-2">BUSINESS</h4>
                        <div class="h2 fw-bold text-success mb-3">৳999 <small class="fs-6 text-secondary">/mo</small></div>
                        <ul class="list-unstyled text-secondary small mb-4 flex-grow-1">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> 500 Products</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Custom Domain Allowed</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> 5 Themes</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Full Analytics & Coupons</li>
                        </ul>
                        <a href="/register" class="btn-nj btn-nj-primary w-100">Choose Business</a>
                    </div>
                </div>

                <!-- PRO -->
                <div class="col-lg-3 col-md-6">
                    <div class="nj-card h-100 d-flex flex-column">
                        <h4 class="fw-bold mb-2">PRO</h4>
                        <div class="h2 fw-bold text-success mb-3">৳1,999 <small class="fs-6 text-secondary">/mo</small></div>
                        <ul class="list-unstyled text-secondary small mb-4 flex-grow-1">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Unlimited Products</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Custom Domain & SSL</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> All Themes Unlocked</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Dedicated Support</li>
                        </ul>
                        <a href="/register" class="btn-nj btn-nj-secondary w-100">Contact Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 28. FAQ Accordion -->
    <section id="faq" class="py-5" style="background: var(--surface-soft);">
        <div class="nj-container py-5 max-w-800 mx-auto">
            <h2 class="h2-heading text-center mb-5">Frequently Asked Questions</h2>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item mb-3 border-0 rounded-3 overflow-hidden shadow-sm">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            How do bKash & Nagad manual payments work?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-secondary small">
                            Merchants set their personal/agent bKash and Nagad numbers in their dashboard. During checkout, customers send money, enter their TrxID, and merchants verify the transaction ID directly from their orders panel.
                        </div>
                    </div>
                </div>
                <div class="accordion-item mb-3 border-0 rounded-3 overflow-hidden shadow-sm">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            Can I connect a custom domain like mybrand.com?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-secondary small">
                            Yes! Business and Pro plan tiers allow custom domain binding. Every merchant also gets a free subdomain (`yourstore.nabrijan.site`) immediately upon registration.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 bg-dark text-light border-top border-secondary">
        <div class="nj-container text-center">
            <h4 class="font-display fw-bold mb-3 text-success">NABRIJAN</h4>
            <p class="text-secondary small mb-4">Commerce OS for Modern Businesses in Bangladesh. Built with speed and reliability.</p>
            <div class="text-secondary small">© <?= date('Y') ?> Nabrijan Tech Ltd. All rights reserved.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function switchNiche(niche) {
            const btns = document.querySelectorAll('.niche-btn');
            btns.forEach(b => b.classList.remove('active'));
            event.target.classList.add('active');

            const domain = document.getElementById('nicheDomain');
            const title = document.getElementById('nicheTitle');
            const desc = document.getElementById('nicheDesc');

            if (niche === 'fashion') {
                domain.innerText = 'demo-fashion.nabrijan.site';
                title.innerText = 'Trendy Fashion Store';
                desc.innerText = 'Fast mobile shopping experience with clean product cards and instant bKash checkout.';
            } else if (niche === 'electronics') {
                domain.innerText = 'demo-gadgets.nabrijan.site';
                title.innerText = 'Modern Tech & Gadgets';
                desc.innerText = 'Filter variants by specs, warranty tags, and direct delivery options.';
            } else if (niche === 'grocery') {
                domain.innerText = 'demo-grocery.nabrijan.site';
                title.innerText = 'Daily Superstore';
                desc.innerText = 'Optimized for quick cart additions and same-day home delivery dispatch.';
            } else if (niche === 'beauty') {
                domain.innerText = 'demo-beauty.nabrijan.site';
                title.innerText = 'Cosmetics & Beauty Care';
                desc.innerText = 'High-resolution image galleries and customer review ratings.';
            }
        }
    </script>
</body>
</html>
