/**
 * サクセスキャリアエアライン - カスタムJS
 * SWELL Child Theme
 */

(function () {
  'use strict';

  // =============================================
  // 1. スクロールフェードインアニメーション
  // =============================================
  function initScrollAnimations() {
    const targets = document.querySelectorAll(
      '.sca-fade-in, .sca-fade-in-left, .sca-fade-in-right'
    );

    if (!targets.length) return;

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      },
      {
        threshold: 0.15,
        rootMargin: '0px 0px -50px 0px',
      }
    );

    targets.forEach((target) => observer.observe(target));
  }

  // =============================================
  // 2. カウントアップアニメーション
  // =============================================
  function initCounters() {
    const counters = document.querySelectorAll('.sca-counter');

    if (!counters.length) return;

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            animateCounter(entry.target);
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.5 }
    );

    counters.forEach((counter) => observer.observe(counter));
  }

  function animateCounter(element) {
    const target = parseInt(element.dataset.target, 10);
    const duration = parseInt(element.dataset.duration, 10) || 2000;
    const numberEl = element.querySelector('.sca-counter-number');

    if (!numberEl || isNaN(target)) return;

    const startTime = performance.now();

    function update(currentTime) {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);

      // easeOutQuart
      const eased = 1 - Math.pow(1 - progress, 4);
      const current = Math.floor(eased * target);

      numberEl.textContent = current.toLocaleString();

      if (progress < 1) {
        requestAnimationFrame(update);
      } else {
        numberEl.textContent = target.toLocaleString();
      }
    }

    requestAnimationFrame(update);
  }

  // =============================================
  // 3. パララックス背景スクロール（JSベース）
  // =============================================
  function initParallax() {
    const parallaxSections = document.querySelectorAll('[data-sca-parallax]');

    if (!parallaxSections.length) return;

    // スマホではパフォーマンス対策のため無効
    if (window.innerWidth <= 768) return;

    let ticking = false;

    function updateParallax() {
      const scrollY = window.pageYOffset;

      parallaxSections.forEach((section) => {
        const bg = section.querySelector('.sca-parallax-bg');
        if (!bg) return;

        const rect = section.getBoundingClientRect();
        const sectionTop = rect.top + scrollY;
        const sectionHeight = section.offsetHeight;
        const windowHeight = window.innerHeight;

        // セクションが画面内にある場合のみ計算
        if (
          scrollY + windowHeight > sectionTop &&
          scrollY < sectionTop + sectionHeight
        ) {
          const speed = parseFloat(section.dataset.scaParallax) || 0.3;
          const offset = (scrollY - sectionTop) * speed;
          bg.style.transform = `translate3d(0, ${offset}px, 0)`;
        }
      });

      ticking = false;
    }

    window.addEventListener(
      'scroll',
      function () {
        if (!ticking) {
          requestAnimationFrame(updateParallax);
          ticking = true;
        }
      },
      { passive: true }
    );

    // 初期実行
    updateParallax();
  }

  // =============================================
  // 4. SWELLフルワイドブロックへの自動パララックス
  // =============================================
  function initSwellParallax() {
    // SWELLの背景画像付きフルワイドブロックに対して
    // CSS background-attachment: fixed を補助するJS
    // iOSではbackground-attachment:fixedが効かないため
    const isIOS =
      /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

    if (!isIOS) return;

    // iOSの場合はCSS fixedの代わりにJSでシミュレート
    const fullWideSections = document.querySelectorAll(
      '.swell-block-fullWide.has-bg-img'
    );

    fullWideSections.forEach((section) => {
      section.style.backgroundAttachment = 'scroll';

      // ラッパーを追加してパララックスをシミュレート
      const bgUrl = getComputedStyle(section).backgroundImage;
      if (bgUrl && bgUrl !== 'none') {
        const wrapper = document.createElement('div');
        wrapper.classList.add('sca-parallax-bg');
        wrapper.style.backgroundImage = bgUrl;
        wrapper.style.position = 'absolute';
        wrapper.style.top = '-30%';
        wrapper.style.left = '0';
        wrapper.style.width = '100%';
        wrapper.style.height = '160%';
        wrapper.style.backgroundSize = 'cover';
        wrapper.style.backgroundPosition = 'center';
        wrapper.style.zIndex = '0';

        section.style.position = 'relative';
        section.style.overflow = 'hidden';
        section.style.backgroundImage = 'none';
        section.insertBefore(wrapper, section.firstChild);

        // 既存コンテンツにz-index付与
        Array.from(section.children).forEach((child) => {
          if (!child.classList.contains('sca-parallax-bg')) {
            child.style.position = 'relative';
            child.style.zIndex = '1';
          }
        });

        section.setAttribute('data-sca-parallax', '0.3');
      }
    });

    // パララックス再初期化
    initParallax();
  }

  // =============================================
  // 5. スムーススクロール
  // =============================================
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
      anchor.addEventListener('click', function (e) {
        const targetId = this.getAttribute('href');
        if (targetId === '#' || targetId === '#top') return;

        const target = document.querySelector(targetId);
        if (!target) return;

        e.preventDefault();

        const headerHeight =
          document.querySelector('.l-header')?.offsetHeight || 0;
        const targetPosition =
          target.getBoundingClientRect().top + window.pageYOffset - headerHeight;

        window.scrollTo({
          top: targetPosition,
          behavior: 'smooth',
        });
      });
    });
  }

  // =============================================
  // 6. ヘッダースクロール時の変化
  // =============================================
  function initHeaderScroll() {
    const header = document.querySelector('.l-header');
    if (!header) return;

    let lastScrollY = 0;

    window.addEventListener(
      'scroll',
      function () {
        const currentScrollY = window.pageYOffset;

        if (currentScrollY > 100) {
          header.classList.add('is-scrolled');
        } else {
          header.classList.remove('is-scrolled');
        }

        lastScrollY = currentScrollY;
      },
      { passive: true }
    );
  }

  // =============================================
  // 7. ティッカーのクローン処理（シームレスループ保証）
  // =============================================
  function initTicker() {
    const tickerContent = document.querySelector('.sca-ticker-content');
    if (!tickerContent) return;

    // アニメーションが切れ目なく動くことを保証
    // すでにPHPで2回分出力済みなので、追加のクローンは不要
    // ただし、幅が足りない場合はクローンを追加
    const tickerTrack = document.querySelector('.sca-ticker-track');
    if (!tickerTrack) return;

    const trackWidth = tickerTrack.offsetWidth;
    const contentWidth = tickerContent.scrollWidth / 2;

    // コンテンツが画面幅より短い場合、さらにクローンを追加
    if (contentWidth < trackWidth) {
      const items = tickerContent.innerHTML;
      tickerContent.innerHTML = items + items;
    }
  }

  // =============================================
  // 8. 固定フッターCTAバー（スマホ用）生成
  // =============================================
  function initFixedCTA() {
    // スマホのみ
    if (window.innerWidth > 768) return;

    // すでに存在する場合はスキップ
    if (document.querySelector('.sca-fixed-cta')) return;

    const ctaBar = document.createElement('div');
    ctaBar.className = 'sca-fixed-cta';
    ctaBar.innerHTML = `
      <a href="/counseling" class="sca-fixed-cta__btn sca-fixed-cta__btn--1">お悩み相談</a>
      <a href="/booking" class="sca-fixed-cta__btn sca-fixed-cta__btn--2">個別予約</a>
      <a href="/contact" class="sca-fixed-cta__btn sca-fixed-cta__btn--3">お問合せ</a>
    `;

    document.body.appendChild(ctaBar);

    // スクロールで表示/非表示
    window.addEventListener(
      'scroll',
      function () {
        const currentScroll = window.pageYOffset;
        if (currentScroll > 300) {
          ctaBar.style.transform = 'translateY(0)';
          ctaBar.style.opacity = '1';
        } else {
          ctaBar.style.transform = 'translateY(100%)';
          ctaBar.style.opacity = '0';
        }
      },
      { passive: true }
    );

    // 初期状態は非表示
    ctaBar.style.transform = 'translateY(100%)';
    ctaBar.style.opacity = '0';
    ctaBar.style.transition = 'transform 0.3s ease, opacity 0.3s ease';
  }

  // =============================================
  // 初期化
  // =============================================
  function init() {
    initScrollAnimations();
    initCounters();
    initParallax();
    initSwellParallax();
    initSmoothScroll();
    initHeaderScroll();
    initTicker();
    initFixedCTA();
  }

  // DOM Ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
