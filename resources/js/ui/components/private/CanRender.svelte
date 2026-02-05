<script>
    import { page } from "@inertiajs/svelte";

    export let permission = null;
    export let when = true;

    $: ({ user } = $page.props);

    $: permissions = user.permissions;
    $: permissionsName = permissions.map((p) => p.name);

    $: hasPermission = checkPermission();

    function checkPermission() {
        if (!permission) return null;

        if(Array.isArray(permission)){
            for(const p of permission){
                if(permissionsName.includes(p)){
                    return true
                }
            }
        }else{
            if(permissionsName.includes(permission)){
                return true
            }
        }

        return false;
    }
</script>

{#if hasPermission && when}
    <slot />
{:else}
    <slot name="fallback" />
{/if}
