let lottozahl_max_swiss = 42;
let lottozahl_max_euro = 50;
let glueckzahl_min = 1;
let anzahl_lottozahlen = 6;
let random_arr = [];
let number_of_swiss_plates = 4;

function create_lottonumbers(glueckzahl_max, lottozahl_max) {
    let arr = [];

    if (random_arr.length >= anzahl_lottozahlen) {

        // pick numbers of the random_arr array
        for (let ii = 0; ii < anzahl_lottozahlen; ii++) {
            const random = Math.floor(Math.random() * random_arr.length);
            arr[ii] = random_arr[random];
        }

        // remove dublicates
        while (remove_dublicates(arr).length < anzahl_lottozahlen) {
            for (let zz = remove_dublicates(arr).length; zz < anzahl_lottozahlen; zz++) {
                const random = Math.floor(Math.random() * random_arr.length);
                arr[zz] = random_arr[random];
            }
        }

    } else {
        alert("Nicht genügend Zahlen ausgewählt");
    }

    // sort in numerical order
    arr.sort((a, b) => a - b);

    // fill <p>-Tags
    for (let b = 0; b < anzahl_lottozahlen; b++) {
        let id = b + 1;
        document.getElementById("box" + id).innerHTML = arr[b].toString();
    }

    // Glückszahlen
    let glueck_z1 = Math.floor(Math.random() * glueckzahl_max) + glueckzahl_min;
    document.getElementById("box7").innerHTML = glueck_z1;

    let glueck_z2 = 0;

    if(lottozahl_max === lottozahl_max_euro){
        glueck_z2 = Math.floor(Math.random() * glueckzahl_max) + glueckzahl_min;

        // remove dublicates
        while(glueck_z1 === glueck_z2){
            glueck_z2 = Math.floor(Math.random() * glueckzahl_max) + glueckzahl_min;
        }
        document.getElementById("box8").innerHTML = glueck_z2;
    }


    create_table(arr, glueck_z1, glueck_z2, "tab", lottozahl_max);
}

function remove_dublicates(arr) {
    arr.sort();
    for (let j = 0; j < arr.length - 1; j++) {
        if (arr[j + 1] === arr[j]) {
            arr.splice(j, 1);
            j--;
        }
    }
    return arr;
}

function create_table(arr, glueck_z1, glueck_z2, tabid, lottozahl_max) {
    let table = document.getElementById(tabid);
    let row = table.insertRow(0);
    for (let cel = 0; cel < lottozahl_max; cel++) {
        let cell = row.insertCell(cel);
        cel_plus1 = cel + 1;
        cell.innerHTML = cel_plus1;
        cell.style.width = "20px";
        cell.style.fontFamily = "Arial";
        cell.style.fontSize = "14px";
        cell.style.backgroundColor = "white";
        cell.style.color = "#1a2c3f";
        switch(cel_plus1){
            case glueck_z1:
                cell.style.color = "#DB5353";
                cell.style.fontWeight = "bold";
                break;
            case glueck_z2:
                cell.style.color = "#DB5353";
                cell.style.fontWeight = "bold";
                break;
        }
        for (let i = 0; i < arr.length; i++) {
            if (cel_plus1 === arr[i]) {
                cell.style.backgroundColor = "#1979a9";
            }
        }
    }
}

function create_detailed_table(id, sa_mi) {
    var myTableDiv = document.getElementById(id);

    var table = document.createElement('TABLE');
    var tableBody = document.createElement('TBODY');
    table.appendChild(tableBody);
    table.style.marginBottom = '40px';
    table.style.marginLeft = '40px';
    cellinnerHTML = 1;
    for (var i = 0; i < 7; i++) {
        var tr = document.createElement('TR');
        tableBody.appendChild(tr);
        for (var j = 0; j < 6; j++) {
            var td = document.createElement('TD');
            node = document.createTextNode(cellinnerHTML);
            td.id = sa_mi + cellinnerHTML;
            td.style.backgroundColor = 'white';
            td.style.padding = '3px';
            td.style.fontFamily = "Arial";
            td.style.fontSize = "14px";
            td.appendChild(node);
            tr.appendChild(td);
            cellinnerHTML++;
        }
    }
    myTableDiv.appendChild(table);
}

function create_buttons(lottozahl_max) {

    // remove the previous buttons
    let list = document.getElementById("random_buttons");
    while(list.firstChild){
        list.removeChild(list.firstChild);
    }

    // add the buttons
    for (let i = 1; i <= lottozahl_max; i++) {
        let button = document.createElement("button");
        document.getElementById("random_buttons").appendChild(button);
        button.innerText = i;
        button.id = "random_button" + i;
        button.style = "background: white; border-width: 0px; color: #1979a9; margin-right: 5px; margin-top: 5px;";
        button.onclick = function () {
            let innerText = this.innerText;
            if (button.style.backgroundColor === "white") {
                button.style.backgroundColor = "#DB5353";
                button.style.color = "white";
                random_arr.push(Number(innerText));
            } else {
                button.style.backgroundColor = "white";
                button.style.color = "#1979a9";
                random_arr = random_arr.filter(function (item) {
                    return item !== Number(innerText);
                });
            }
        }
    }
}

function select_all_buttons(lottozahl_max) {
    for (let id = 1; id <= lottozahl_max; id++) {
        document.getElementById("random_button" + id).style.backgroundColor = "#DB5353";
        document.getElementById("random_button" + id).style.color = "white";
        random_arr.push(id);
    }
}

function deselect_all_buttons(lottozahl_max) {
    for (let id = 1; id <= lottozahl_max; id++) {
        document.getElementById("random_button" + id).style.backgroundColor = "white";
        document.getElementById("random_button" + id).style.color = "#1979a9";
    }
    random_arr = [];
}

window.onload = function() {
    document.getElementById('swiss').click();
}

function show_swisslotto() {
    document.getElementById("swiss_settings").style.display = 'block';
    document.getElementById("euro_settings").style.display = 'none';
    document.getElementById("zahl8").style.display = 'none';
    document.getElementById("the_big_button_euro").style.display = 'none';
    document.getElementById("the_big_button_swiss").style.display = 'block';
    document.getElementById("swiss_selector").style.display = 'block';
    document.getElementById("euro_selector").style.display = 'none';
    create_buttons(lottozahl_max_swiss);
    random_arr = [];

}

function show_euromillions() {
    document.getElementById("swiss_settings").style.display = 'none';
    document.getElementById("euro_settings").style.display = 'block';
    document.getElementById("zahl8").style.display = 'block';
    document.getElementById("the_big_button_euro").style.display = 'block';
    document.getElementById("the_big_button_swiss").style.display = 'none';
    document.getElementById("swiss_selector").style.display = 'none';
    document.getElementById("euro_selector").style.display = 'block';
    create_buttons(lottozahl_max_euro);
    random_arr = [];
}

function display() {
    var radioswiss = document.getElementsByName('swiss_radio');
    var radioeuro = document.getElementsByName('euro_radio');

    if(radioswiss[0].checked){
        for(let c=1; c<=number_of_swiss_plates; c++){
            document.getElementById("plate" + c).style.display = 'block';
        }
    }
    if(radioswiss[1].checked){
        document.getElementById("plate1").style.display = 'block';
        document.getElementById("plate2").style.display = 'block';
        document.getElementById("plate3").style.display = 'none';
        document.getElementById("plate4").style.display = 'none';
    }
    if(radioswiss[2].checked){
        document.getElementById("plate1").style.display = 'none';
        document.getElementById("plate2").style.display = 'none';
        document.getElementById("plate3").style.display = 'block';
        document.getElementById("plate4").style.display = 'block';
    }

    if(radioeuro[0].checked){
        //TODO
    }

}
