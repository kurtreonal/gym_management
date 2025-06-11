function enableEdit(btn) {
    const row = btn.closest('tr');
    const inputs = row.querySelectorAll('.cell-input');

    inputs.forEach(input => input.removeAttribute('readonly'));

    btn.style.display = 'none';
    btn.nextElementSibling.style.display = 'inline-block';
}

function saveEdit(btn) {
    const row = btn.closest('tr');
    const inputs = row.querySelectorAll('.cell-input');

    inputs.forEach(input => input.setAttribute('readonly', true));

    btn.style.display = 'none';
    btn.previousElementSibling.style.display = 'inline-block';

    // You can add AJAX here to send updated data to the server
    alert('Changes saved (client-side). Implement backend update logic.');
}