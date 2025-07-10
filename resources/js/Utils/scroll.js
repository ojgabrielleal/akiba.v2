export function scrollx(event, container) {
    if (container && container.scrollWidth > container.clientWidth) {
        container.scrollLeft += event.deltaY;
        event.preventDefault();
    }
}
