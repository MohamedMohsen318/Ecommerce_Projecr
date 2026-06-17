@extends('layouts.app')

@section('title', 'Commerce Hub')

@section('content')
    @php
        $isArabic = app()->getLocale() === 'ar';
        $t = fn (string $en, string $ar) => $isArabic ? $ar : $en;
    @endphp

    <style>
        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(280px, .9fr);
            gap: 18px;
            align-items: stretch;
        }
        .hero-copy {
            color: #fff;
            border-radius: 8px;
            padding: clamp(28px, 5vw, 54px);
            display: grid;
            align-content: center;
            gap: 18px;
            min-height: 420px;
            background:
                linear-gradient(135deg, rgba(15,118,110,.96), rgba(17,24,39,.84)),
                url("https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?auto=format&fit=crop&w=1400&q=80") center/cover;
            overflow: hidden;
        }
        .hero-copy h1 { max-width: 760px; }
        .hero-copy p {
            color: #dbeafe;
            font-size: 18px;
            line-height: 1.7;
            max-width: 680px;
            margin: 0;
        }
        .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }
        .hero-actions .button.secondary { background: #fff; color: #111827; }
        .hero-panel { display: grid; gap: 14px; align-content: center; }
        .mini-product {
            display: grid;
            grid-template-columns: 76px 1fr auto;
            gap: 12px;
            align-items: center;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px;
            background: #fff;
        }
        .product-thumb {
            width: 76px;
            height: 76px;
            border-radius: 8px;
            background: linear-gradient(135deg, #dbeafe, #fef3c7);
            display: grid;
            place-items: center;
            font-weight: 900;
            color: #1f2937;
        }
        .mini-product:nth-child(3) .product-thumb { background: linear-gradient(135deg, #dcfce7, #e0e7ff); }
        .mini-product:nth-child(4) .product-thumb { background: linear-gradient(135deg, #fee2e2, #cffafe); }
        .mini-product h3, .feature h3 { margin: 0; font-size: 18px; }
        .mini-product p, .feature p { margin: 0; line-height: 1.6; }
        .price { font-weight: 900; color: #111827; }
        .section-title { margin: 0; font-size: 28px; }
        .store-strip { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
        .stat {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 18px;
        }
        .stat strong { display: block; font-size: 25px; margin-bottom: 4px; }
        .feature { min-height: 148px; display: grid; align-content: start; gap: 8px; }

        @media (max-width: 860px) {
            .hero, .store-strip { grid-template-columns: 1fr; }
            .hero-copy { min-height: 340px; }
            .mini-product { grid-template-columns: 68px 1fr; }
            .mini-product .price { grid-column: 2; }
        }
    </style>

    <section class="stack">
        <div class="hero">
            <div class="hero-copy">
                <h1>{{ $t('A modern store that feels clear from the first click.', 'متجر حديث وواضح من أول نقرة.') }}</h1>
                <p>
                    {{ $t('Browse products, explore categories, and place orders through a polished storefront connected to a focused admin dashboard.', 'تصفح المنتجات والأقسام وأرسل الطلبات من واجهة أنيقة مرتبطة بلوحة تحكم عملية للإدارة.') }}
                </p>
                <div class="hero-actions">
                    <a class="button secondary" href="{{ route('products.index') }}">{{ $t('Shop Now', 'تسوق الآن') }}</a>
                    <a class="button" href="{{ route('categories.index') }}">{{ $t('Explore Categories', 'استكشف الأقسام') }}</a>
                    @guest
                        <a class="button" href="{{ route('register') }}">{{ $t('Create Account', 'إنشاء حساب') }}</a>
                    @else
                        <a class="button" href="{{ route('profile') }}">{{ $t('My Account', 'حسابي') }}</a>
                    @endguest
                </div>
            </div>

            <aside class="card hero-panel">
                <h2 class="section-title">{{ $t('Today Picks', 'اختيارات اليوم') }}</h2>
                <article class="mini-product">
                    <div class="product-thumb">{{ $t('Bag', 'حقيبة') }}</div>
                    <div>
                        <h3>{{ $t('Daily Essentials', 'أساسيات يومية') }}</h3>
                        <p class="muted">{{ $t('Ready-to-order staples for quick checkout.', 'منتجات جاهزة للطلب بخطوات واضحة.') }}</p>
                    </div>
                    <span class="price">$24</span>
                </article>
                <article class="mini-product">
                    <div class="product-thumb">{{ $t('Fit', 'طقم') }}</div>
                    <div>
                        <h3>{{ $t('Practical Sets', 'مجموعات عملية') }}</h3>
                        <p class="muted">{{ $t('Useful selections for everyday needs.', 'اختيارات مناسبة للاستخدام اليومي.') }}</p>
                    </div>
                    <span class="price">$39</span>
                </article>
                <article class="mini-product">
                    <div class="product-thumb">{{ $t('New', 'جديد') }}</div>
                    <div>
                        <h3>{{ $t('Fresh Arrivals', 'وصل حديثاً') }}</h3>
                        <p class="muted">{{ $t('Categories and products kept up to date.', 'أقسام ومنتجات محدثة باستمرار.') }}</p>
                    </div>
                    <span class="price">$18</span>
                </article>
            </aside>
        </div>

        <div class="store-strip">
            <div class="stat"><strong>{{ $t('Fast', 'سريع') }}</strong><span class="muted">{{ $t('Clear navigation', 'تنقل واضح') }}</span></div>
            <div class="stat"><strong>{{ $t('Secure', 'آمن') }}</strong><span class="muted">{{ $t('Protected accounts', 'حسابات محمية') }}</span></div>
            <div class="stat"><strong>{{ $t('Organized', 'منظم') }}</strong><span class="muted">{{ $t('Linked categories', 'أقسام مترابطة') }}</span></div>
            <div class="stat"><strong>{{ $t('Managed', 'مدار') }}</strong><span class="muted">{{ $t('Complete admin tools', 'أدوات إدارة كاملة') }}</span></div>
        </div>

        <section>
            <h2 class="section-title">{{ $t('A Complete Store Experience', 'تجربة متجر متكاملة') }}</h2>
            <div class="grid" style="margin-top: 16px;">
                <article class="card feature">
                    <h3>{{ $t('Category Browsing', 'تصفح الأقسام') }}</h3>
                    <p class="muted">{{ $t('Move from parent categories to subcategories without losing context.', 'انتقل بين الأقسام الرئيسية والفرعية بدون فقدان السياق.') }}</p>
                </article>
                <article class="card feature">
                    <h3>{{ $t('Customer Accounts', 'حسابات العملاء') }}</h3>
                    <p class="muted">{{ $t('Customers can sign in and manage their profile from the same polished interface.', 'يمكن للعملاء تسجيل الدخول وإدارة بياناتهم من نفس الواجهة.') }}</p>
                </article>
                <article class="card feature">
                    <h3>{{ $t('Admin Workspace', 'مساحة الإدارة') }}</h3>
                    <p class="muted">{{ $t('Manage products, categories, admins, permissions, and orders from one place.', 'إدارة المنتجات والأقسام والمديرين والصلاحيات والطلبات من مكان واحد.') }}</p>
                </article>
            </div>
        </section>
    </section>
@endsection
