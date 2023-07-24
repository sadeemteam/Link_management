function initialChanger(checked, id) {
    const element = document.getElementById(id);
    if (checked) {
        element.type = "text";
        element.value = "Unlimited";
        element.setAttribute("readonly", true);
    }
}
function typeChanger(checked, id) {
    const element = document.getElementById(id);
    if (checked) {
        element.type = "text";
        element.value = "Unlimited";
        element.setAttribute("readonly", true);
    } else {
        element.type = "number";
        element.value = "";
        element.removeAttribute("readonly", false);
    }
}

const biolink = document.getElementById("biolink");
const shortlink = document.getElementById("shortlink");
const project = document.getElementById("project");
const qrcode = document.getElementById("qrcode");

if (biolink) {
    initialChanger(biolink.checked, "biolinks");
    biolink.addEventListener("change", (e) => {
        typeChanger(biolink.checked, "biolinks");
    });
}
if (shortlink) {
    initialChanger(shortlink.checked, "shortlinks");
    shortlink.addEventListener("change", (e) => {
        typeChanger(shortlink.checked, "shortlinks");
    });
}
if (project) {
    initialChanger(project.checked, "projects");
    project.addEventListener("change", (e) => {
        typeChanger(project.checked, "projects");
    });
}
if (qrcode) {
    initialChanger(qrcode.checked, "qrcodes");
    qrcode.addEventListener("change", (e) => {
        typeChanger(qrcode.checked, "qrcodes");
    });
}

const prices = document.querySelectorAll(".price_title");
if (prices) {
    prices.forEach((element) => {
        const span = element.querySelector("span");
        const select = element.querySelector("select");
        select.addEventListener("change", () => {
            span.innerText = select.value;
        });
    });
}

function frequencyHandler(frequency) {
    const data = JSON.parse(frequency);
    const active = "active-frequency";

    if (data.id === "yearly") {
        document.getElementById("monthly").classList.remove(active);
        document.getElementById("yearly").classList.add(active);
    } else if (data.id === "lifetime") {
        document.getElementById("monthly").classList.remove(active);
        document.getElementById("yearly").classList.remove(active);
    } else {
        document.getElementById("monthly").classList.add(active);
        document.getElementById("yearly").classList.remove(active);
    }

    document.getElementById("frequency").innerText = data.name.split(" ")[0];
    document.getElementById("summeryPrice").innerText = `${data.price} USD`;
    document.getElementById("totalPrice").innerText = `${data.price} USD`;
}

// Selecting the payment method
const methods = document.querySelectorAll(".payment_method");
if (methods) {
    methods.forEach((element, index) => {
        // checkoutForm
        if (index === 0) {
            element.classList.add("active-method");
            const info = JSON.parse(element.dataset.info);
            document.getElementById("paymentMethod").innerText = info.name;

            const checkoutForm = document.getElementById("checkoutForm");
            checkoutForm.setAttribute("method", info.method);
            checkoutForm.setAttribute("action", info.route);
        }

        element.addEventListener("click", () => {
            methods.forEach((item) => item.classList.remove("active-method"));
            const info = JSON.parse(element.dataset.info);
            document.getElementById("paymentMethod").innerText = info.name;
            element.classList.add("active-method");

            const checkoutForm = document.getElementById("checkoutForm");
            checkoutForm.setAttribute("method", info.method);
            checkoutForm.setAttribute("action", info.route);
        });
    });
}
