function changeEventJob(value) {
    var jobs = document.getElementById("only-nursery");

    if (value == "保育士・保育教諭") {
        jobs.style.display = "";
    } else {
        jobs.style.display = "none";
    }
}

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
