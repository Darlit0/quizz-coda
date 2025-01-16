import {toggleEnabledUser} from "../services/quiz.js"

export const handleEnabledClick = () => {
    const enabledIcons = document.querySelectorAll(".enabled-icon")

    enabledIcons.forEach(enabledIcon => {
        enabledIcon.addEventListener('click', async (e) => {
            const userId = e.target.getAttribute('data-id')
            const result = await toggleEnabledUser(userId)
            if (result.hasOwnProperty('success')) {
                if (e.target.classList.contains('fa-check')) {
                    e.target.classList.remove('fa-check', 'text-success')
                    e.target.classList.add('fa-xmark', 'text-danger')
                } else {
                    e.target.classList.add('fa-check', 'text-success')
                    e.target.classList.remove('fa-xmark', 'text-danger')
                }
            }
        })
    })
}