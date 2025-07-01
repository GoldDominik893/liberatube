// #########################################################################
// ## toast.js - FRAMEWORK BUILT BY DOMINIC WAJDA FOR TOAST NOTIFICATIONS ##
// ## COPYRIGHT (C) 2025 DOMINIC WAJDA - EPICSITE.XYZ                     ##
// ## LICENSED UNDER THE MIT LICENSE                                      ##
// #########################################################################

(function () {
  // Create toast container if it doesn't exist
  if (!document.getElementById('toast-container')) {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.style.position = 'fixed';
    container.style.top = '20px';
    container.style.right = '20px';
    container.style.display = 'flex';
    container.style.flexDirection = 'column';
    container.style.gap = '10px';
    container.style.zIndex = '9999';
    document.body.appendChild(container);
  }

  // Toast function
  window.toast = function (type, message, duration = 3000) {
    const toast = document.createElement('div');
    toast.className = 'toast-' + type;

    const iconMap = {
      success: 'check_circle',
      error: 'error',
      info: 'info'
    };

    // Base styles
    toast.style.display = 'flex';
    toast.style.alignItems = 'center';
    toast.style.gap = '12px';
    toast.style.padding = '12px 16px';
    toast.style.borderRadius = '6px';
    toast.style.fontFamily = 'Segoe UI, sans-serif';
    toast.style.boxShadow = '0 4px 10px rgba(0,0,0,0.4)';
    toast.style.color = '#fff';
    toast.style.background = {
      success: 'linear-gradient(to right, #2ecc71 6px, #2a2a2a 6px)',
      error:   'linear-gradient(to right, #e74c3c 6px, #2a2a2a 6px)',
      info:    'linear-gradient(to right, #3498db 6px, #2a2a2a 6px)'
    }[type] || 'linear-gradient(to right, #555 6px, #2a2a2a 6px)';

    toast.style.transition = 'all 0.3s ease';
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(-20px)';

    // Icon span
    const icon = document.createElement('span');
    icon.className = 'material-symbols-outlined';
    icon.textContent = iconMap[type] || 'info';
    icon.style.fontSize = '20px';

    // Message span
    const text = document.createElement('span');
    text.textContent = message;

    toast.appendChild(icon);
    toast.appendChild(text);

    document.getElementById('toast-container').appendChild(toast);

    // Animate in
    requestAnimationFrame(() => {
      toast.style.opacity = '1';
      toast.style.transform = 'translateY(0)';
    });

    // Animate out
    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateY(-20px)';
      toast.addEventListener('transitionend', () => toast.remove());
    }, duration);
  };
})();