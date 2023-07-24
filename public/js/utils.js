window.onload = function () {
    //hide the preloader
    document.querySelector("#preloader").style.display = "none";
    document.querySelector("#loader").style.display = "none";
};

window.idSelector = function (value) {
    return document.getElementById(value);
};

window.classSelector = function (value) {
    return document.getElementsByClassName(value);
};

// route change
window.isNavigate = function (value) {
    window.location.href = value;
};

window.showMessage = function (elementId, message, duration) {
    let showError = document.getElementById(elementId);
    showError.classList.remove("d-none");
    showError.classList.add("d-block");
    showError.innerText = message;
    setTimeout(() => {
        showError.classList.add("d-none");
        showError.classList.remove("d-block");
    }, duration);
};

window.copyAnchorHref = function (textBoxId) {
    var copyText = document.getElementById(textBoxId);
    navigator.clipboard.writeText(copyText.href);

    return "Copied";
};

// window.addEventListener("onload", function () {
//     document.querySelector("body").classList.add("loaded");
// });
