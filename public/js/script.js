/* ==========================================================================
   MYSTERY BOX — app.js
   No jQuery. Vanilla JS + GSAP + Swiper + AOS.
   ========================================================================== */
document.addEventListener('DOMContentLoaded', () => {

  /* ---------------------------------------------------------------------
     AOS init (kept lightweight; custom reveal handles most elements)
     --------------------------------------------------------------------- */
  if (window.AOS) AOS.init({ duration: 800, once: true, offset: 60 });

  /* ---------------------------------------------------------------------
     Sticky header on scroll
     --------------------------------------------------------------------- */
  const header = document.getElementById('siteHeader');
  const backToTop = document.getElementById('backToTop');
  window.addEventListener('scroll', () => {
    const scrolled = window.scrollY > 40;
    header.classList.toggle('scrolled', scrolled);
    backToTop.classList.toggle('show', window.scrollY > 500);
  }, { passive: true });

  backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

  /* ---------------------------------------------------------------------
     Smooth scroll for [data-scroll] anchor links
     --------------------------------------------------------------------- */
  document.querySelectorAll('[data-scroll]').forEach(link => {
    link.addEventListener('click', e => {
      const target = document.querySelector(link.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  /* ---------------------------------------------------------------------
     Custom scroll-reveal (fade-up / zoom) via IntersectionObserver
     --------------------------------------------------------------------- */
  const revealEls = document.querySelectorAll('[data-reveal]');
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
      if (entry.isIntersecting) {
        setTimeout(() => entry.target.classList.add('is-visible'), i * 60);
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15 });
  revealEls.forEach(el => revealObserver.observe(el));

  /* ---------------------------------------------------------------------
     Floating background particles (hero)
     --------------------------------------------------------------------- */
  const auroraBg = document.getElementById('auroraBg');
  if (auroraBg && window.innerWidth > 640) {
    for (let i = 0; i < 18; i++) {
      const p = document.createElement('span');
      p.className = 'particle';
      const size = 4 + Math.random() * 8;
      p.style.width = `${size}px`;
      p.style.height = `${size}px`;
      p.style.left = `${Math.random() * 100}%`;
      p.style.bottom = `-${Math.random() * 20}px`;
      p.style.animationDuration = `${8 + Math.random() * 10}s`;
      p.style.animationDelay = `${Math.random() * 10}s`;
      auroraBg.appendChild(p);
    }
  }

  /* ---------------------------------------------------------------------
     Countdown timer (synced across hero + bottom CTA)
     --------------------------------------------------------------------- */
  function startCountdown(seconds, ids) {
    let remaining = seconds;
    function render() {
      const h = Math.floor(remaining / 3600);
      const m = Math.floor((remaining % 3600) / 60);
      const s = remaining % 60;
      const pad = n => String(n).padStart(2, '0');
      ids.forEach(set => {
        const hh = document.getElementById(set.h);
        const mm = document.getElementById(set.m);
        const ss = document.getElementById(set.s);
        if (hh) hh.textContent = pad(h);
        if (mm) mm.textContent = pad(m);
        if (ss) ss.textContent = pad(s);
      });
    }
    render();
    const timer = setInterval(() => {
      remaining = remaining > 0 ? remaining - 1 : 0;
      render();
      if (remaining <= 0) clearInterval(timer);
    }, 1000);
  }
  startCountdown(5 * 3600 + 42 * 60 + 18, [
    { h: 'hh', m: 'mm', s: 'ss' },
    { h: 'hh2', m: 'mm2', s: 'ss2' }
  ]);

  /* ---------------------------------------------------------------------
     Animated stat counters
     --------------------------------------------------------------------- */
  const counters = document.querySelectorAll('[data-count]');
  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const el = entry.target;
      const target = parseFloat(el.getAttribute('data-count'));
      const decimals = parseInt(el.getAttribute('data-decimal') || '0', 10);
      const duration = 1600;
      const start = performance.now();
      function tick(now) {
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        const value = target * eased;
        el.textContent = decimals ? value.toFixed(decimals) : Math.floor(value).toLocaleString('en-US');
        if (progress < 1) requestAnimationFrame(tick);
        else el.textContent = decimals ? target.toFixed(decimals) : target.toLocaleString('en-US');
      }
      requestAnimationFrame(tick);
      counterObserver.unobserve(el);
    });
  }, { threshold: 0.4 });
  counters.forEach(c => counterObserver.observe(c));

  /* ---------------------------------------------------------------------
     Accordion (Order Policy / FAQ)
     --------------------------------------------------------------------- */
  document.querySelectorAll('.accordion-item').forEach(item => {
    const head = item.querySelector('.accordion-head');
    const body = item.querySelector('.accordion-body');
    head.addEventListener('click', () => {
      const isOpen = item.classList.contains('open');
      // close siblings within same accordion group
      const group = item.parentElement;
      group.querySelectorAll('.accordion-item.open').forEach(openItem => {
        if (openItem !== item) {
          openItem.classList.remove('open');
          openItem.querySelector('.accordion-body').style.maxHeight = null;
        }
      });
      if (isOpen) {
        item.classList.remove('open');
        body.style.maxHeight = null;
      } else {
        item.classList.add('open');
        body.style.maxHeight = body.scrollHeight + 'px';
      }
    });
  });

  /* ---------------------------------------------------------------------
     Package selection — sync package cards, order form chips, sticky bar
     --------------------------------------------------------------------- */
  const pkgChips = document.querySelectorAll('.pkg-chip');
  const packageCards = document.querySelectorAll('.package-card');
  const sumSubtotal = document.getElementById('sumSubtotal');
  const sumDelivery = document.getElementById('sumDelivery');
  const sumTotal = document.getElementById('sumTotal');
  const sumDiscount = document.getElementById('sumDiscount');
  const sumDiscountRow = document.getElementById('sumDiscountRow');
  const stickyPrice = document.getElementById('stickyPrice');
  const citySelect = document.getElementById('city');

  let state = { price: 349, delivery: 60, discount: 0 };

  function formatBDT(n) { return '৳' + Math.round(n).toLocaleString('en-US'); }

  function updateSummary() {
    const total = Math.max(state.price + state.delivery - state.discount, 0);
    sumSubtotal.textContent = formatBDT(state.price);
    sumDelivery.textContent = formatBDT(state.delivery);
    sumTotal.textContent = formatBDT(total);
    stickyPrice.textContent = formatBDT(state.price);
    if (state.discount > 0) {
      sumDiscountRow.style.display = 'flex';
      sumDiscount.textContent = '-' + formatBDT(state.discount);
    } else {
      sumDiscountRow.style.display = 'none';
    }
  }

  function selectPackage(pkgValue, priceValue) {
    state.price = priceValue;
    pkgChips.forEach(c => c.classList.toggle('active', c.dataset.pkg === pkgValue));
    packageCards.forEach(c => c.classList.toggle('selected', c.dataset.pkg === pkgValue));
    updateSummary();
  }

  pkgChips.forEach(chip => {
    chip.addEventListener('click', () => selectPackage(chip.dataset.pkg, parseFloat(chip.dataset.price)));
  });

  document.querySelectorAll('.select-pkg').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const card = e.target.closest('.package-card');
      selectPackage(card.dataset.pkg, parseFloat(card.dataset.price));
      document.getElementById('order').scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });

  citySelect.addEventListener('change', () => {
    state.delivery = parseFloat(citySelect.value) || 0;
    updateSummary();
  });

  document.getElementById('applyCoupon').addEventListener('click', () => {
    const couponInput = document.getElementById('coupon');
    const code = couponInput.value.trim().toUpperCase();
    if (code === 'SAVE10') {
      state.discount = Math.round(state.price * 0.1);
    } else {
      state.discount = 0;
      if (code) couponInput.style.borderColor = '#e0433c';
    }
    updateSummary();
  });

  updateSummary();

  /* ---------------------------------------------------------------------
     Floating label helper for select (since :not(:placeholder-shown)
     doesn't apply to <select>)
     --------------------------------------------------------------------- */
  citySelect.addEventListener('change', () => {
    citySelect.closest('.field').classList.toggle('filled', !!citySelect.value);
  });

  /* ---------------------------------------------------------------------
     Live form validation
     --------------------------------------------------------------------- */
  const form = document.getElementById('orderForm');
  const nameField = document.getElementById('fullName');
  const phoneField = document.getElementById('phone');
  const addressField = document.getElementById('address');

  function validateField(input, testFn) {
    const wrapper = input.closest('.field');
    const isValid = testFn(input.value.trim());
    wrapper.classList.toggle('valid', isValid && input.value.trim().length > 0);
    wrapper.classList.toggle('error', !isValid && input.value.trim().length > 0);
    return isValid;
  }

  nameField.addEventListener('input', () => validateField(nameField, v => v.length >= 2));
  phoneField.addEventListener('input', () => {
    phoneField.value = phoneField.value.replace(/\D/g, '').slice(0, 11);
    validateField(phoneField, v => /^01[3-9]\d{8}$/.test(v));
  });
  addressField.addEventListener('input', () => validateField(addressField, v => v.length >= 6));

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const validName = validateField(nameField, v => v.length >= 2);
    const validPhone = validateField(phoneField, v => /^01[3-9]\d{8}$/.test(v));
    const validAddress = validateField(addressField, v => v.length >= 6);
    const validCity = !!citySelect.value;
    citySelect.closest('.field').classList.toggle('error', !validCity);

    if (validName && validPhone && validAddress && validCity) {
      const submitBtn = form.querySelector('button[type="submit"]');
      submitBtn.textContent = '✅ অর্ডার সফলভাবে সম্পন্ন হয়েছে!';
      submitBtn.style.background = 'var(--clr-success)';
      submitBtn.style.animation = 'none';
      form.querySelectorAll('input, select, .pkg-chip').forEach(el => el.setAttribute('disabled', true));
    } else {
      form.querySelector('.field.error input, .field.error select')?.focus();
    }
  });

  /* ---------------------------------------------------------------------
     Button ripple effect
     --------------------------------------------------------------------- */
  document.querySelectorAll('.btn').forEach(btn => {
    btn.addEventListener('click', function (e) {
      const rect = this.getBoundingClientRect();
      const ripple = document.createElement('span');
      ripple.className = 'ripple';
      ripple.style.left = (e.clientX - rect.left) + 'px';
      ripple.style.top = (e.clientY - rect.top) + 'px';
      ripple.style.width = ripple.style.height = Math.max(rect.width, rect.height) + 'px';
      this.appendChild(ripple);
      setTimeout(() => ripple.remove(), 650);
    });
  });

  /* ---------------------------------------------------------------------
     Video play button (placeholder interaction)
     --------------------------------------------------------------------- */
  const playBtn = document.querySelector('.play-btn');
  if (playBtn) {
    playBtn.addEventListener('click', () => {
      playBtn.innerHTML = '<i class="fa-solid fa-pause"></i>';
    });
  }

  /* ---------------------------------------------------------------------
     Reviews Swiper
     --------------------------------------------------------------------- */
  if (window.Swiper) {
    new Swiper('.reviewSwiper', {
      slidesPerView: 1,
      spaceBetween: 20,
      loop: true,
      autoplay: { delay: 4500, disableOnInteraction: false },
      pagination: { el: '.swiper-pagination', clickable: true },
      breakpoints: {
        768: { slidesPerView: 2 },
        1100: { slidesPerView: 3 }
      }
    });
  }

  /* ---------------------------------------------------------------------
     GSAP subtle hero entrance
     --------------------------------------------------------------------- */
  if (window.gsap) {
    gsap.from('.hero-content > *', { y: 30, opacity: 0, stagger: 0.12, duration: 0.9, ease: 'power3.out', delay: 0.2 });
  }

  /* Footer year */
  document.getElementById('year').textContent = new Date().getFullYear();
});
