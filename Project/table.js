function toggleTable(tableId, button) {
    const table = document.getElementById(tableId);
    const thead = table.querySelector('thead');
    const tbody = table.querySelector('tbody');
    const icon = button.querySelector('i');

    if (thead.style.display === 'none') {
        thead.style.display = '';
        tbody.style.display = '';
        icon.classList.remove('bi-chevron-down');
        icon.classList.add('bi-chevron-up');
    } else {
        thead.style.display = 'none';
        tbody.style.display = 'none';
        icon.classList.remove('bi-chevron-up');
        icon.classList.add('bi-chevron-down');
    }
}
//Majd erre kell valami animáció mert nagyon ótvar.