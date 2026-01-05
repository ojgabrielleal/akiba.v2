export function date(entrance, type){
    let date = new Date(entrance);
    
    switch(type){
        case 'd': 
            return date.getUTCDate();
        case 'd/m': 
            return `${date.getUTCDate() < 10 ? '0' + date.getUTCDate() : date.getUTCDate()}/${(date.getUTCMonth() + 1) < 10 ?  '0' + (date.getUTCMonth() + 1) : date.getUTCMonth() + 1}`;
        case 'd/m/y': 
            return `${date.getUTCDate() < 10 ? '0' + date.getUTCDate() : date.getUTCDate()}/${(date.getUTCMonth() + 1) < 10 ?  '0' + (date.getUTCMonth() + 1) : date.getUTCMonth() + 1}/${date.getFullYear()}`
        case '00:00':
            return `${date.getHours()}h${date.getMinutes()}`
    }
}