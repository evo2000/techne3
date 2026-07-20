function filter_all () {
    const personal = document.getElementsByClassName("personal");
    const school = document.getElementsByClassName("school");
    for (let i = 0; i < personal.length; i++) {
        personal[i].style.display = "inline";
    }
    for (let i = 0; i < school.length; i++) {
        school[i].style.display = "inline";
    }
}

function filter_personal () {
    const personal = document.getElementsByClassName("personal");
    const school = document.getElementsByClassName("school");
    for (let i = 0; i < personal.length; i++) {
        personal[i].style.display = "inline";
    }
    for (let i = 0; i < school.length; i++) {
        school[i].style.display = "none";
    }
}

function filter_school () {
    const personal = document.getElementsByClassName("personal");
    const school = document.getElementsByClassName("school");
    for (let i = 0; i < personal.length; i++) {
        personal[i].style.display = "none";
    }
    for (let i = 0; i < school.length; i++) {
        school[i].style.display = "inline";
    }
}