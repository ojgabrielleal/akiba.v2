import { page } from '@inertiajs/svelte';
import { get } from 'svelte/store';

export function hasPermission(permission) {
    const permissions = get(page).props.user.permissions ?? [];
    return permissions.includes(permission);
}