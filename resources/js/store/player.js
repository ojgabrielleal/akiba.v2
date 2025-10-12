import axios from 'axios';
import { writable, get } from "svelte/store"

export const player = writable({
    playing: false,
    volume: 1.0,
    metadata: null,
});

const getAudio = () => document.getElementById('stream');

async function metadata() {
    axios.get('/api/cast/metadata')
    .then((response) => {
        let data = response.data

        let music_cover
        if(data.stream.capa_musica === "https://player.painelcast.com/img/img-capa-artista-padrao.png"){
            music_cover = new URL('/img/default/no-cover.webp', window.location.origin).href
        }else{
            music_cover = data.stream.capa_musica
        }

        mediaSession({
            title: 'DJ ' + data.onair.user.nickname + ' - ' + data.onair.program.name,
            artist: decodeURIComponent(escape(data.stream.musica_atual)),
            artwork: [{ src: music_cover, sizes: '512x512', type: 'image/png' }],
        });
    })
    .catch((error) => {
        console.error('Erro ao processar metadados:', error);
    });
}

function mediaSession({ title, artist, artwork }) {
    if ('mediaSession' in navigator) {
        navigator.mediaSession.metadata = new MediaMetadata({
            title: title || 'DJ Aki-Chan - Let`s Play Akiba',
            artist: artist || 'Yousei Teikoku - Kuusou Mesorogiwi',
            album: 'Rede Akiba - O Paraíso dos Otakus',
            artwork: artwork || [{ src: new URL('/img/default/no-cover.webp', window.location.origin).href, sizes: '512x512', type: 'image/png' }]
        });
    }
}

function mediaSessionHandlers(){
    if ('mediaSession' in navigator) {
        navigator.mediaSession.setActionHandler('play', () => {
            let playing = get(player).playing;
            if (!playing) togglePlayPause();
        });
        
        navigator.mediaSession.setActionHandler('pause', () => {
            let playing = get(player).playing;
            if (playing) togglePlayPause();
        });
    }
}
mediaSessionHandlers();

let interval;
function startMetadataPooling(){
    if(interval) return;
    metadata(); // Primeira chamada
    interval = setInterval(()=>{
        metadata();
    }, 30 * 1000);
}

function stopMetadataPooling(){
    if(!interval) return;
    clearInterval(interval);
    interval = null;
}

export function togglePlayPause() {
    const audio = getAudio();
    
    let playing = get(player).playing;
    if (playing) {
        audio.pause()
        player.update(p=>({...p, playing: false}));
        if ('mediaSession' in navigator) {
            navigator.mediaSession.playbackState = 'paused';
            stopMetadataPooling();
        }
    } else {        
        audio.play()
        player.update(p=>({...p, playing: true}));
        if ('mediaSession' in navigator) {
            navigator.mediaSession.playbackState = 'playing';
            startMetadataPooling();
        }
    }
}

export function setVolume(newVolume) {
    const audio = getAudio();
    audio.volume = newVolume;

    player.update(current => ({ ...current, volume: newVolume }));
}
