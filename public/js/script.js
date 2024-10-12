
function showAlert(message, type) {
    const alertContainer = document.getElementById('toast');
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.setAttribute('role', 'alert');
    alertDiv.innerHTML = message;
    alertContainer.appendChild(alertDiv);

    setTimeout(() => {
        alertDiv.style.display = 'none';
        location.reload();
    }, 2000);
}