document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('sn-wishlist-form');
  if (!form) return;

  const selectAll = form.querySelector('.global-cb');
  const status = document.getElementById('sn-wishlist-status');
  const deleteButton = document.getElementById('sn-wishlist-delete');
  const getCheckboxes = () => Array.from(form.querySelectorAll('input[name="wishlist_pr[]"]'));

  function updateSelection() {
    const checkboxes = getCheckboxes();
    const selected = checkboxes.filter(checkbox => checkbox.checked).length;
    selectAll.checked = checkboxes.length > 0 && selected === checkboxes.length;
    selectAll.indeterminate = selected > 0 && selected < checkboxes.length;
    selectAll.disabled = checkboxes.length === 0;
    deleteButton.disabled = checkboxes.length === 0;
  }

  function removeRows(rows) {
    rows.forEach(row => row.remove());
    updateSelection();
    status.textContent = getCheckboxes().length === 0
      ? 'Your wishlist is empty.'
      : rows.length + ' product' + (rows.length === 1 ? '' : 's') + ' deleted from your wishlist.';
  }

  selectAll.addEventListener('change', function () {
    getCheckboxes().forEach(checkbox => { checkbox.checked = selectAll.checked; });
    updateSelection();
  });

  form.addEventListener('change', function (event) {
    if (event.target.matches('input[name="wishlist_pr[]"]')) updateSelection();
  });

  deleteButton.addEventListener('click', function () {
    const rows = getCheckboxes().filter(checkbox => checkbox.checked)
      .map(checkbox => checkbox.closest('.wishlist_item'));
    if (!rows.length) {
      status.textContent = 'Please select a product to delete.';
      return;
    }
    removeRows(rows);
  });

  form.addEventListener('click', function (event) {
    const removeButton = event.target.closest('button[name="tinvwl-remove"]');
    if (!removeButton) return;
    event.preventDefault();
    removeRows([removeButton.closest('.wishlist_item')]);
  });

  updateSelection();
});
