const showTargetExpandHeroElement = (element, show) => {
    if (show) {
        element.setAttribute('control-expanded', 'hide')
        element.classList.replace('hero-input-expander-show', 'hero-input-expander')
    } else {
        element.setAttribute('control-expanded', 'show')
        element.classList.replace('hero-input-expander', 'hero-input-expander-show')
    }
}

const handleGameHeroInputPreviewSelected = (previewElement, selectedElement) => {
    const previewElImage = previewElement.querySelector('img')
    const selectedElImage = selectedElement.querySelector('img');

    previewElImage.setAttribute('src', selectedElImage?.getAttribute('src'))
    previewElImage.setAttribute('alt', selectedElImage?.getAttribute('alt'))

    const previewName = previewElement.querySelector('[aria-label="hero-name"')
    const selectedName = selectedElement.querySelector('[aria-label="hero-name"]')
    if (previewName && selectedName) previewName.textContent = selectedName.textContent;

    const previewRole = previewElement.querySelector('[aria-label="hero-role"]')
    const selectedRole = selectedElement.querySelector('[aria-label="hero-role"]')
    if (previewRole && selectedRole) previewRole.textContent = selectedRole.textContent;
}

const handleGameHeroInputValue = (selectedElement) => {
    const heroId = selectedElement.getAttribute('data-hero-id');
    const heroName = selectedElement.querySelector('[aria-label="hero-name"]')?.textContent;
    const heroRole = selectedElement.querySelector('[aria-label="hero-role"]')?.textContent;
    const heroImage = selectedElement.querySelector('[aria-label="hero-image"]')?.getAttribute("src");

    document.querySelector('input[aria-label="input-hero-id"]').value = heroId
    document.querySelector('input[aria-label="input-hero-name"]').value = heroName
    document.querySelector('input[aria-label="input-hero-role"]').value = heroRole !== "" ? heroRole : "null"
    document.querySelector('input[aria-label="input-hero-image"]').value = heroImage
}

const handleExpandAndChangeHeroInput = () => {
    const heroInputs = document.querySelectorAll('[control="hero-input"]');
    heroInputs.forEach(heroInput => {
        const targetExpandElement = document.querySelector(`[control="${heroInput.getAttribute('control-expand-element')}"]`);
        let isExpand = targetExpandElement.getAttribute('control-expanded') == 'show';

        // Show on init
        if (isExpand) showTargetExpandHeroElement(targetExpandElement, false);


        let heroListSelected = null;
        const heroLists = targetExpandElement.querySelectorAll('[data-hero-id]')
        heroLists.forEach(heroList => {
            if (heroList.classList.contains('selected')) heroListSelected = heroList;

            heroList.addEventListener('click', () => {
                const heroId = Number(heroList.getAttribute('data-hero-id'));

                handleGameHeroInputValue(heroList)
                handleGameHeroInputPreviewSelected(heroInput, heroList);
                heroList?.classList?.add('selected');
                heroListSelected?.classList?.remove('selected');
                heroListSelected = heroList;
                heroInput.click();
            })

        })


        heroInput.addEventListener('click', (e) => {
            isExpand = targetExpandElement.getAttribute('control-expanded') == 'show';
            showTargetExpandHeroElement(targetExpandElement, isExpand);
        })
    });
}

handleExpandAndChangeHeroInput()