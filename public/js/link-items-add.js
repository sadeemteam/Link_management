// ----------------------------------------------------
// link items script
function selectedLinkItem(itemType, itemLastPosition) {
    // link items selecting
    const elements = [
        "linkItem",
        "headingItem",
        "paragraphItem",
        "imageItem",
        "soundCloudItem",
        "youTubeItem",
        "spotifyItem",
        "vimeoItem",
        "tiktokItem",
    ];
    function linkItems(item) {
        const str = item.split("Item")[0];
        const itemsTitle = str.charAt(0).toUpperCase() + str.slice(1);
        document.getElementById("linkItemsTitle").innerText = itemsTitle;

        elements.forEach((element) => {
            window.idSelector(element).style.display =
                item == element ? "block" : "none";
        });
    }

    // Append link items in the database
    function appendElement(item) {
        let bioLInk = window.idSelector("bioLinkItems");
        const linkId = parseInt(bioLInk.dataset.id);

        const data = {
            link_id: linkId,
            item_position: itemLastPosition ? itemLastPosition + 1 : 1,
            item_type: item.type,
            item_sub_type: item.sub_type,
            item_title: item.title,
            item_link: item.link,
            item_icon: item.icon,
            content: item.content,
        };

        axios
            .post(`/dashboard/biolink/add-item`, data)
            .then((res) => {
                if (res.data.error) {
                    window.showMessage("showError", res.data.error, 2000);
                } else {
                    window.location.reload();
                }
            })
            .catch((error) => {
                const invalidLink = error.response.data.errors.item_link[0];
                window.showMessage("showError", invalidLink, 2000);
            });
    }

    // embed link submit handler
    async function embedLInkHandler(icon, title, link) {
        await appendElement({
            type: "Embed Link",
            sub_type: title,
            title: title,
            link: link,
            icon: icon,
            content: null,
        });
    }

    // uploading single image for link item
    async function singleImageUpload(imgInputId) {
        const file = window.idSelector(imgInputId).files[0];
        let fileData = new FormData();
        fileData.append("image", file);
        const result = await axios.post("/file-upload/0", fileData, {
            headers: { "content-type": "multipart/form-data" },
        });
        return result.data;
    }

    const form = document.forms["linkItemForm"];
    switch (itemType) {
        case "linkItem":
            linkItems(itemType);
            document.forms[itemType].onsubmit = function (e) {
                e.preventDefault();
                const icon = "fa-solid fa-link-simple";
                const text = window.idSelector("linkText").value;
                const linkUrl = window.idSelector("linkUrl").value;

                appendElement({
                    type: "Link",
                    sub_type: "Link",
                    title: text,
                    link: linkUrl,
                    icon: icon,
                    content: null,
                });
            };
            break;

        case "headingItem":
            linkItems(itemType);
            document.forms[itemType].onsubmit = function (e) {
                e.preventDefault();
                const icon = "fa-solid fa-heading";
                const type = window.idSelector("headingType").value;
                const text = window.idSelector("headingText").value;

                appendElement({
                    type: "Text Content",
                    sub_type: type,
                    title: text,
                    link: null,
                    icon: icon,
                    content: null,
                });
            };
            break;

        case "paragraphItem":
            linkItems(itemType);
            document.forms[itemType].onsubmit = function (e) {
                e.preventDefault();
                const icon = "fa-solid fa-paragraph";
                const text = window.idSelector("paragraphText").value;
                const title = window.idSelector("paragraphTitle").value;

                appendElement({
                    type: "Text Content",
                    sub_type: "paragraph",
                    title: title,
                    link: null,
                    icon: icon,
                    content: text,
                });
            };
            break;

        case "imageItem":
            linkItems(itemType);
            document.forms[itemType].onsubmit = async function (e) {
                e.preventDefault();
                const icon = "fa-solid fa-image";
                const imgUrl = await singleImageUpload("imageFile");
                const alt = window.idSelector("imageAlt").value;
                const targetUrl = window.idSelector("imageUrl").value;

                appendElement({
                    type: "Image",
                    sub_type: "Image",
                    title: alt,
                    link: targetUrl,
                    icon: icon,
                    content: imgUrl,
                });
            };
            break;

        case "soundCloudItem":
            linkItems(itemType);
            document.forms[itemType].onsubmit = async function (e) {
                e.preventDefault();
                const icon = "fa-brands fa-soundcloud";
                const url = window.idSelector("soundCloudUrl").value;
                const embedUrl = `https://w.soundcloud.com/player/?url=${url}&amp;color=%23ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;show_teaser=true&amp;visual=true`;

                embedLInkHandler(icon, "SoundCloud", embedUrl);
            };
            break;

        case "youTubeItem":
            linkItems(itemType);
            document.forms[itemType].onsubmit = async function (e) {
                e.preventDefault();
                const icon = "fa-brands fa-youtube";
                const url = idSelector(`youTubeUrl`).value;
                const lastUrl = url.split("/").pop();
                const videoId = lastUrl.split("=").pop();
                const embedUrl = `https://www.youtube.com/embed/${videoId}`;

                embedLInkHandler(icon, "YouTube", embedUrl);
            };
            break;

        case "spotifyItem":
            linkItems(itemType);
            document.forms[itemType].onsubmit = async function (e) {
                e.preventDefault();
                const icon = "fa-brands fa-spotify";
                const url = window.idSelector("spotifyUrl").value;
                let urlArray = url.split("/");
                const videoId = urlArray.pop();
                const videoType = urlArray.pop();
                const videoUrl = `${videoType}/${videoId.split("?")[0]}`;
                const embedUrl = `https://open.spotify.com/embed/${videoUrl}`;

                embedLInkHandler(icon, "Spotify", embedUrl);
            };
            break;

        case "vimeoItem":
            linkItems(itemType);
            document.forms[itemType].onsubmit = async function (e) {
                e.preventDefault();
                const icon = "fa-brands fa-vimeo";
                const url = window.idSelector("vimeoUrl").value;
                const lastUrl = url.split("/").pop();
                const embedUrl = `https://player.vimeo.com/video/${lastUrl}`;

                embedLInkHandler(icon, "Vimeo", embedUrl);
            };
            break;

        case "tiktokItem":
            linkItems(itemType);
            document.forms[itemType].onsubmit = async function (e) {
                e.preventDefault();
                const icon = "fa-brands fa-tiktok";
                const embedUrl = window.idSelector("tiktokUrl").value;

                embedLInkHandler(icon, "TikTok", embedUrl);
            };
            break;
        default:
            return;
    }
}
// ----------------------------------------------------

// ----------------------------------------------------
// add and update socials links on biolink page
async function submitSocials(linkId) {
    const form = document.forms["socialLinksForm"];
    form.onsubmit = async function (e) {
        e.preventDefault();
        const socialsLinks = [
            {
                name: "email",
                link: window.idSelector("socialEmailInput").value || null,
                icon: "fa-solid fa-circle-envelope",
            },
            {
                name: "telephone",
                link: window.idSelector("socialEelephoneInput").value || null,
                icon: "fa-solid fa-circle-phone",
            },
            {
                name: "telegram",
                link: window.idSelector("socialTelegramInput").value || null,
                icon: "fa-brands fa-telegram",
            },
            {
                name: "whatsapp",
                link: window.idSelector("socialWhatsappInput").value || null,
                icon: "fa-brands fa-whatsapp-square",
            },
            {
                name: "facebook",
                link: window.idSelector("socialFacebookInput").value || null,
                icon: "fa-brands fa-facebook",
            },
            {
                name: "messenger",
                link: window.idSelector("socialMessengerInput").value || null,
                icon: "fa-brands fa-facebook-messenger",
            },
            {
                name: "instagram",
                link: window.idSelector("socialInstagramInput").value || null,
                icon: "fa-brands fa-instagram-square",
            },
            {
                name: "twitter",
                link: window.idSelector("socialTwitterInput").value || null,
                icon: "fa-brands fa-twitter-square",
            },
            {
                name: "tiktok",
                link: window.idSelector("socialTikTokInput").value || null,
                icon: "fa-brands fa-tiktok",
            },
            {
                name: "youtube",
                link: window.idSelector("socialYouTubeInput").value || null,
                icon: "fa-brands fa-youtube",
            },
            {
                name: "soundcloud",
                link: window.idSelector("socialSoundCloudInput").value || null,
                icon: "fa-brands fa-soundcloud",
            },
            {
                name: "linkedin",
                link: window.idSelector("socialLinkedInInput").value || null,
                icon: "fa-brands fa-linkedin",
            },
            {
                name: "spotify",
                link: window.idSelector("socialSpotifyInput").value || null,
                icon: "fa-brands fa-spotify",
            },
            {
                name: "pinterest",
                link: window.idSelector("socialPinterestInput").value || null,
                icon: "fa-brands fa-pinterest",
            },
            {
                name: "snapchat",
                link: window.idSelector("socialSnapchatInput").value || null,
                icon: "fa-brands fa-snapchat-square",
            },
            {
                name: "discord",
                link: window.idSelector("socialDiscordInput").value || null,
                icon: "fa-brands fa-discord",
            },
        ];

        const items = [];
        socialsLinks.forEach((element) => {
            if (element.link) {
                items.push(element);
            }
        });

        await axios.put(`/dashboard/update-link-socials/${linkId}`, {
            socials: JSON.stringify(items),
        });
        window.location.reload();
    };
}
// ----------------------------------------------------
