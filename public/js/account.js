document.getElementById("profile")?.addEventListener("change", function (e) {
    const reader = new FileReader();
    reader.readAsDataURL(e.target.files[0]);
    reader.addEventListener("load", () => {
        document.getElementById("profileImg").src = reader.result;
    });
});

async function singleImageUpload(imgInputId) {
    const file = window.idSelector(imgInputId).files[0];
    if (file) {
        let fileData = new FormData();
        fileData.append("image", file);
        const result = await axios.post("/file-upload", fileData, {
            headers: { "content-type": "multipart/form-data" },
        });
        const baseUrl = "http://127.0.0.1:8000/storage/";
        const imgUrl = result.data.split("/").pop();
        return `${baseUrl}${imgUrl}`;
    } else {
        return null;
    }
}
