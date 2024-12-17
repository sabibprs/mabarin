
const showTargetExpandGameAccountElement = (element, show) => {
    if (show) {
        element.setAttribute('control-expanded', 'hide')
        element.classList.replace('account-input-expander-show', 'account-input-expander')
    } else {
        element.setAttribute('control-expanded', 'show')
        element.classList.replace('account-input-expander', 'account-input-expander-show')
    }
}

const handlePreviewGameAccountSelected = (previewElement, selectedElement) => {
    previewElement.querySelector('span[aria-label="account-identity"]').textContent = selectedElement.querySelector('span[aria-label="account-identity"]').textContent
    previewElement.querySelector('span[aria-label="account-identity-zone-id"]').textContent = selectedElement.querySelector('span[aria-label="account-identity-zone-id"]').textContent
}

const handleExpandAndChangeGameAccountInput = () => {
    const accountInputs = document.querySelectorAll('[control="account-input"]');
    accountInputs?.forEach(accountInput => {
        const targetInputElement = document.querySelector(`input[name="${accountInput.getAttribute('control-input')}"]`);
        const targetExpandElement = document.querySelector(`[control="${accountInput.getAttribute('control-expand-element')}"]`);
        let isExpand = targetExpandElement.getAttribute('control-expanded') == 'show';

        // Show on init
        if (isExpand) showTargetExpandGameAccountElement(targetExpandElement, false);

        let accountListSelected = null;
        const accountLists = targetExpandElement.querySelectorAll('[data-account-id]')
        accountLists.forEach(accountList => {
            if (accountList.classList.contains('selected')) accountListSelected = accountList;

            accountList.addEventListener('click', () => {
                const accountId = Number(accountList.getAttribute('data-account-id'));

                handlePreviewGameAccountSelected(accountInput, accountList);
                targetInputElement.value = accountId;
                accountList?.classList?.add('selected');
                accountListSelected?.classList?.remove('selected');
                accountListSelected = accountList;
                accountInput.click();
            })

        })

        accountInput.addEventListener('click', (e) => {
            isExpand = targetExpandElement.getAttribute('control-expanded') == 'show';
            showTargetExpandGameAccountElement(targetExpandElement, isExpand);
        })
    })
}

handleExpandAndChangeGameAccountInput();