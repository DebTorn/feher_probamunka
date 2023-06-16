document.getElementById('listItemsBtn').addEventListener('click', function() {
    var url = document.getElementById('urlIn').value;
    var spinner = document.getElementById('spinner');
    var list = document.getElementById('list');
    var listItemsBtn = document.getElementById('listItemsBtn');

    spinner.style.display = 'block';
    list.innerHTML = '';

    listItemsBtn.disabled = true;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/probamunka/analysis/process', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            var table = '<table class="table table-striped">';

            for (var i = 0; i < response.length; i++) {
                table += '<tr>';

                for (var j = 0; j < response[i].length; j++) {
                    table += '<td>' + response[i][j] + '</td>';
                }

                table += '</tr>';
            }

            table += '</table>';

            spinner.style.display = 'none';
            list.innerHTML = table;
            listItemsBtn.disabled = false;
        }
    };

    xhr.send('urlIn=' + encodeURIComponent(url));
});