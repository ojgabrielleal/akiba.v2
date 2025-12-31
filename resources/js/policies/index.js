export function policy(permissions, permission){
    return permissions.some(p => p.name === permission);
}