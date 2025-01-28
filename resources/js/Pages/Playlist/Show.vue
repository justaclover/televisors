<script setup>
import {Link} from "@inertiajs/vue3";
import {Delete, Picture as IconPicture} from '@element-plus/icons-vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({videos: Array, playlist: Object})

</script>

<template>
    <section class="flex gap-3 flex-col ml-32 pt-20">
        <a :href="`/admin/playlist`" class="mb-10">
            <el-button type="primary" round><- Назад</el-button>
        </a>

        <h2 class="mb-8 text-4xl font-bold tracking-tight text-gray-900 dark:text-white">{{playlist.name}}</h2>

        <div class="mb-14">
            <a v-for="i in videos" :href="`/file/${i.uuid}`" class="pl-6 mb-4 relative flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                <el-image>
                    <template #error>
                        <div class="image-slot">
                            <el-icon><icon-picture /></el-icon>
                        </div>
                    </template>
                </el-image>
                <div class="flex flex-col justify-between p-4 leading-normal flex-wrap">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{i.name}}</h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{i.uuid}}</p>
                </div>
                <Link method="DELETE" :href="`/file/${i.uuid}`" class="absolute right-10">
                    <el-button type="danger" circle :icon="Delete"/>
                </Link>
            </a>
        </div>

        <form class="upload-demo" method="POST" enctype="multipart/form-data" :action="`/admin/playlist/${playlist.id}/file`" id="videoForm">
            <input type="file" name="file" class="font-normal">
            <button type="submit" class="font-normal text-white rounded-3xl text-center pl-5 pr-5 pt-3 pb-3" style="background-color: #67c23a">Загрузить видео</button>
        </form>
    </section>
</template>

