import axios from 'axios';

import { writable, get } from "svelte/store"

export const player = writable({
    playing: false,
    volume: 0.05,
    metadata: null,
});

const getAudio = () => document.getElementById('radio');

export function togglePlayPause() {
    const audio = getAudio();
    
    let playing = get(player).playing;
    if (playing) {
        audio.pause()
        player.update(p=>({...p, playing: false}));
    } else {        
        audio.play()
        player.update(p=>({...p, playing: true}));
    }
}

export function setVolume(newVolume) {
    const audio = getAudio();
    audio.volume = newVolume;

    player.update(current => ({ ...current, volume: newVolume }));
}
