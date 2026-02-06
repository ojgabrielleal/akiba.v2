export function hasPermissions(user, permission){
    const userPermissions = user.permissions.map(p => p.name);

    if(Array.isArray(permission)){
        return permission.some(p => userPermissions.includes(p))
    }

    return userPermissions.includes(permission)
}

export function hasRoles(user, role){
    const userRoles = user.roles.map(r => r.name);

    if(Array.isArray(role)){
        return role.some(r => userRoles.includes(r))
    }
    
    return userRoles.includes(role);
}