<script>
    import { Meta } from "@/config/meta";
    import { Notification } from "@/ui/components/private";
    import { LoginForm } from "@/ui/widgets/private/form";
</script>

<Meta meta={{ title: "Realize o Login" }} />
<Notification/>
<div class="w-screen h-screen flex justify-center items-center bg-blue-indigo p-5">
    <section class="bg-neutral-aurora rounded-l-lg rounded-xl xl:w-[60rem] xl:h-[30rem] xl:grid xl:grid-cols-[2fr_3fr]">
        <div class="flex items-center p-8">
            <LoginForm/>
        </div>
        <div class="h-full overflow-hidden rounded-r-lg hidden xl:block">
            <img class="w-full h-full object-cover" src="https://a.storyblok.com/f/178900/1460x821/21059378e0/i-made-friends-with-the-second-prettiest-girl-in-my-class-hero.png/m/1200x0/filters:quality(95)format(webp)" alt="" aria-hidden="true"/>
        </div>
    </section>
</div>