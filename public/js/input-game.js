const showTargetGameInputExpandElement = (element, show) => {
    if (show) {
        element.setAttribute('control-expanded', 'hide')
        element.classList.replace('game-input-expander-show', 'game-input-expander')
    } else {
        element.setAttribute('control-expanded', 'show')
        element.classList.replace('game-input-expander', 'game-input-expander-show')
    }
}

const handleGameInputPreviewSelected = (previewElement, selectedElement) => {
    const previewElImage = previewElement.querySelector('img')
    const selectedElImage = selectedElement.querySelector('img');
    previewElImage.setAttribute('src', selectedElImage?.getAttribute('src'))
    previewElImage.setAttribute('alt', selectedElImage?.getAttribute('alt'))

    previewElement.querySelector('h2').textContent = selectedElement.querySelector('h2').textContent
    previewElement.querySelector('p').textContent = selectedElement.querySelector('p').textContent
}

const handleExpandAndChangeGameInput = () => {
    const gameInputs = document.querySelectorAll('[control="game-input"]');
    gameInputs?.forEach(gameInput => {
        const targetInputElement = document.querySelector(`input[name="${gameInput.getAttribute('control-input')}"]`);
        const targetExpandElement = document.querySelector(`[control="${gameInput.getAttribute('control-expand-element')}"]`);
        let isExpand = targetExpandElement.getAttribute('control-expanded') == 'show';

        // Show on init
        if (isExpand) showTargetGameInputExpandElement(targetExpandElement, false);

        let gameListSelected = null;
        const gameLists = targetExpandElement.querySelectorAll('[data-game-id]')
        gameLists.forEach(gameList => {
            if (gameList.classList.contains('selected')) gameListSelected = gameList;

            gameList.addEventListener('click', () => {
                const gameId = Number(gameList.getAttribute('data-game-id'));

                handleGameInputPreviewSelected(gameInput, gameList);
                targetInputElement.value = gameId;
                gameList?.classList?.add('selected');
                gameListSelected?.classList?.remove('selected');
                gameListSelected = gameList;
                gameInput.click();
            })

        })

        gameInput.addEventListener('click', (e) => {
            isExpand = targetExpandElement.getAttribute('control-expanded') == 'show';
            showTargetGameInputExpandElement(targetExpandElement, isExpand);
        })
    })
}

handleExpandAndChangeGameInput();