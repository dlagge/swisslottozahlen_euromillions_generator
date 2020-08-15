let lottozahl_max = 42;
let glueckzahl_max = 6;
let lottozahl_min = 1;
let glueckzahl_min = 1;
let anzahl_lottozahlen = 6;
let random_arr = [];

function create_lottonumbers() {
    let arr = [];

    if(document.getElementById('all_sel').checked) {

        // create random numbers
        for (let i = 0; i < anzahl_lottozahlen; i++) {
            arr[i] = Math.floor(Math.random() * lottozahl_max) + lottozahl_min;
        }

        // remove dublicates
        while (remove_dublicates(arr).length < anzahl_lottozahlen) {
            for (let z = remove_dublicates(arr).length; z < anzahl_lottozahlen; z++) {
                arr[z] = Math.floor(Math.random() * lottozahl_max) + lottozahl_min;
            }
        }
    } else if(document.getElementById('random_sel').checked) {
        if(random_arr.length >= 6){
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

            // Convert to numbers
            for(let val=0; val<anzahl_lottozahlen; val++){
                arr[val] = Number(arr[val]);
            }

        } else {
            alert("Nicht genügend Zahlen ausgewählt");
        }
    }

    console.log(arr);
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


function create_buttons() {
    for(let i=1; i<=lottozahl_max; i++){
        let button = document.createElement("button");
        document.getElementById("random_buttons").appendChild(button);
        button.innerText = i;
        button.id = "random_button" + i;
        button.style = "background: white; border-width: 0px; color: #1979a9; margin-right: 5px; margin-top: 5px;";
        button.onclick = function(){
            let innerText = this.innerText;
            if(button.style.backgroundColor === "white"){
                button.style.backgroundColor = "#DB5353";
                button.style.color = "white";
                random_arr.push(innerText);
            } else {
                button.style.backgroundColor = "white";
                button.style.color = "#1979a9";
                random_arr = random_arr.filter(function(item) {
                    return item !== innerText;
                })
            }
        }
    }
}

function disable_buttons(){
    for(let id = 1; id <= lottozahl_max; id++){
        document.getElementById("random_button" + id).disabled = true;
        document.getElementById("random_button" + id).style.backgroundColor = "lightgrey";
        document.getElementById("random_button" + id).style.color = "#1979a9";
        random_arr = [];
    }
}

function enable_buttons(){
    for(let id = 1; id <= lottozahl_max; id++){
        document.getElementById("random_button" + id).disabled = false;
        document.getElementById("random_button" + id).style.backgroundColor = "white";
        document.getElementById("random_button" + id).style.color = "#1979a9";
        random_arr = [];
    }
}

function hide($id){
    if(document.getElementById($id).hidden === true){
        document.getElementById($id).hidden = false;
    } else {
        document.getElementById($id).hidden = true;
    }
}

