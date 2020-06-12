function changeEmailGroup(value) {
    var event_group = document.getElementById("event_group");

    if (value != '研修ごとの参加（予定）者') {
        event_group.style.display = "none";
    } else {
        event_group.style.display = "";
    }
}
