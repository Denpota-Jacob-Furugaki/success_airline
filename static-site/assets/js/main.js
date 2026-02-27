/**
 * サクセスキャリアエアライン - メインJS
 * Static Site
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
  // 4. スムーススクロール
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
          document.querySelector('.site-header')?.offsetHeight || 0;
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
  // 5. ヘッダースクロール時の変化
  // =============================================
  function initHeaderScroll() {
    const header = document.querySelector('.site-header');
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
  // 6. ティッカーのクローン処理（シームレスループ保証）
  // =============================================
  function initTicker() {
    const tickerContent = document.querySelector('.sca-ticker-content');
    if (!tickerContent) return;

    // アニメーションが切れ目なく動くことを保証
    // すでに2回分出力済みなので、追加のクローンは不要
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
  // 7. 固定フッターCTAバー（スマホ用）生成
  // =============================================
  function initFixedCTA() {
    // スマホのみ
    if (window.innerWidth > 768) return;

    // すでに存在する場合はスキップ
    if (document.querySelector('.sca-fixed-cta')) return;

    const ctaBar = document.createElement('div');
    ctaBar.className = 'sca-fixed-cta';
    ctaBar.innerHTML = `
      <a href="contact.html" class="sca-fixed-cta__btn sca-fixed-cta__btn--1">お悩み相談</a>
      <a href="template.html" class="sca-fixed-cta__btn sca-fixed-cta__btn--2">講座予約</a>
      <a href="contact.html" class="sca-fixed-cta__btn sca-fixed-cta__btn--3">お問合せ</a>
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
  // Hamburger Menu Toggle
  // =============================================
  function initHamburger() {
    const hamburger = document.querySelector('.hamburger');
    const nav = document.querySelector('.site-nav');
    const overlay = document.querySelector('.nav-overlay');

    if (!hamburger || !nav) return;

    function toggleMenu() {
      hamburger.classList.toggle('is-active');
      nav.classList.toggle('is-open');
      if (overlay) overlay.classList.toggle('is-visible');
      document.body.style.overflow = nav.classList.contains('is-open') ? 'hidden' : '';
    }

    hamburger.addEventListener('click', toggleMenu);

    if (overlay) {
      overlay.addEventListener('click', toggleMenu);
    }

    // Close menu when clicking nav links
    nav.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        if (nav.classList.contains('is-open')) {
          toggleMenu();
        }
      });
    });
  }

  // =============================================
  // 初期化
  // =============================================
  function init() {
    initScrollAnimations();
    initCounters();
    initParallax();
    initSmoothScroll();
    initHeaderScroll();
    initTicker();
    initFixedCTA();
    initHamburger();
  }

  // DOM Ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
