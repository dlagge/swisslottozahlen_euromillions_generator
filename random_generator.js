let lottozahl_max = 42;
let glueckzahl_max = 6;
let glueckzahl_min = 1;
let anzahl_lottozahlen = 6;
let random_arr = [];
let number_of_swiss_plates = 4;

function create_lottonumbers() {
    let arr = [];

    if (random_arr.length >= 6) {
        console.log(random_arr.length);
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

    // Glückszahl
    let glueck_z = Math.floor(Math.random() * glueckzahl_max) + glueckzahl_min;
    document.getElementById("box7").innerHTML = glueck_z;

    create_table(arr, glueck_z, "tab");
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

function create_table(arr, glueck_z, tabid) {
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
        if (cel_plus1 === glueck_z) {
            cell.style.color = "#DB5353";
            cell.style.fontWeight = "bold";
        } else {
            cell.style.color = "#1a2c3f";
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

function create_buttons() {
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
                console.log(random_arr);
            }
        }
    }
}

function select_all_buttons() {
    for (let id = 1; id <= lottozahl_max; id++) {
        document.getElementById("random_button" + id).style.backgroundColor = "#DB5353";
        document.getElementById("random_button" + id).style.color = "white";
        random_arr.push(id);
    }
}

function deselect_all_buttons() {
    for (let id = 1; id <= lottozahl_max; id++) {
        document.getElementById("random_button" + id).style.backgroundColor = "white";
        document.getElementById("random_button" + id).style.color = "#1979a9";
    }
    random_arr = [];
}

function show_swisslotto() {
    document.getElementById("swiss_settings").style.display = 'block';
    document.getElementById("euro_settings").style.display = 'none';
}

function show_euromillions() {
    document.getElementById("swiss_settings").style.display = 'none';
    document.getElementById("euro_settings").style.display = 'block';
}

function display() {
    var radiosswiss = document.getElementsByName('swiss_radio');
    if(radiosswiss[0].checked){
        for(let c=1; c<=number_of_swiss_plates; c++){
            document.getElementById("plate" + c).style.display = 'block';
        }
    }
    if(radiosswiss[1].checked){
        document.getElementById("plate1").style.display = 'block';
        document.getElementById("plate2").style.display = 'block';
        document.getElementById("plate3").style.display = 'none';
        document.getElementById("plate4").style.display = 'none';
    }
    if(radiosswiss[2].checked){
        document.getElementById("plate1").style.display = 'none';
        document.getElementById("plate2").style.display = 'none';
        document.getElementById("plate3").style.display = 'block';
        document.getElementById("plate4").style.display = 'block';
    }
}
