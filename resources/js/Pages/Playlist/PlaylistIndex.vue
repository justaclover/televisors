<script setup>
import {ref} from 'vue'
import {Link, router} from '@inertiajs/vue3'
import {Delete} from "@element-plus/icons-vue";
const props = defineProps({
    items: Array
})

const nameInput = ref('')
const commentInput = ref('')

function addPlaylist() {
    axios.defaults.timeout = 30000
    console.log(document.getElementById('playlistName').value)
    axios.post('/admin/playlist', {
        name: document.getElementById('playlistName').value,
        comment: document.getElementById('playlistComment').value
    })
        .then(response => {
            document.getElementById('playlistForm').reset()
            router.reload()
        })
        .catch(e => {
            console.log(e)
        })
}


</script>

<template>
    <div class="ml-32 pt-20 pb-20">
        <section>
            <el-link type="primary" :href="`/admin`" class="mb-6">Назад</el-link>

            <h2 class="mb-8 text-4xl font-bold tracking-tight text-gray-900 dark:text-white">Плейлисты</h2>
            <el-form id="playlistForm" class="mb-14">
                <el-form-item label="Название плейлиста">
                    <el-input v-model="nameInput" style="width: 240px" class="w-36 border-1 border-gray-600 rounded" type="text" id="playlistName"/>
                </el-form-item>
                <el-form-item label="Комментарий к плейлисту">
                    <el-input v-model="commentInput" style="width: 240px" class="w-72 border-1 border-gray-600 rounded" type="text" id="playlistComment"/>
                </el-form-item>
                <el-button type="primary" @click="addPlaylist" round>Добавить плейлист</el-button>
            </el-form>

            <template v-for="item in items">
                <a  :href="`/admin/playlist/${item.id}`" class="relative mb-4 block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                    <div class="flex flex-col justify-between p-4 leading-normal flex-wrap">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{item.name}}</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400">{{item.comment}}</p>
                    </div>
                    <Link method="DELETE" :href="`/admin/playlist/${item.id}`" class="absolute right-10 top-14">
                        <el-button type="danger" circle :icon="Delete"/>
                    </Link>
                </a>
            </template>
        </section>
    </div>
</template>

<style scoped>

</style>
