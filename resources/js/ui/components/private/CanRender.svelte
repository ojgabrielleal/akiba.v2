<script>
    import { page } from "@inertiajs/svelte";

    export let permission = null;
    export let when = true;
    export let any = [];
    export let all = [];

    $: ({ logged } = $page.props);

    $: permissions = logged.permissions || [];
    $: permissionNames = permissions.map((p) => p.name);

    $: hasPermission = checkPermission();

    function checkPermission() {
        if (permission) {
            return permissionNames.includes(permission);
        }

        if (any.length) {
            return any.some((p) => permissionNames.includes(p));
        }

        if (all.length) {
            return all.every((p) => permissionNames.includes(p));
        }

        return false;
    }
</script>

{#if hasPermission && when}
    <slot />
{:else}
    <slot name="fallback" />
{/if}
