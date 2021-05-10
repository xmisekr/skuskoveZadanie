if(typeof(EventSource) !== "undefined") {
    var test_id = document.getElementById('test_id').value;
    var source = new EventSource(`pushAttendance.php?test_id=${test_id}`);

    source.addEventListener("message", function(e) {
        var data = JSON.parse(e.data);
   
        createRows(data);

    }, false);
}

function createRows(data){
    let tbody = document.getElementById('table-body');

    while (tbody.firstChild) {
        tbody.removeChild(tbody.lastChild);
    }

    for (let i = 0; i < data.length; i++){
        let row = document.createElement('tr');

        let name = document.createElement('td');
        name.innerHTML = data[i]['name'];
        row.appendChild(name);

        let surname = document.createElement('td');
        surname.innerHTML = data[i]['surname'];
        row.appendChild(surname);

        let inTest = document.createElement('td');
        if (data[i]['in_test']){
            inTest.innerHTML = 'Yes';

        }else{
            inTest.innerHTML = 'No';
        }
        row.appendChild(inTest);

        let completed = document.createElement('td');
        if (data[i]['completed']){
            completed.innerHTML = 'Yes';

        }else{
            completed.innerHTML = 'No';
        }
        row.appendChild(completed);

        tbody.appendChild(row);
    }
}