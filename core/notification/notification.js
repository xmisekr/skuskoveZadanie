
if(typeof(EventSource) !== "undefined") {
    var teacher_id = document.getElementById('teacher_id').value;
    var source = new EventSource(`../notification/pushNotification.php?teacher_id=${teacher_id}`);
    var counter = document.getElementById('notification-counter');
    var menu = document.getElementById('dropdown-menu');

    source.addEventListener("message", function(e) {
        var data = JSON.parse(e.data);
   
        addMessage(data);
        counter.innerHTML = menu.childElementCount;

    }, false);
}

function addMessage(data){
    let menu = document.getElementById('dropdown-menu');

    for (let i = 0; i < data.length; i++){
        let li = document.createElement('li');
        li.classList.add("dropdown-item");
        li.innerHTML = data[i]['message'];

        menu.appendChild(li);
    }
}

var toggle = false;

function clearCounter(){
    var dropdown = document.getElementById('dropdown');
    
    dropdown.addEventListener('click', ()=>{
        setTimeout(()=>{
            toggle = true;
        },100);
    })

    
}

document.addEventListener('click', ()=>{
    if (toggle == true){
        var menu = document.getElementById('dropdown-menu');
        toggle = false;

        while (menu.firstChild) {
            menu.removeChild(menu.lastChild);
        }
        counter.innerHTML = "0";
    }
})

clearCounter();