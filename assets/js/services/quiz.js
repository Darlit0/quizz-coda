document.addEventListener('DOMContentLoaded', () => {
    const accordion = document.getElementById('accordionExample');
    accordion.addEventListener('change', (event) => {
        if (event.target.type === 'radio') {
            const currentItem = event.target.closest('.accordion-item');
            const nextItem = currentItem.nextElementSibling;
            if (nextItem) {
                const nextButton = nextItem.querySelector('.accordion-button');
                nextButton.click();
            }
        }
    });
});