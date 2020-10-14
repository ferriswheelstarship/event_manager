function changeType(value) {
    var general = document.getElementById("general");
    var regisrration = document.getElementById("regisrration");

    if (value == 0) {
        regisrration.style.display = "none";
        general.style.display = "none";
    } else {
        if (value == "general") {
            general.style.display = "";
            regisrration.style.display = "none";
        }
        if (value == "regisrration") {
            general.style.display = "none";
            regisrration.style.display = "";
        }
    }
}


function changeProblem(value) {
    var solution_a = document.getElementById("solution_a");
    var solution_b = document.getElementById("solution_b");

    if (value == 0) {
        solution_a.style.display = "none";
        solution_b.style.display = "none";
    } else {
        if (value == "仮登録時の返信メールが届かない") {
            solution_a.style.display = "none";
            solution_b.style.display = "";
        }
        if (value == "仮登録時の返信メールは届くがメールのURLにアクセスできない") {
            solution_a.style.display = "";
            solution_b.style.display = "none";
        }
    }
}

function changeSolution(value) {
    var self = document.getElementById("self");
    var request = document.getElementById("request");

    if (value == 0) {
        self.style.display = "none";
        request.style.display = "none";
    } else {
        if (value == "登録代行を依頼したい") {
            self.style.display = "none";
            request.style.display = "";
        }
        if (value == "登録は自分でするので本登録URLを送ってほしい") {
            self.style.display = "";
            request.style.display = "none";
        }
    }
}