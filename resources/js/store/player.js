import { writable } from 'svelte/store';

// ==========================
// --- Store do Player ---
// ==========================

/**
 * Store do player que guarda o estado atual:
 * - isPlaying: se a música está tocando
 * - volume: volume do áudio (0.0 a 1.0)
 */
export const player = writable({
    isPlaying: false,
    volume: 1.0
});

/**
 * Retorna o elemento de áudio principal da página.
 * @returns {HTMLAudioElement | null}
 */
const getAudio = () => document.getElementById('stream');

// ==========================
// --- Metadados (Cast) ---
// ==========================

/** ID do intervalo de atualização dos metadados */
let metadataInterval = null;

/** Inicia a busca periódica por metadados */
function startMetadataPolling() {
    if (metadataInterval) return;
    fetchMetadata();
    metadataInterval = setInterval(fetchMetadata, 15000); // a cada 15 segundos
}

/** Para a busca periódica por metadados */
function stopMetadataPolling() {
    clearInterval(metadataInterval);
    metadataInterval = null;
}

/**
 * Busca os metadados da música (título, artista) da API.
 */
async function fetchMetadata() {
    try {
        const response = await fetch('/api/cast/data'); // Substitua pela URL real da sua API
        if (!response.ok) {
            console.error('Falha ao buscar metadados.');
            return;
        }

        const data = await response.json();

        updateMediaSession({
            title: 'DJ ' + data.onair.user.nickname + ' - ' + data.onair.program.name,
            artist: data.stream.musica_atual,
            artwork: [{ src: data.stream.capa_musica, sizes: '512x512', type: 'image/png' }],
        });

    } catch (error) {
        console.error('Erro ao processar metadados:', error);
    }
}

// ==========================
// --- Media Session ---
// ==========================

/**
 * Atualiza os metadados do player exibidos no sistema operacional.
 * @param {object} metadata - Informações da música
 */
export function updateMediaSession({ title, artist, artwork }) {
    if ('mediaSession' in navigator) {
        navigator.mediaSession.metadata = new MediaMetadata({
            title: title || 'DJ Aki-Chan - Let`s Play Akiba',
            artist: artist || 'Yousei Teikoku - Kuusou Mesorogiwi',
            album: 'Rede Akiba - O Paraíso dos Otakus',
            artwork: artwork || [{ src: '/img/pwa/512.png', sizes: '512x512', type: 'image/png' }]
        });
    }
}

/**
 * Configura os handlers de ações de mídia (play, pause, etc.).
 */
function setupMediaSessionHandlers() {
    if ('mediaSession' in navigator) {
        navigator.mediaSession.setActionHandler('play', () => {
            let isPlaying;
            const unsub = player.subscribe(p => isPlaying = p.isPlaying);
            unsub();
            if (!isPlaying) togglePlayPause();
        });

        navigator.mediaSession.setActionHandler('pause', () => {
            let isPlaying;
            const unsub = player.subscribe(p => isPlaying = p.isPlaying);
            unsub();
            if (isPlaying) togglePlayPause();
        });
    }
}

// Configura os handlers uma única vez
setupMediaSessionHandlers();

// ==========================
// --- Ações do Player ---
// ==========================

/**
 * Alterna entre tocar e pausar a música.
 * Também atualiza Media Session e polling de metadados.
 */
export function togglePlayPause() {
    const audio = getAudio();
    if (!audio) {
        console.error("Elemento de áudio #stream não encontrado.");
        return;
    }

    let isPlayingNow;
    const unsubscribe = player.subscribe(value => isPlayingNow = value.isPlaying);
    unsubscribe();

    if (isPlayingNow) {
        audio.pause();
        stopMetadataPolling();
        if ('mediaSession' in navigator) {
            navigator.mediaSession.playbackState = 'paused';
        }
        player.update(p => ({ ...p, isPlaying: false }));
    } else {
        audio.play()
        .then(() => {
            if ('mediaSession' in navigator) {
                updateMediaSession({});
                navigator.mediaSession.playbackState = 'playing';
            }
            startMetadataPolling();
            player.update(p => ({ ...p, isPlaying: true }));
        })
        .catch(err => console.error("Erro ao reproduzir:", err));
    }
}

/**
 * Define o volume do player.
 * @param {number} newVolume - Valor entre 0.0 e 1.0
 */
export function setVolume(newVolume) {
    const audio = getAudio();
    if (!audio) return;

    const clampedVolume = Math.max(0, Math.min(1, newVolume));
    audio.volume = clampedVolume;
    player.update(p => ({ ...p, volume: clampedVolume }));
}
