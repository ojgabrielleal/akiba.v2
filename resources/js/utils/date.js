export function date(entrance, type) {
    let date = new Date(entrance);

    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");

    switch (type) {
        case 'd':
            return day;
        case 'd/m':
            return `${day}/${month}`;
        case 'd/m/y':
            return `${day}/${month}/${year}`
    }
}

export function time(entrance) {
    let split = entrance.split(':');

    return `${split[0]}h${split[1]}`
}