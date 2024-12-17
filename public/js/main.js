let isWindowLoaded = false;

const screenGreatherThan = (screenSize) => {
    const sizeConfigured = {
        "sm": 640,
        "md": 768,
        "lg": 1024,
        "xl": 1280,
        "2xl": 1536
    };

    const size = Object?.keys(sizeConfigured)?.includes(screenSize) ? sizeConfigured[screenSize] : 0
    return (window.innerWidth > size);
}

window.onload = () => {
    isWindowLoaded = true
    // if (screenGreatherThan("md")) document.body.style.paddingRight = '8px';
}

const navMenu = document.querySelector('#nav-menu-wrapper');
// const navMenuTopInit = navMenu?.getBoundingClientRect()?.top < 80 ? 80 : navMenu?.getBoundingClientRect()?.top
const navMenuTopInit = 80

const navMenuAction = (oldScrollY, scrollY) => {
    const isScrollDown = (oldScrollY < scrollY);
    const isScrollTop = (oldScrollY > scrollY);

    if (screenGreatherThan('md')) {
        if (isScrollDown && scrollY > navMenuTopInit) {
            navMenu?.classList?.replace("nav-menu-wrapper", "nav-menu-wrapper-on-top")
            navMenu?.previousElementSibling?.classList?.replace("opacity-100", "opacity-0");
            navMenu?.querySelector('.profile-toggle')?.classList?.replace("opacity-0", "opacity-100");
            document?.querySelector('header .profile-toggle')?.classList?.replace("opacity-100", "opacity-0");
            document?.querySelector('header')?.classList?.add("header-on-top");
        } else if (isScrollTop && scrollY < navMenuTopInit) {
            navMenu?.classList?.replace("nav-menu-wrapper-on-top", "nav-menu-wrapper")
            navMenu?.previousElementSibling?.classList?.replace("opacity-0", "opacity-100");
            navMenu?.querySelector('.profile-toggle')?.classList?.replace("opacity-100", "opacity-0");
            document?.querySelector('header .profile-toggle')?.classList?.replace("opacity-0", "opacity-100");
            document?.querySelector('header')?.classList?.remove("header-on-top");

        }
    } else {
        if (navMenu?.classList?.contains("nav-menu-wrapper-on-top")) navMenu?.classList?.replace("nav-menu-wrapper-on-top", "nav-menu-wrapper")
    }
}

window.addEventListener('scroll', function () {
    const oldScrollY = this.oldScrollY
    const scrollY = this.scrollY

    navMenuAction(oldScrollY, scrollY);

    this.oldScrollY = scrollY
})

const profileToggles = document.querySelectorAll('.profile-toggle')
const profileMenu = document.querySelector('.profile-menu');

profileToggles?.forEach(profileToggle => {
    profileToggle.addEventListener('click', () => {
        if (screenGreatherThan("md")) {
            if (profileMenu?.classList?.contains('opacity-0')) {
                profileMenu?.classList?.replace('-z-50', 'z-50')
                profileMenu?.classList?.replace('-translate-y-full', 'translate-y-0')
                profileMenu?.classList?.replace('opacity-0', 'opacity-100')
            } else {
                profileMenu?.classList?.replace('translate-y-0', '-translate-y-full')
                profileMenu?.classList?.replace('opacity-100', 'opacity-0')
                profileMenu?.classList?.replace('z-50', '-z-50')
            }
        } else {
            window.location.href = "/profile"
        }
    });
})

const inputPasswordShowBtns = document.querySelectorAll('[aria-label="password-show"]')
inputPasswordShowBtns.forEach(passwordShowBtn => {
    passwordShowBtn.addEventListener('click', () => {
        const input = passwordShowBtn.previousElementSibling
        const eye = passwordShowBtn.querySelector('.fa-eye')
        const eyeSlash = passwordShowBtn.querySelector('.fa-eye-slash')

        if (input.type == 'password') {
            eyeSlash?.classList?.replace('hidden', 'inline')
            eye?.classList?.replace('inline', 'hidden')
            input.setAttribute('type', 'text')
        } else {
            eye?.classList?.replace('hidden', 'inline')
            eyeSlash?.classList?.replace('inline', 'hidden')
            input.setAttribute('type', 'password')

        }
    })
});

window.addEventListener('resize', () => navMenuAction(0, window.scrollY))

if (window.scrollY > 0 && navMenu?.classList?.contains('nav-menu-wrapper')) navMenuAction(window?.oldScrollY ?? 0, window.scrollY)


let lastWidth = document.documentElement.clientWidth;
function handleScrollbarOnShow(entries) {
    const currentWidth = entries[0].contentRect.width;

    if (currentWidth !== lastWidth && isWindowLoaded && screenGreatherThan("md")) {
        if (currentWidth > lastWidth) {
            document.body.style.paddingRight = '8px';
        } else {
            document.body.style.paddingRight = '0';
        }

        lastWidth = currentWidth;
    }
}

// Membuat instance ResizeObserver
const resizeObserver = new ResizeObserver(handleScrollbarOnShow);
resizeObserver.observe(document.documentElement);
handleScrollbarOnShow([{ contentRect: document.documentElement.getBoundingClientRect() }]);


// Handling file input
const upload = async (file, uri, fieldName) => {
    const formData = new FormData();
    formData.append(fieldName, file);

    try {
        const response = await fetch(uri, {
            method: 'POST',
            body: formData
        })
        return response.json();
    } catch (error) {
        return error;
    }
};



// Hanling button file input
const buttonsFileInput = document.querySelectorAll('button[role="upload-image-input"]')
buttonsFileInput?.forEach(buttonFileInput => {
    const wrapper = document.querySelector('[target-wrapper-role="upload-image-input"]');
    const targetPreview = document.querySelector(`img#${buttonFileInput.getAttribute('target-preview')}`)
    const targetInput = document.querySelector(`#${buttonFileInput.getAttribute("target-input")}`);
    const targetFileInput = document.querySelector(`[target-name="${buttonFileInput.getAttribute("target-input")}"]`);

    const handlingOnImageNotEmpty = (previewImgUri, isInitialRender = false) => {
        if (!isInitialRender) {
            targetPreview.src = previewImgUri;
            wrapper?.classList?.replace("bg-black/50", "group-hover/upload-image:bg-black/50")
            buttonFileInput?.classList?.replace('opacity-100', 'opacity-0');
        }

        targetInput.value = previewImgUri;
    }

    if (targetInput.value?.length) {
        let isInitialRender = false;
        if (Boolean(targetFileInput.getAttribute('initial-render'))) {
            isInitialRender = true;
            targetFileInput.removeAttribute('initial-render')
        }
        handlingOnImageNotEmpty(targetInput.value, isInitialRender)
    }

    if (targetFileInput) {
        buttonFileInput.addEventListener('click', () => {
            const targetUriUpload = targetFileInput.getAttribute("uri-upload");
            const targetFieldName = targetFileInput.getAttribute('target-name');
            targetFileInput.addEventListener('change', async () => {
                try {
                    const result = await upload(targetFileInput.files[0], targetUriUpload, targetFieldName);

                    if (result.preview && targetPreview) handlingOnImageNotEmpty(result.preview)
                    console.log(result);
                } catch (error) {
                    targetFileInput.value = "";
                    targetInput.value = "";
                    console.error(error);
                }
            }, true);

            targetFileInput.click();
        })
    }
});


const handlingInputMathParent = (inputElement, parentNameId, isSlug = false) => {
    const parentElement = document.querySelector(`#${parentNameId}`)
    console.log(parentElement);
    parentElement.addEventListener("keyup", (e) => {
        const parentValue = e.target.value;
        if (!isSlug) {
            inputElement.value = parentValue
        } else {

            const formatted = parentValue.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
            inputElement.value = formatted
        }

    })
}

const inputsMathParent = document.querySelectorAll('input[match-parent]')
inputsMathParent?.forEach(input => handlingInputMathParent(input, input.getAttribute('match-parent'), false))

const inputsMathParentSlug = document.querySelectorAll('input[match-parent-slug]')
inputsMathParentSlug?.forEach(input => handlingInputMathParent(input, input.getAttribute('match-parent-slug'), true))

// Handling Toggle
const showToggle = (toggleWrapper, forceToggleShow) => {
    const isToggleShow = forceToggleShow ?? toggleWrapper.getAttribute("toggle-show") == 'true';
    let expandTarget = toggleWrapper.querySelector(`[toggle-expand="${toggleWrapper.getAttribute("toggle-expand-target")}"]`)
    if (!expandTarget) expandTarget = document.querySelector(`[toggle-expand="${toggleWrapper.getAttribute("toggle-expand-target")}"]`)

    if (isToggleShow) {
        toggleWrapper.setAttribute('toggle-show', 'false')
        expandTarget?.classList?.replace("flex", "hidden")
    } else {
        toggleWrapper.setAttribute('toggle-show', 'true')
        expandTarget?.classList?.replace("hidden", "flex")
    }
}

const toggleWrappers = document.querySelectorAll('[aria-controls="toggle"]')
toggleWrappers.forEach(toggleWrapper => {
    const isOnClickOnly = toggleWrapper.querySelectorAll('[toggle-on-click-only="true"]')

    if (isOnClickOnly) {
        toggleWrapper.addEventListener("click", () => showToggle(toggleWrapper));
    } else {
        toggleWrapper.addEventListener("click", () => showToggle(toggleWrapper));
        toggleWrapper.addEventListener("mouseover", () => showToggle(toggleWrapper, false));
        toggleWrapper.addEventListener("mouseout", () => showToggle(toggleWrapper), true);
    }
})