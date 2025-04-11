function showTable(table) {
    fetch(`/get-table/${table}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('tableContainer').innerHTML = html;
        });
}
