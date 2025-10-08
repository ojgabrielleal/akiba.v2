import { writable } from 'svelte/store';

// O store guarda o estado do player
export const player = writable({
    isPlaying: false,
    volume: 1.0
});

const getAudio = () => document.getElementById('stream');

// As ações são funções exportadas que manipulam o player e atualizam o store
export function togglePlayPause() {
    const audio = getAudio();
    if (!audio) {
        console.error("Elemento de áudio #stream não encontrado.");
        return;
    }

    // Pega o estado atual do store
    let isPlayingNow;
    const unsubscribe = player.subscribe(value => {
        isPlayingNow = value.isPlaying;
    });
    unsubscribe(); // Cancela a inscrição logo após pegar o valor

    if (isPlayingNow) {
        audio.pause();
        audio.volume = 0.9; // Lógica do seu código original
        player.update(p => ({...p, isPlaying: false, volume: 0.9}));
    } else {
        audio.play()
            .then(() => {
                player.update(p => ({...p, isPlaying: true}));
            })
            .catch(err => {
                console.error("Erro ao reproduzir:", err);
            });
    }
}

export function setVolume(newVolume) {
    const audio = getAudio();
    if (!audio) return;

    const clampedVolume = Math.max(0, Math.min(1, newVolume));
    audio.volume = clampedVolume;
    player.update(p => ({ ...p, volume: clampedVolume }));
}
