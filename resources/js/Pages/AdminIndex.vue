<script setup>
import draggable from 'vuedraggable'
import {CirclePlusFilled} from "@element-plus/icons-vue";
import {ref} from "vue";
import Drag from "@/Pages/Drag.vue";

const props = defineProps({
    playlists: Array,
    devices: Array
})

</script>

<template>
    <!--
    <div v-for="item in playlists">
        <draggable v-model="meals" tag="ul" group="devices">
            <template #item="{ element: meal }">
                <li>{{ meal }}</li>
            </template>
        </draggable>
    </div>
    <p>---------------</p>
    <draggable v-model="yuckyMeals" tag="ul" group="devices">
        <template #item="{ element: meal }">
            <li>{{ meal }}</li>
        </template>
    </draggable>
    -->
    <div class="ml-32 pt-20 mb-10 flex flex-row gap-8 max-w-full">
        <a :href="`/admin/playlist`" class="w-4/12">
            <h2 class="mb-8 text-4xl font-bold tracking-tight text-gray-900 dark:text-white text-center">Плейлисты</h2>

            <template v-for="item in playlists" class="mb-10">
                <a  :href="`/admin/playlist/${item.id}`" class="mb-4 block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{item.name}}</h5>
                    <p class="font-normal text-gray-700 dark:text-gray-400">Комментарий: {{item.comment}}</p>
                    <p class="font-normal text-gray-700 dark:text-gray-400">Количество видео: {{item.video_count}}</p>
                </a>
            </template>
            <div class="flex justify-center align-middle flex-row gap-2 max-w-sm">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Добавить</h5>
                <el-icon color="#409EFF" :size="40"><CirclePlusFilled /></el-icon>
            </div>
        </a>

        <a :href="`/admin/device`" class="w-4/12">
            <h2 class="mb-8 text-4xl font-bold tracking-tight text-gray-900 dark:text-white text-center">Устройства</h2>

            <template v-for="item in devices">
                <a  :href="`/admin/device/${item.id}`" class="mb-4 block max-w-lg p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{item.id}}</h5>
                    <p class="font-bold text-gray-700 dark:text-gray-400">Последний раз в сети: {{item.last_online_at}}</p>
                    <p class="font-normal text-gray-700 dark:text-gray-400">Название: {{item.name}}</p>
                    <p class="font-normal text-gray-700 dark:text-gray-400">Комментарий: {{item.comment}}</p>
                    <p class="font-normal text-gray-700 dark:text-gray-400">Местонахождение: {{item.location}}</p>
                </a>
            </template>
        </a>
    </div>
    <el-link type="primary" :href="`/logout`" class="ml-32 mb-6">Выйти из аккаунта</el-link>
</template>

<style scoped>

</style>
