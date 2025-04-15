<script setup>
import {Delete} from "@element-plus/icons-vue";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    items: Array
})

</script>

<template>
    <div class="ml-32 pt-20 pb-20">
        <section>
            <el-link type="primary" :href="`/admin`" class="mb-6">Назад</el-link>

            <h2 class="mb-8 text-4xl font-bold tracking-tight text-gray-900 dark:text-white">Устройства</h2>

            <template v-for="item in items">
                <a  :href="`/admin/device/${item.id}`" class="relative mb-4 block max-w-lg p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                    <div class="flex flex-col justify-between p-4 leading-normal flex-wrap">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{item.id}}</h5>
                        <p class="font-bold text-gray-700 dark:text-gray-400">Последний раз в сети: {{item.last_online_at}}</p>
                        <p class="font-normal text-gray-700 dark:text-gray-400">Название: {{item.name}}</p>
                        <p class="font-normal text-gray-700 dark:text-gray-400">Комментарий: {{item.comment}}</p>
                        <p class="font-normal text-gray-700 dark:text-gray-400">Местонахождение: {{item.location}}</p>
                    </div>
                    <Link method="DELETE" :href="`/admin/device/${item.id}`" class="absolute right-10 top-14">
                        <el-button type="danger" circle :icon="Delete"/>
                    </Link>
                </a>
            </template>
        </section>
    </div>
</template>

<style scoped>

</style>
