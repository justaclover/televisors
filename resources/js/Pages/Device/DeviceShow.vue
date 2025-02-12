<script setup>
import {Link, router} from "@inertiajs/vue3";
import {Delete, Picture as IconPicture} from '@element-plus/icons-vue'
import { ref } from 'vue'

const props = defineProps({
    device: Object,
    playlists: Array,
    videos: Array,
    currentPlaylist: Object})

const nameInput = ref(props.device.name)
const commentInput = ref(props.device.comment)
const locationInput = ref(props.device.location)

let playlistSelection

if (props.currentPlaylist === null) {
    playlistSelection = ref('')
}
else {
    playlistSelection = ref(props.currentPlaylist.name)
}


const options = Array(props.playlists.length)
for (let playlist in props.playlists) {
    options.push({value: playlist.id, label: playlist.name})
}

function updateDevice() {
    axios.defaults.timeout = 30000
    axios.put('/admin/device/' + props.device.id.toString(), {
        name: nameInput.value,
        comment: commentInput.value,
        location: locationInput.value
    })
        .then(response => {
            router.reload()
        })
        .catch(e => {
            console.log(e)
        })
}

function setPlaylist() {
    axios.defaults.timeout = 30000
    console.log(document.getElementById('playlistSelect').value)
    axios.get('/admin/device/' + props.device.id.toString() + '/playlist/attach/' + document.getElementById('playlistSelect').value)
        .then(response => {
            console.log(response)
            router.reload()
        })
        .catch(e => {
            console.log(e)
        })
}
</script>

<template>
    <body class="ml-32 pt-20 pb-20">
    <el-link type="primary" :href="`/admin/device`" class="mb-6">Назад</el-link>

    <section class="flex gap-20 flex-col">
        <div class="flex flex-row gap-14">
            <div class="flex flex-col gap-10">
                <h2 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white">Id: {{device.id}}</h2>
                <p class="font-normal text-gray-700 dark:text-gray-400">Комментарий: {{device.comment}}</p>
            </div>
            <div class="flex flex-col gap-10">
                <h2 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white">Название: {{device.name}}</h2>
                <p class="font-normal text-gray-700 dark:text-gray-400">Местонахождение: {{device.location}}</p>
            </div>
        </div>

        <div class="flex flex-row mb-14 gap-40">
            <div>
                <h3 class="mb-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-white" v-if="currentPlaylist">Плейлист: {{currentPlaylist.name}}</h3>
                <h3 class="mb-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-white" v-else>Плейлист: </h3>
                <div class="mb-16 flex flex-row gap-2">
                    <div class="border-gray-600 rounded-b-sm playlist-select">
                        <select id="playlistSelect" v-model="playlistSelection" style="height: 32px; width: 240px">
                            <option disabled selected hidden v-if="currentPlaylist">{{currentPlaylist.name}}</option>
                            <option disabled selected hidden v-else> </option>
                            <option v-for="playlist in playlists" :key="playlist.id" :value="playlist.id" :label="playlist.name"/>
                        </select>
                    </div>
                    <el-button type="primary" @click="setPlaylist" round>Назначить плейлист</el-button>
                </div>

                <div class="mb-14">
                    <h3 class="mb-8 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Видео</h3>
                    <a v-if="videos" v-for="i in videos" :href="`/file/${i.uuid}`" class="pl-6 pr-4 mb-4 relative flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
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
                    </a>
                </div>
            </div>
            <div>
                <el-form id="deviceForm" class="mr-8">
                    <el-form-item label="Название устройства">
                        <el-input v-model="nameInput" style="width: 240px" class="w-36 border-1 border-gray-600 rounded" type="text" id="deviceName"/>
                    </el-form-item>
                    <el-form-item label="Комментарий к устройству">
                        <el-input v-model="commentInput" style="width: 240px" class="w-72 border-1 border-gray-600 rounded" type="text" id="deviceComment"/>
                    </el-form-item>
                    <el-form-item label="Местонахождение устройства">
                        <el-input v-model="locationInput" style="width: 240px" class="w-72 border-1 border-gray-600 rounded" type="text" id="deviceLocation"/>
                    </el-form-item>
                    <el-button type="primary" @click="updateDevice" round>Обновить данные</el-button>
                </el-form>
            </div>
        </div>
    </section>
    </body>
</template>

<style scoped>
    .playlist-select {
        border-radius: 3px;
        margin-right: 30px;
        background-color: white;
    }

    #playlistSelect {
        border: #CFD3DC 1px solid;
        border-radius: 3px;
        background-color: white;
        font-size: 14px;
        padding: 5px;
        height: 35px;
        width: 350px;
    }
</style>


