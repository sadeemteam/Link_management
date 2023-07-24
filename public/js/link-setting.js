// Helper function
function idChangeValue1(id, callBack) {
    document.getElementById(id)?.addEventListener("change", callBack);
}

// Link theme selection
const themes = document.querySelectorAll(".themeCard");
if (themes) {
    themes.forEach((element) => {
        element.addEventListener("click", async () => {
            const link = JSON.parse(element.dataset.link);
            const theme = JSON.parse(element.dataset.theme);

            document.getElementById("bioLink").style = `
                height: 80vh;
                width: 380px !important;
                overflow: auto;
                border-radius: 30px;
                border: 10px solid black;
                color: ${theme.text_color};
                font-family: ${theme.font_family} !important;
                ${
                    theme.bg_image
                        ? `background-image: url('/${theme.bg_image}'); ${theme.background}`
                        : theme.background
                }
            `;

            document.querySelectorAll(".mobileViewLinkItem").forEach((item) => {
                if (theme.bg_image) {
                    item.style = `background-image: url('/${theme.bg_image}'); ${theme.button_style}`;
                } else {
                    item.style = `${theme.button_style}`;
                }
            });

            document.querySelectorAll(".textContent").forEach((item) => {
                item.style.color = theme.text_color;
            });

            document.getElementById("customTheme")?.classList.add("d-none");
            document.getElementById("customTheme")?.classList.remove("d-block");

            document.querySelectorAll(".themeCard").forEach((item) => {
                if (item.dataset.theme) {
                    const currentTheme = JSON.parse(item.dataset.theme);
                    if (theme.id === currentTheme.id) {
                        item.classList.add("active");
                    } else {
                        item.classList.remove("active");
                    }
                }
            });

            await axios.put(`/dashboard/theme-update/${theme.id}/${link.id}`);
        });
    });
}
// --------------------------------------------------------------

// --------------------------------------------------------------
// Update link profile photo
idChangeValue1("linkProfileInput", (e) => {
    const reader = new FileReader();
    reader.readAsDataURL(e.target.files[0]);
    reader.addEventListener("load", () => {
        document.getElementById("linkProfileImg").src = reader.result;
    });
});

// --------------------------------------------------------------
// Creating custom theme
async function createCustomTheme(link) {
    if (link.custom_theme_id) {
        await axios.put(`/dashboard/active-custom-theme/${link.id}`);
        window.location.reload();
    } else {
        const theme = {
            background: "background: #1d2939;",
            background_type: "color",
            text_color: "#ffffff",
            btn_type: "rounded",
            btn_transparent: false,
            btn_radius: "30px",
            btn_bg_color: "#ffffff",
            btn_text_color: "#1d2939",
            font_family: "Inter, sans-serif",
        };

        await axios.post(`/dashboard/create-custom-theme/${link.id}`, theme);
        window.location.reload();
    }
}
// --------------------------------------------------------------

let commonStyle = `
    height: 80vh; 
    width: 380px !important; 
    overflow: auto;
    border-radius: 30px; 
    border: 10px solid black;
`;

async function customThemeUpdate(themeId, values) {
    await axios.put(`/dashboard/update-custom-theme/${themeId}`, values);
}

// --------------------------------------------------------------
// Uploading them custom them background
idChangeValue1("customImage", async (e) => {
    const theme = JSON.parse(e.target.dataset.theme);

    const file = e.target.files[0];
    let fileData = new FormData();
    fileData.append("image", file);
    const result = await axios.post("/dashboard/single-upload", fileData, {
        headers: { "content-type": "multipart/form-data" },
    });
    const imgId = result.data.split("/").pop();
    const imgUrl = `${window.location.origin}/upload/${imgId}`;

    const background = `
        background-image: url("${imgUrl}");
        background-size: cover;
        background-position: center
    `;
    window.idSelector("customImageBox").style = background;
    window.idSelector("bioLink").style = `${commonStyle} ${background}`;

    customThemeUpdate(theme.id, {
        background,
        background_type: "image",
    });
});
// --------------------------------------------------------------

// --------------------------------------------------------------
// Updating the background color of custom theme
idChangeValue1("customColorInput", async (e) => {
    const color = e.target.value;
    const themeId = parseInt(e.target.dataset.themeid);
    const background = `background-color: ${color} !important;`;
    window.idSelector("bioLink").style = `${commonStyle} ${background}`;

    customThemeUpdate(themeId, {
        background,
        background_type: "color",
    });
});

// --------------------------------------------------------------
// Changing the current button type of custom theme
const buttons = document.querySelectorAll(".linkButton");
if (buttons) {
    buttons.forEach((element) => {
        element.addEventListener("click", () => {
            const theme = JSON.parse(element.dataset.theme);
            const button = JSON.parse(element.dataset.type);
            const { type, radius, color } = button;
            buttons.forEach((item) => item.classList.remove("activeItem"));
            element.classList.add("activeItem");

            let transparent = false;
            if (
                type === "rounded-trans" ||
                type === "radius-trans" ||
                type === "rectangle-trans"
            ) {
                transparent = true;
            }

            document.querySelectorAll(".mobileViewLinkItem").forEach((item) => {
                item.style = `
                    border-radius: ${radius};
                    background: ${transparent ? "rgba(0, 0, 0, 0)" : color};
                    outline: 1px solid ${transparent ? "#000000" : color};
                `;
            });

            customThemeUpdate(theme.id, {
                button: type,
                btn_radius: radius,
                btn_bg_color: color,
                btn_transparent: transparent,
            });
        });
    });
}
function setButtonType(buttonType, themeId) {
    const { type, radius, color } = buttonType;

    let transparent = false;
    if (
        type === "rounded-trans" ||
        type === "radius-trans" ||
        type === "rectangle-trans"
    ) {
        transparent = true;
    }

    document.querySelectorAll(".mobileViewLinkItem").forEach((item) => {
        item.style = `
            border-radius: ${radius};
            background: ${transparent ? "rgba(0, 0, 0, 0)" : color};
            outline: 1px solid ${transparent ? "#000000" : color};
        `;
    });

    customThemeUpdate(themeId, {
        button: type,
        btn_radius: radius,
        btn_bg_color: color,
        btn_transparent: transparent,
    });
}
// --------------------------------------------------------------

// --------------------------------------------------------------
// Set button background and text color
idChangeValue1("themeTextColor", async (e) => {
    const color = e.target.value;
    const themeId = parseInt(e.target.dataset.themeid);

    window.idSelector("bioLink").style.color = color;
    window
        .idSelector("bioLink")
        .querySelectorAll(".textContent")
        .forEach((item) => {
            item.style.color = color;
        });

    customThemeUpdate(themeId, { text_color: color });
});
// --------------------------------------------------------------

// --------------------------------------------------------------
// Set button background and text color
idChangeValue1("btnBgColor", async (e) => {
    const color = e.target.value;
    const themeId = parseInt(e.target.dataset.themeid);

    document.querySelectorAll(".mobileViewLinkItem").forEach((item) => {
        item.style.background = color;
    });

    customThemeUpdate(themeId, { btn_bg_color: color });
});
// --------------------------------------------------------------

// --------------------------------------------------------------
// Set button background and text color
idChangeValue1("btnTextColor", async (e) => {
    const color = e.target.value;
    const themeId = parseInt(e.target.dataset.themeid);

    document.querySelectorAll(".mobileViewLinkItem").forEach((item) => {
        item.querySelectorAll(".customThemeColor").forEach((childItem) => {
            childItem.style = `color: ${color} !important`;
        });
    });

    customThemeUpdate(themeId, { btn_text_color: color });
});
// --------------------------------------------------------------

// --------------------------------------------------------------
// Set font family of custom theme
const fonts = document.querySelectorAll(".fontButton");
if (fonts) {
    fonts.forEach((element) => {
        element.addEventListener("click", (e) => {
            const font = JSON.parse(element.dataset.font);
            const theme = JSON.parse(element.dataset.theme);

            fonts.forEach((item) => item.classList.remove("activeItem"));
            element.classList.add("activeItem");
            window.idSelector("bioLink").style.fontFamily = font;
            customThemeUpdate(theme.id, { font_family: font });
        });
    });
}
// --------------------------------------------------------------

// --------------------------------------------------------------
// Set font family of custom theme
idChangeValue1("bioLinkLogoInput", async (e) => {
    const themeId = parseInt(e.target.dataset.themeid);
    const prevLogo = document.getElementById("prevLogo").value;
    const file = e.target.files[0];

    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.addEventListener("load", () => {
        document.getElementById("bioLinkLogo").src = reader.result;
        document.getElementById("bioLinkLogoMobile").src = reader.result;
    });

    let fileData = new FormData();
    fileData.append("image", file);

    const result = await axios.post(
        `/file-upload/${prevLogo.split("/").pop()}`,
        fileData,
        { headers: { "content-type": "multipart/form-data" } }
    );

    await axios.put(`/dashboard/update-link-logo/${themeId}`, {
        branding: result.data,
    });
});
// --------------------------------------------------------------
