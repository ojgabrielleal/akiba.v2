export const scrollx = (event) => {
    const el = event.currentTarget; // o elemento que recebeu o evento
    if (el.scrollWidth > el.clientWidth) {
        el.scrollLeft += event.deltaY;
        event.preventDefault();
    }
}
