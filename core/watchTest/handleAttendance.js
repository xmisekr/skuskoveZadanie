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
        row.classList.add("row2");

        let name = document.createElement('td');
        name.innerHTML = data[i]['name'];
        name.classList.add("cell");
        row.appendChild(name);

        let surname = document.createElement('td');
        surname.innerHTML = data[i]['surname'];
        surname.classList.add("cell");
        row.appendChild(surname);

        let inTest = document.createElement('td');
        inTest.classList.add("cell");
        let icon = document.createElement('i');

        if (data[i]['in_test']){
            icon.className = "fa fa-check";

        }else{
            icon.className = "fa fa-times";
        }
        inTest.appendChild(icon);
        row.appendChild(inTest);

        let completed = document.createElement('td');
        icon = document.createElement('i');
        completed.classList.add("cell");

        if (data[i]['completed']){
            icon.className = "fa fa-check";

        }else{
            icon.className = "fa fa-times";
        }
        completed.appendChild(icon);
        row.appendChild(completed);

        tbody.appendChild(row);
    }
}