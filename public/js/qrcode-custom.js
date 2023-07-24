// Helper function
function idChangeValue2(id, callBack) {
    document.getElementById(id)?.addEventListener("change", callBack);
}

// another qr code package
let qrCode = new QRCodeStyling({
    width: 400,
    height: 400,
    type: "svg",
    margin: 6,
    data: "UI-Lib",
    dotsOptions: {
        color: "#000",
        type: "rounded",
    },
    cornersSquareOptions: {
        color: "#000",
        type: "extra-rounded",
    },
    backgroundOptions: {
        color: "#fff",
    },
    imageOptions: {
        margin: 0,
        imageSize: 0.4,
        hideBackgroundDots: true,
        crossOrigin: "anonymous",
    },
});

qrCode.append(document.getElementById("canvas"));
function downloadQR() {
    document.querySelectorAll(".downloadType").forEach((element) => {
        qrCode.download({ name: "qr-code", extension: element.value });
    });
}

// ----------------------------------------------------
function setQRCodeText() {
    idChangeValue2("qrContent", (e) => {
        if (e.target.value === "") {
            qrCode.update({ data: "UI-Lib" });
        } else {
            qrCode.update({ data: e.target.value });
        }
    });
}

idChangeValue2("width", (e) => {
    qrCode.update({ width: e.target.value });
    document.getElementById(
        "downloadBox"
    ).style.maxWidth = `${e.target.value}px`;
});

idChangeValue2("height", (e) => {
    qrCode.update({ height: e.target.value });
});

idChangeValue2("margin", (e) => {
    qrCode.update({ margin: e.target.value });
});
// ----------------------------------------------------

// ----------------------------------------------------
idChangeValue2("dotStyle", (e) => {
    qrCode.update({ dotsOptions: { type: e.target.value } });
});

idChangeValue2("dotColor", (e) => {
    qrCode.update({ dotsOptions: { color: e.target.value } });
});

idChangeValue2("dotBackground", (e) => {
    qrCode.update({ backgroundOptions: { color: e.target.value } });
});
// ----------------------------------------------------

// ----------------------------------------------------
idChangeValue2("cornerType", (e) => {
    qrCode.update({ cornersSquareOptions: { type: e.target.value } });
});

idChangeValue2("cornerColor", (e) => {
    qrCode.update({ cornersSquareOptions: { color: e.target.value } });
});
// ----------------------------------------------------

// ----------------------------------------------------
idChangeValue2("imageFile", (e) => {
    const reader = new FileReader();
    reader.readAsDataURL(e.target.files[0]);
    reader.addEventListener("load", () => {
        qrCode.update({ image: reader.result });
    });
});

idChangeValue2("imageSize", (e) => {
    qrCode.update({ imageOptions: { imageSize: e.target.value } });
});

idChangeValue2("imageMargin", (e) => {
    qrCode.update({ imageOptions: { margin: e.target.value } });
});
// ----------------------------------------------------

// Download QRCode as a svg
function downloadSvg(uri, name) {
    var link = document.createElement("a");
    link.download = name;
    link.href = uri;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    delete link;
}

// Download QRCode as a ang or jpg QRCodeImg;
function downloadImg(imgUrl, type) {
    let img = new Image();
    img.src = imgUrl;

    var canvas = document.createElement("canvas");
    canvas.width = 800;
    canvas.height = 800;
    canvas.getContext("2d").drawImage(img, 0, 0, 800, 800);

    var imgURL = canvas.toDataURL(`image/${type}`);

    var dlLink = document.createElement("a");
    dlLink.download = "image";
    dlLink.href = imgURL;
    dlLink.dataset.downloadurl = [
        `image/${type}`,
        dlLink.download,
        dlLink.href,
    ].join(":");

    document.body.appendChild(dlLink);
    dlLink.click();
    document.body.removeChild(dlLink);
}

function qrcodeDownload(imgUrl, type) {
    // const value = window.idSelector("imageType").value;

    if (type === "svg") {
        downloadSvg(imgUrl, "qrcode.svg");
    } else {
        downloadImg(imgUrl, type);
    }
}

// Select the input type
const qrType = document.getElementById("QRType");
if (qrType) {
    qrType.addEventListener("change", (e) => {
        const inputType = e.target.value;
        const qrContent = document.getElementById("qrContent");
        if (qrContent) qrContent.remove();
        let node = document.getElementById("qrContentBox");
    
        if (inputType === "textarea") {
            let textarea = document.createElement("textarea");
            textarea.classList.add("form-control");
            textarea.setAttribute("type", "text");
            textarea.setAttribute("rows", "4");
            textarea.setAttribute("id", "qrContent");
            textarea.setAttribute("placeholder", "Type text content");
            textarea.required = true;
            node.appendChild(textarea);
            setQRCodeText();
        } else {
            let input = document.createElement("input");
            input.classList.add("form-control");
            input.setAttribute("type", inputType);
            input.setAttribute("id", "qrContent");
            input.setAttribute(
                "placeholder",
                `Type ${inputType === "text" ? "url" : inputType} content`
            );
            input.required = true;
            node.appendChild(input);
            setQRCodeText();
        }
    });
}

// Save QR Code image
const qrCreateForm = document.forms["qrCodeCreateForm"];
if (qrCreateForm) {
    qrCreateForm.onsubmit = async function (e) {
        e.preventDefault();
        const qrName = window.idSelector("qrName").value;
        const projectId = window.idSelector("projectId").value;
        const qrType = window.idSelector("QRType").value;
        const qrContent = window.idSelector("qrContent").value;
    
        const svgString = new XMLSerializer().serializeToString(
            document.getElementById("canvas").querySelector("svg")
        );
    
        // Remove any characters outside the Latin1 range
        const decoded = unescape(encodeURIComponent(svgString));
        // Now we can use btoa to convert the svg to base64
        const base64 = btoa(decoded);
        const imgSource = `data:image/svg+xml;base64,${base64}`;
    
        const qrInfo = {
            qr_name: qrName,
            qr_type: qrType,
            project_id: projectId,
            content: qrContent,
            img_data: imgSource,
        };
        await axios.post(`/dashboard/save-qrcode`, qrInfo);
        window.isNavigate("/dashboard/qrcodes");
    };
}

async function deleteItem(url) {
    await axios.delete(url);
    window.location.reload();
}

async function tabActiveController(session, type) {
    await axios.post(`/dashboard/link/settings-btn`, { type });
}
