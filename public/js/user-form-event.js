function changeEventFacility(value) {
    var facilities = document.getElementById("only-indivisual-user");

    if (value == "なし") {
        facilities.style.display = "";
    } else {
        facilities.style.display = "none";
    }
}

function changeEventChildminder(value) {
    var childminder = document.getElementById("childminder-number-section");

    if (value == "保育士番号あり") {
        childminder.style.display = "";
    } else {
        childminder.style.display = "none";
    }

}