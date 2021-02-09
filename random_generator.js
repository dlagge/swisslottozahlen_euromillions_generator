let lottozahl_max_swiss = 42;
let lottozahl_max_euro = 50;
let glueckzahl_min = 1;
let random_arr = [];
let number_of_plates = 12;

function create_lottonumbers(glueckzahl_max, lottozahl_max, anzahl_lottozahlen) {
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

function create_detailed_table(id, sa_mi_di_fr, a_reihen, a_spalten) {
    let myTableDiv = document.getElementById(id);
    let table = document.createElement('TABLE');
    let tableBody = document.createElement('TBODY');
    table.appendChild(tableBody);
    table.style.marginBottom = '40px';
    table.style.marginLeft = '40px';
    let cellinnerHTML = 1;
    for (let i = 0; i < a_spalten; i++) {
        let tr = document.createElement('TR');
        tableBody.appendChild(tr);
        for (let j = 0; j < a_reihen; j++) {
            let td = document.createElement('TD');
            node = document.createTextNode(cellinnerHTML);
            td.id = sa_mi_di_fr + cellinnerHTML;
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

function show_swisslotto() {
    document.getElementsByName('swiss_euro_radio')[0].click();
    document.getElementsByName('numsel_swiss')[0].click();
    document.getElementById("plate0").style.display = 'block';
    document.getElementById("swiss_settings").style.display = 'block';
    document.getElementById("euro_settings").style.display = 'none';
    document.getElementById("zahl8").style.display = 'none';
    document.getElementById("zahl6").style.display = 'block';
    document.getElementById("the_big_button_euro").style.display = 'none';
    document.getElementById("the_big_button_swiss").style.display = 'block';
    document.getElementById("swiss_selector").style.display = 'block';
    document.getElementById("euro_selector").style.display = 'none';
    random_arr = [];
    create_buttons(lottozahl_max_swiss);
    select_all_buttons(42);
}

function show_euromillions() {
    document.getElementsByName('swiss_euro_radio')[3].click();
    document.getElementsByName('numsel_euro')[0].click();
    document.getElementById("plate0").style.display = 'block';
    document.getElementById("swiss_settings").style.display = 'none';
    document.getElementById("euro_settings").style.display = 'block';
    document.getElementById("zahl8").style.display = 'block';
    document.getElementById("zahl6").style.display = 'none';
    document.getElementById("the_big_button_euro").style.display = 'block';
    document.getElementById("the_big_button_swiss").style.display = 'none';
    document.getElementById("swiss_selector").style.display = 'none';
    document.getElementById("euro_selector").style.display = 'block';
    random_arr = [];
    create_buttons(lottozahl_max_euro);
    select_all_buttons(50);
}

function display() {
    let radio_euro_swiss = document.getElementsByName('swiss_euro_radio');

    if(radio_euro_swiss[0].checked){
        for(let c=1; c<=number_of_plates; c++){
            if(c === 9 || c === 10){
                document.getElementById("plate" + c).style.display = 'block';
            } else {
                document.getElementById("plate" + c).style.display = 'none';
            }
        }
    }
    if(radio_euro_swiss[1].checked){
        for(let c=1; c<=number_of_plates; c++){
            if(c === 1 || c === 2){
                document.getElementById("plate" + c).style.display = 'block';
            } else {
                document.getElementById("plate" + c).style.display = 'none';
            }
        }
    }
    if(radio_euro_swiss[2].checked){
        for(let c=1; c<=number_of_plates; c++) {
            if (c === 3 || c === 4) {
                document.getElementById("plate" + c).style.display = 'block';
            } else {
                document.getElementById("plate" + c).style.display = 'none';
            }
        }
    }
    if(radio_euro_swiss[3].checked){
        for(let c=1; c<=number_of_plates; c++){
            if(c === 11 || c === 12){
                document.getElementById("plate" + c).style.display = 'block';
            } else {
                document.getElementById("plate" + c).style.display = 'none';
            }
        }
    }
    if(radio_euro_swiss[4].checked){
        for(let c=1; c<=number_of_plates; c++) {
            if (c === 5 || c === 6) {
                document.getElementById("plate" + c).style.display = 'block';
            } else {
                document.getElementById("plate" + c).style.display = 'none';
            }
        }
    }
    if(radio_euro_swiss[5].checked){
        for(let c=1; c<=number_of_plates; c++) {
            if (c === 7 || c === 8) {
                document.getElementById("plate" + c).style.display = 'block';
            } else {
                document.getElementById("plate" + c).style.display = 'none';
            }
        }
    }
}
