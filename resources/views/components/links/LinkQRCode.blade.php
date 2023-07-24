<div id="canvas2" hidden></div>
<style>
    .toastMessage { color: #664d03 }
    .toastMessage .toast-close { color: #664d03 }
</style>

<script>
    // Save QR Code image
    let linkQR = new QRCodeStyling({
        width: 400,
        height: 400,
        type: "svg",
        margin: 6,
        dotsOptions: {
            color: "#14c8f5",
            type: "square",
        },
        cornersSquareOptions: {
            color: "#2a86fe",
            type: "square",
        },
        backgroundOptions: {
            color: "#fff",
        },
        imageOptions: {
            margin: 10,
            imageSize: 0.4,
            hideBackgroundDots: true,
            crossOrigin: "anonymous",
        },
    });
    linkQR.append(document.getElementById("canvas2"));

    const linkQRCode = document.querySelectorAll(".linkQRCode");
    if (linkQRCode) {
        linkQRCode.forEach((element) => {
            element.addEventListener("click", async () => {
                const link = JSON.parse(element.dataset.link);

                const baseUrl = '{{url('')}}';
                linkQR.update({ data: `${baseUrl}/${link.url_name}`});

                setTimeout(async () => {
                    const svgString = new XMLSerializer().serializeToString(
                        document.getElementById("canvas2").querySelector("svg")
                    );

                    // Remove any characters outside the Latin1 range
                    const decoded = unescape(encodeURIComponent(svgString));
                    // Now we can use btoa to convert the svg to base64
                    const base64 = btoa(decoded);
                    const imgSource = `data:image/svg+xml;base64,${base64}`;
                    
                    const qrInfo = {
                        content: `${baseUrl}/${link.url_name}`,
                        img_data: imgSource,
                    };

                    const result = await axios.post(`/dashboard/add-link-qrcode/${link.id}`, qrInfo);
                    if (result.data.error) {
                        Toastify({
                            text: result.data.error,
                            className: "toastMessage",
                            duration: 6000,
                            newWindow: true,
                            close: true,
                            gravity: "top", // `top` or `bottom`
                            position: "center", // `left`, `center` or `right`
                            stopOnFocus: true, // Prevents dismissing of toast on hover
                            backgroundColor: '#fff3cd',
                            onClick: function(){} // Callback after click
                        }).showToast();
                    } else {
                        window.location.reload();
                    }
                }, 100);
            });
        });
    }
</script>