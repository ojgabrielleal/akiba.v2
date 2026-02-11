<script>
    export let title;
    export let calendar;
    export let user;

    import { Section } from "@/ui/components/private/";
    import { hasPermissions } from "@/utils";
    import tags from "@/data/calendar/tags.json";

    $: authorization = {
        canUpdate: hasPermissions(user, 'calendar.update')
    }

    let week = [];

    $: if (calendar) {
        const today = new Date();
        const days = ["dom", "seg", "ter", "qua", "qui", "sex", "sáb"];
        
        for (let i = 0; i < 7; i++) {
            const date = new Date(today);
            date.setDate(today.getDate() + i);

            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, "0");
            const day = String(date.getDate()).padStart(2, "0");
            const dateString = `${year}-${month}-${day}`;

            week.push({
                date: `${day}/${month}`,
                day: days[date.getDay()],
                events: calendar.filter((item) => item.date === dateString),
            });
        }
    }
</script>

<Section {title}>
    <div  class="w-full grid gap-5 grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7">
        {#each tags as item}
            <span class={`h-10 text-lg font-noto-sans font-bold uppercase italic rounded-lg flex justify-center items-center ${item.color} ${item.textcolor}`}>
                {item.label}
            </span>
        {/each}
    </div>
    <div class="w-full grid gap-5 mt-5 grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7">
        {#each week as day}
            <div class="flex flex-col gap-2 w-full">
                <div class="text-neutral-aurora text-lg font-noto-sans text-center font-bold uppercase italic">
                    {day.day} - {day.date}
                </div>
                {#each day.events as event}
                    {@const isLive = event.category === "live"}
                    {@const isYoutube = event.category === "youtube"}
                    {@const isPodcast = event.category === "podcast"}
                    {@const isActivity = event.category === "activity"}
                    <div class={["w-full 2xl:w-[12.7rem] bg-blue-skywave rounded-lg pt-4 pl-4 pr-4 pb-3 mt-5",
                        {"bg-purple-mystic": isLive },
                        {"bg-red-crimson": isYoutube },
                        {"bg-green-forest": isPodcast },
                        {"bg-neutral-honeycream": isActivity },
                    ]}>
                        <div class="flex events-center">
                            <div class={["w-full font-noto-sans text-2xl text-center uppercase",
                                {"text-blue-midnight": isActivity },
                                {"text-neutral-aurora": !isActivity },
                            ]}>
                                {event.time}
                            </div>
                        </div>
                        <div class={["w-full font-noto-sans font-bold text-2xl text-center italic mt-6 mb-6",
                            { "text-blue-midnight": isActivity },
                            { "text-neutral-aurora": !isActivity },
                        ]}>
                            {#if event.has_activity}
                                {event.activity.title}
                            {:else}
                                {event.content}
                            {/if}
                        </div>
                        <div class="flex justify-between flex-row">
                            {#if authorization.canUpdate}
                                <button aria-label="Editar" class="cursor-pointer">
                                    <img src="/svg/default/edit.svg" alt="" aria-hidden="true" loading="lazy" class={["w-5 filter-neutral-aurora",
                                        {"filter-blue-midnight": isActivity}
                                    ]}/>
                                </button>
                            {/if}
                            <div class={["w-full font-noto-sans text-md text-end",
                                { "text-blue-midnight": isActivity },
                                { "text-neutral-aurora": !isActivity },
                            ]}>
                                {event.responsible.nickname}
                            </div>
                        </div>
                    </div>
                {/each}
            </div>
        {/each}
    </div>
</Section>
