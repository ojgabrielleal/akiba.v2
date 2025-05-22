export function toast({ type = 'info', promisse = false, promisse_message = 'Carregando...', message = '' }) {
    const toast = document.createElement('div')
    toast.id = `toast-${Date.now()}`
    toast.className = 'fixed bottom-4 right-4 max-w-md w-auto px-6 py-4 rounded shadow-lg text-white text-md font-noto-sans font-light flex items-center gap-2 z-[9999] transition-all'

    const colors = {
        success: 'bg-green-600',
        error: 'bg-red-600',
        info: 'bg-blue-600',
        warning: 'bg-yellow-500 text-black',
        loading: 'bg-[#0091ff]',
    }

    const promisse_icon = `
        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor"
            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
    `

    const loading_icon = `
        <svg class="h-5 w-5 text-white animate-spin" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
            <circle class="opacity-20" cx="25" cy="25" r="20" fill="none" stroke="currentColor" stroke-width="5"/>
            <path fill="currentColor" d="M25 5a20 20 0 0 1 20 20h-5a15 15 0 0 0-15-15V5z"/>
        </svg>
    `

    if (promisse) {
        toast.className += ' bg-gray-700'
        toast.innerHTML = `${promisse_icon}<span>${promisse_message}</span>`
        document.body.appendChild(toast)

        setTimeout(() => {
            toast.className = toast.className.replace('bg-gray-700', colors[type] || 'bg-gray-700')
            toast.innerHTML = `<span>${message}</span>`
        }, 1500)
    } else {
        toast.className += ' ' + (colors[type] || 'bg-gray-700')
        const icon = type === 'loading' ? `${loading_icon}` : ''
        toast.innerHTML = `${icon}<span>${message}</span>`
        document.body.appendChild(toast)
    }

    // Remover após 3 segundos
    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-2')
        setTimeout(() => toast.remove(), 300)
    }, 3000)
}
