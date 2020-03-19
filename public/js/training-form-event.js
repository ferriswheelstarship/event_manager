function changeEventCarrerup(value) {
    var carrerup = document.getElementById("carrerup");
    var general = document.getElementById("general");

    if (value == 0) {
        carrerup.style.display = "none";
        general.style.display = "none";
    } else {
        if (value == "carrerup") {
            carrerup.style.display = "";
            general.style.display = "none";
        }
        if (value == "general") {
            general.style.display = "";
            carrerup.style.display = "none";
        }
    }
}
