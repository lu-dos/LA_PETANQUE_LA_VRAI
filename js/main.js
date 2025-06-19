function init() {
  document.querySelectorAll('input[type="password"]').forEach(function (input) {
    const toggle = document.createElement('button');
    toggle.type = 'button';
    toggle.textContent = 'Afficher';
    toggle.className = 'toggle-password';
    toggle.addEventListener('click', function () {
      if (input.type === 'password') {
        input.type = 'text';
        toggle.textContent = 'Masquer';
      } else {
        input.type = 'password';
        toggle.textContent = 'Afficher';
      }
    });
    input.parentNode.insertBefore(toggle, input.nextSibling);
  });

  // Dark mode functionality removed

  if (!localStorage.getItem('cookiesAccepted')) {
    const banner = document.createElement('div');
    banner.className = 'cookie-banner';
    banner.innerHTML = '<p>Ce site utilise des cookies pour améliorer votre expérience.</p>';
    const btnContainer = document.createElement('div');
    btnContainer.className = 'cookie-buttons';
    const acceptBtn = document.createElement('button');
    acceptBtn.textContent = 'Accepter';
    const declineBtn = document.createElement('button');
    declineBtn.textContent = 'Refuser';
    btnContainer.appendChild(acceptBtn);
    btnContainer.appendChild(declineBtn);
    banner.appendChild(btnContainer);
    document.body.appendChild(banner);

    function removeBanner() {
      banner.remove();
    }

    acceptBtn.addEventListener('click', function () {
      localStorage.setItem('cookiesAccepted', 'yes');
      removeBanner();
    });
    declineBtn.addEventListener('click', removeBanner);
  }

  const scrollBtn = document.createElement('button');
  scrollBtn.id = 'scroll-top';
  scrollBtn.textContent = '↑';
  scrollBtn.className = 'scroll-top-button';
  document.body.appendChild(scrollBtn);

  window.addEventListener('scroll', function () {
    if (window.scrollY > 200) {
      scrollBtn.style.display = 'block';
    } else {
      scrollBtn.style.display = 'none';
    }
  });

  scrollBtn.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  const manageBtn = document.getElementById('siteManagerBtn');
  const manageMenu = document.getElementById('siteManagerMenu');
  if (manageBtn && manageMenu) {
    manageBtn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      manageMenu.style.display =
        manageMenu.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function (e) {
      if (!manageMenu.contains(e.target) && !manageBtn.contains(e.target)) {
        manageMenu.style.display = 'none';
      }
    });
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
