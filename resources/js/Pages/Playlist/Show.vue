<template>
    <section class="flex gap-3 flex-col">
        {{item.name}}
    <div>
    </div>
    
<a v-for="i in items" :href="`/file/${i.uuid}`" class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
    <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" src="/docs/images/blog/image-4.jpg" alt="">
    <div class="flex flex-col justify-between p-4 leading-normal">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{i.name}}</h5>
        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{i.uuid}}</p>
    </div>
    <Link method="DELETE" :href="`/file/${i.uuid}`">
    <button>Удалить</button>
    </Link>
</a>
    <form method="POST" enctype="multipart/form-data" :action="`/admin/playlist/${item.id}/file`" id="videoForm">
        <input name="file" type="file" placeholder="Загрузить видео" id="videoFile">
        <button type="submit">Загрузить видео</button>
    </form>

    </section>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";
    const props = defineProps({
        items: Array,
        item: Object
    })
</script>