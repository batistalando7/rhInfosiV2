// public/assets/js/theme-settings.js
document.addEventListener('DOMContentLoaded', function() {
  const openBtn = document.getElementById('themeSettingsBtn') || document.getElementById('themeSettingsFloatingBtn');
  const floatingBtn = document.getElementById('themeSettingsFloatingBtn');
  const panel = document.getElementById('duraluxThemePanel');
  const closeBtn = document.getElementById('closeThemePanel');
  const themeOptions = document.querySelectorAll('.theme-option');
  const sidebarToggle = document.getElementById('sidebarDarkToggle');
  const navbarToggle = document.getElementById('navbarDarkToggle');
  const fontSelect = document.getElementById('fontSelect');
  const applyBtn = document.getElementById('applyThemeSettings');
  const resetBtn = document.getElementById('resetThemeSettings');
  const themeToggleNav = document.getElementById('themeToggleNav');

  const KEY_THEME = 'duralux_theme_global';
  const KEY_SIDEBAR = 'duralux_theme_sidebar';
  const KEY_NAVBAR = 'duralux_theme_navbar';
  const KEY_FONT = 'duralux_theme_font';

  function togglePanel(show) {
    if (!panel) return;
    panel.style.display = (show ? 'block' : 'none');
  }
  if (openBtn) openBtn.addEventListener('click', () => togglePanel(true));
  if (floatingBtn) floatingBtn.addEventListener('click', () => togglePanel(true));
  if (closeBtn) closeBtn.addEventListener('click', () => togglePanel(false));

  function applySettingsFromStorage() {
    const theme = localStorage.getItem(KEY_THEME) || null;
    const sidebar = localStorage.getItem(KEY_SIDEBAR) || 'off';
    const navbar = localStorage.getItem(KEY_NAVBAR) || 'off';
    const font = localStorage.getItem(KEY_FONT) || 'default';

    if (theme) {
      document.documentElement.setAttribute('data-bs-theme', theme);
      if (themeToggleNav) {
        const icon = themeToggleNav.querySelector('i');
        if (icon) icon.className = (theme === 'dark' ? 'fas fa-moon' : 'fas fa-sun');
      }
    }

    const sidebarEl = document.getElementById('app-sidebar') || document.getElementById('layoutSidenav_nav');
    if (sidebarEl) {
      if (sidebar === 'on') sidebarEl.classList.add('duralux-sidebar-dark');
      else sidebarEl.classList.remove('duralux-sidebar-dark');
    }
    if (sidebarToggle) sidebarToggle.checked = (sidebar === 'on');

    const navbarEl = document.querySelector('.nxl-navbar');
    if (navbarEl) {
      if (navbar === 'on') navbarEl.classList.add('duralux-navbar-dark');
      else navbarEl.classList.remove('duralux-navbar-dark');
    }
    if (navbarToggle) navbarToggle.checked = (navbar === 'on');

    if (font === 'serif') {
      document.documentElement.classList.remove('font-mono');
      document.documentElement.classList.add('font-serif');
    } else if (font === 'mono') {
      document.documentElement.classList.remove('font-serif');
      document.documentElement.classList.add('font-mono');
    } else {
      document.documentElement.classList.remove('font-serif');
      document.documentElement.classList.remove('font-mono');
    }
    if (fontSelect) fontSelect.value = font;

    if (themeOptions && themeOptions.length) {
      themeOptions.forEach(btn => btn.classList.toggle('active', btn.dataset.theme === theme));
    }
  }

  if (themeOptions && themeOptions.length) {
    themeOptions.forEach(btn => btn.addEventListener('click', function() {
      themeOptions.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      localStorage.setItem(KEY_THEME, btn.dataset.theme);
      applySettingsFromStorage();
    }));
  }

  if (sidebarToggle) {
    sidebarToggle.addEventListener('change', function() {
      localStorage.setItem(KEY_SIDEBAR, this.checked ? 'on' : 'off');
      applySettingsFromStorage();
    });
  }

  if (navbarToggle) {
    navbarToggle.addEventListener('change', function() {
      localStorage.setItem(KEY_NAVBAR, this.checked ? 'on' : 'off');
      applySettingsFromStorage();
    });
  }

  if (fontSelect) {
    fontSelect.addEventListener('change', function() {
      localStorage.setItem(KEY_FONT, this.value);
      applySettingsFromStorage();
    });
  }

  if (applyBtn) {
    applyBtn.addEventListener('click', function() {
      applySettingsFromStorage();
      togglePanel(false);
    });
  }

  if (resetBtn) {
    resetBtn.addEventListener('click', function() {
      localStorage.removeItem(KEY_THEME);
      localStorage.removeItem(KEY_SIDEBAR);
      localStorage.removeItem(KEY_NAVBAR);
      localStorage.removeItem(KEY_FONT);
      applySettingsFromStorage();
    });
  }

  if (themeToggleNav) {
    themeToggleNav.addEventListener('click', function() {
      const current = document.documentElement.getAttribute('data-bs-theme') || 'light';
      const next = current === 'dark' ? 'light' : 'dark';
      localStorage.setItem(KEY_THEME, next);
      applySettingsFromStorage();
    });
  }

  applySettingsFromStorage();
});
