<script>
    export let type = "text";
    export let name; 
    export let placeholder;
    export let styles = "w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4";
    export let value; 
</script>

<input
  value={value}
  on:input={(e) => value = e.target.value}
  type={type}
  name={name}
  id={name}
  class={styles}
  placeholder={placeholder}
  aria-label={name}
/>
