function changeEventName(value) {
    var namesection = document.getElementById("name-section");
    var fullnamesection = document.getElementById("fullname-section");
    var rubysection = document.getElementById("ruby-section");
    var fullrubysection = document.getElementById("fullruby-section");

    if (value == 4) {
        fullnamesection.style.display = "";
        namesection.style.display = "none";
        fullrubysection.style.display = "";
        rubysection.style.display = "none";
    } else if (value > 0) {
        fullnamesection.style.display = "none";
        namesection.style.display = "";
        fullrubysection.style.display = "none";
        rubysection.style.display = "";
    } else {
        fullnamesection.style.display = "none";
        namesection.style.display = "none";
        fullrubysection.style.display = "none";
        rubysection.style.display = "none";
    }

}
