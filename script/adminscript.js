<<<<<<< HEAD
function togglePasswordInput(button) {
    const td = button.parentElement;
    const input = td.querySelector('input[name="new_password"]');
    input.style.display = 'inline-block';
    input.focus();
    button.style.display = 'none'; // hide change button
}

function enableEdit(button) {
    const row = button.closest('tr');
    const inputs = row.querySelectorAll('input.cell-input:not(.readonly-field), input[name="new_password"]');

    inputs.forEach(input => {
        input.removeAttribute('readonly');
    });

    // Show Save button and hide Edit button
    row.querySelector('.save-btn').style.display = 'inline-block';
    button.style.display = 'none';
}

// Optional: Set current date for updated `created_date` if needed
function setCurrentDate(button) {
    const row = button.closest('tr');
    const dateInput = row.querySelector('input[name="created_date"]');
    const today = new Date().toISOString().slice(0, 10); // YYYY-MM-DD
    if (dateInput) {
        dateInput.value = today;
    }
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        const activeElement = document.activeElement;
        if (activeElement.tagName === 'INPUT') {
            event.preventDefault(); // Avoid accidental form submission
        }
    }
});

=======
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
>>>>>>> d27fa360e6497a947b0e3f18734c7d7c7f921c3f
