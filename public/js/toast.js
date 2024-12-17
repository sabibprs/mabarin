/**
 * Toasts 
 * 
 */
const removeToast = (toastElement) => {
    const remove = (element) => {
        if (element) {
            toastElement?.classList?.add('translate-x-full')
            setTimeout(() => toastElement?.classList?.add('opacity-0'), 200);
            setTimeout(() => {
                toastElement.parentElement.remove()
                toastElement.remove()
            }, 700);
        }

    }

    toastElement.querySelector('button').addEventListener('click', () => remove(toastElement));
    setTimeout(() => remove(toastElement), 10000);
}

const toasts = document.querySelectorAll('.toast')
toasts?.forEach(toast => removeToast(toast));