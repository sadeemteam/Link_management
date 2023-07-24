let sidebar = document.getElementById("mobileSidebar");

let expandSidebar = document.getElementById("expandSidebar");
let closeSidebar = document.getElementById("closeSidebar");

expandSidebar.addEventListener("click", function () {
    sidebar.classList.add("active");
});
closeSidebar.addEventListener("click", function () {
    sidebar.classList.remove("active");
});

(function () {
    function displayWindowSize() {
        let myWidth = window.innerWidth;
        // let myHeight = window.innerHeight;
        if (myWidth > 991) {
            sidebar.classList.remove("active");
        }
    }

    if (window.onresize) {
        displayWindowSize();
    }
    if (window.onload) {
        displayWindowSize();
    }
})();
