(() => {
  'use strict';
  const modalElement = document.getElementById('snInquiryModal');
  const opener = document.querySelector('.sn-inquiry-open');
  const product = opener?.closest('.product-about');
  if (!modalElement || !product || !window.bootstrap?.Modal) return;

  // Keep the dialog outside page animation and stacking contexts.
  if (modalElement.parentNode !== document.body) {
    document.body.appendChild(modalElement);
  }

  modalElement.addEventListener('show.bs.modal', () => {
    document.body.classList.add('sn-inquiry-visible');
  });
  modalElement.addEventListener('hidden.bs.modal', () => {
    document.body.classList.remove('sn-inquiry-visible');
  });

  const form = modalElement.querySelector('form');
  const fields = Object.fromEntries(Array.from(form.querySelectorAll('[name]'), field => [field.name, field]));
  const quantityInput = product.querySelector('.qty-input');
  const status = form.querySelector('.sn-inquiry-status');
  const submitButton = form.querySelector('[type="submit"]');
  const modal = new bootstrap.Modal(modalElement, { backdrop: 'static', keyboard: true });
  const currency = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR', maximumFractionDigits: 2 });
  let snapshot;
  let submitting = false;

  function readProduct() {
    const priceElement = product.querySelector('.product-price')?.cloneNode(true);
    priceElement?.querySelectorAll('del, s').forEach(element => element.remove());
    const priceText = priceElement?.textContent || '';
    const match = priceText.replace(/,/g, '').match(/[+-]?\d+(?:\.\d+)?/);
    const prodIdInput = form.querySelector('[name="product_id"]');
    return {
      productId: prodIdInput ? prodIdInput.value : '',
      productName: product.querySelector('.product-title')?.textContent.trim() || '',
      quantity: Number(quantityInput?.value) || 5,
      min: Math.max(1, Number(quantityInput?.min) || 1),
      max: quantityInput?.max ? Number(quantityInput.max) : Infinity,
      unitPrice: match ? Number(match[0]) : NaN
    };
  }

  function validQuantity(data) {
    return Number.isSafeInteger(data.quantity) && data.quantity >= data.min && data.quantity <= data.max;
  }

  function validPrice(data) {
    return Number.isFinite(data.unitPrice) && data.unitPrice > 0 && Number.isFinite(data.unitPrice * data.quantity);
  }

  function feedback(name, message) {
    const field = fields[name];
    if (!field) return !message;
    field.classList.toggle('is-invalid', Boolean(message));
    field.classList.toggle('is-valid', !message);
    field.setAttribute('aria-invalid', String(Boolean(message)));
    const errorEl = document.getElementById(`snInquiry-${name}-error`);
    if (errorEl) {
      errorEl.textContent = message || '';
    }
    return !message;
  }

  const VALIDATABLE = ['customerName', 'email', 'mobile', 'quantity', 'unitPrice', 'message', 'captcha_answer'];

  function validate(name) {
    const field = fields[name];
    if (!field || !VALIDATABLE.includes(name)) return true;
    const value = field.value ? field.value.trim() : '';
    let error = '';
    switch (name) {
      case 'customerName':
        if (!value) error = 'Please enter your full name.';
        else if (Array.from(value).length < 2) error = 'Name must contain at least 2 characters.';
        else if (Array.from(value).length > 100) error = 'Name must be 100 characters or less.';
        break;
      case 'email':
        if (!value || value.length > 254 || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) || field.validity?.typeMismatch) error = 'Please enter a valid email address.';
        break;
      case 'mobile':
        if (!/^[6-9]\d{9}$/.test(value)) error = 'Please enter a valid 10-digit mobile number.';
        break;
      case 'quantity': {
        const current = readProduct();
        if (!validQuantity(current) || current.quantity !== snapshot.quantity || Number(value) !== current.quantity) error = 'Please select a valid quantity, then reopen the inquiry form.';
        break;
      }
      case 'unitPrice': {
        const current = readProduct();
        if (!validPrice(current) || current.unitPrice !== snapshot.unitPrice || value !== currency.format(snapshot.unitPrice)) error = 'Unable to determine the product price. Please reopen the inquiry form.';
        break;
      }
      case 'message':
        if (!value) error = 'Please enter your inquiry message.';
        else if (value.length < 5) error = 'Message must contain at least 5 characters.';
        else if (value.length > 1000) error = 'Message must contain no more than 1000 characters.';
        break;
      case 'captcha_answer':
        if (!value) error = 'Please solve the security verification.';
        break;
    }
    return feedback(name, error);
  }

  async function submitInquiry(data) {
    const endpoint = form.dataset.endpoint.trim();
    if (!endpoint) return { configured: false };
    const url = new URL(endpoint, window.location.href);
    if (url.origin !== window.location.origin) throw new Error('The inquiry service configuration is invalid.');
    const controller = new AbortController();
    const timeout = setTimeout(() => controller.abort(), 15000);
    try {
      const response = await fetch(url, {
        method: 'POST', credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify(data), signal: controller.signal
      });
      if (!response.ok) {
        const errJson = await response.json().catch(() => ({}));
        throw new Error(errJson.message || 'The inquiry could not be sent. Please check your inputs.');
      }
      const result = await response.json();
      if (result.success !== true) throw new Error(result.message || 'The inquiry was not confirmed. Please try again.');
      return { configured: true };
    } finally { clearTimeout(timeout); }
  }

  opener.addEventListener('click', event => {
    event.preventDefault();
    if (submitting) return;
    snapshot = readProduct();
    const prodNameEl = modalElement.querySelector('.sn-inquiry-product');
    if (prodNameEl) prodNameEl.textContent = snapshot.productName;
    if (fields.quantity) {
      fields.quantity.min = snapshot.min;
      if (Number.isFinite(snapshot.max)) fields.quantity.max = snapshot.max;
      else fields.quantity.removeAttribute('max');
      fields.quantity.value = Number.isFinite(snapshot.quantity) ? snapshot.quantity : '';
    }
    if (fields.unitPrice) {
      fields.unitPrice.value = validPrice(snapshot) ? currency.format(snapshot.unitPrice) : '';
    }
    const totalEl = document.getElementById('snInquiryTotal');
    if (totalEl) {
      totalEl.textContent = validQuantity(snapshot) && validPrice(snapshot) ? currency.format(Math.round(snapshot.unitPrice * snapshot.quantity * 100) / 100) : '—';
    }
    Object.values(fields).forEach(field => {
      field.classList.remove('is-valid', 'is-invalid');
      field.removeAttribute('aria-invalid');
    });
    if (status) status.textContent = '';
    if (!validQuantity(snapshot)) validate('quantity');
    if (!validPrice(snapshot)) validate('unitPrice');
    modal.show();
  });

  modalElement.addEventListener('shown.bs.modal', () => {
    if (fields.customerName) fields.customerName.focus();
  });
  modalElement.addEventListener('hidden.bs.modal', () => {
    if (opener) opener.focus();
  });

  Object.values(fields).forEach(field => {
    field.addEventListener('input', () => {
      if (status) status.textContent = '';
      if (field.classList.contains('is-invalid') || field.classList.contains('is-valid')) validate(field.name);
    });
    field.addEventListener('blur', () => { if (snapshot) validate(field.name); });
  });

  form.addEventListener('submit', async event => {
    event.preventDefault();
    if (submitting || !snapshot) return;
    if (status) status.textContent = '';

    ['customerName', 'email', 'mobile', 'message'].forEach(name => {
      if (fields[name]) fields[name].value = fields[name].value.trim();
    });

    const fieldsToValidate = ['customerName', 'email', 'mobile', 'quantity', 'unitPrice', 'message'];
    if (fields.captcha_answer) {
      fieldsToValidate.push('captcha_answer');
    }
    const valid = fieldsToValidate.map(validate).every(Boolean);
    if (!valid) {
      const firstInvalid = form.querySelector('.is-invalid');
      if (firstInvalid) firstInvalid.focus();
      return;
    }

    const captchaAns = form.querySelector('[name="captcha_answer"]')?.value || '';
    const data = {
      product_id: form.querySelector('[name="product_id"]')?.value || snapshot.productId || '',
      productId: form.querySelector('[name="product_id"]')?.value || snapshot.productId || '',
      productName: snapshot.productName,
      customerName: fields.customerName ? fields.customerName.value : '',
      customer_name: fields.customerName ? fields.customerName.value : '',
      email: fields.email ? fields.email.value : '',
      customer_email: fields.email ? fields.email.value : '',
      mobile: fields.mobile ? fields.mobile.value : '',
      customer_phone: fields.mobile ? fields.mobile.value : '',
      quantity: snapshot.quantity,
      unitPrice: snapshot.unitPrice,
      totalPrice: Math.round(snapshot.unitPrice * snapshot.quantity * 100) / 100,
      message: fields.message ? fields.message.value : '',
      captcha_answer: captchaAns,
      captcha_token: form.querySelector('[name="captcha_token"]')?.value || '',
      website_hp: form.querySelector('[name="website_hp"]')?.value || form.querySelector('[name="inquiry_hp"]')?.value || '',
      inquiry_hp: form.querySelector('[name="inquiry_hp"]')?.value || form.querySelector('[name="website_hp"]')?.value || '',
      _form_time: form.querySelector('[name="_form_time"]')?.value || ''
    };

    submitting = true;
    submitButton.disabled = true;
    submitButton.textContent = 'Submitting…';
    form.setAttribute('aria-busy', 'true');

    try {
      const result = await submitInquiry(data);
      if (status) status.textContent = result.configured ? 'Your inquiry has been submitted.' : 'Your details are valid, but online inquiry submission is not connected yet.';
      if (result.configured) {
        ['customerName', 'email', 'mobile', 'message'].forEach(name => {
          if (fields[name]) {
            fields[name].value = '';
            fields[name].classList.remove('is-valid');
          }
        });
        if (window.Swal) {
          Swal.fire({
            icon: 'success',
            title: 'Inquiry Submitted!',
            text: 'Your inquiry has been submitted successfully. Our team will contact you shortly.',
            confirmButtonColor: '#084b87'
          });
          modal.hide();
        } else {
          alert('Inquiry submitted successfully!');
          modal.hide();
        }
      }
    } catch (error) {
      if (status) {
        status.textContent = error.message || (error.name === 'AbortError' ? 'The request timed out. Please try again.' : 'Unable to send your inquiry. Please try again later.');
      }
      form.querySelector('.sn-btn-refresh-captcha')?.click();
    } finally {
      submitting = false;
      submitButton.disabled = false;
      submitButton.textContent = 'Submit Inquiry';
      form.removeAttribute('aria-busy');
    }
  });
})();
