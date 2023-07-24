var navbar = document.getElementById("app-navbar");
function navController(conditon) {
    if (conditon) {
        navbar.classList.remove("nav_fixed");
        navbar.classList.add("nav_static");
    } else {
        navbar.classList.remove("nav_static");
        navbar.classList.add("nav_fixed");
    }
}

function getYPosition() {
    var top = window.pageYOffset || document.documentElement.scrollTop;
    navController(top > 50);
}

document.getElementById("mobile-menu").addEventListener("click", () => {
    var className = navbar.classList[navbar.classList.length - 1];

    var top = window.pageYOffset || document.documentElement.scrollTop;
    if (top > 50) {
        navController(className === "nav_static");
    } else {
        navController(className === "nav_fixed");
    }
});

function scrollFunction(className) {
    let wrapper = document.querySelector(`.${className}`);

    wrapper.scrollIntoView({
        behavior: "smooth",
        block: "end",
        inline: "nearest",
    });
}
