<script setup>
import {Link, router} from "@inertiajs/vue3";
import {Delete, Picture as IconPicture} from '@element-plus/icons-vue'
import { ref } from 'vue'

const props = defineProps({device: Object, playlists: Array, currentPlaylist: Object})

const nameInput = ref(props.device.name)
const commentInput = ref(props.device.comment)
const locationInput = ref(props.device.location)

const playlistSelection = ref(props.currentPlaylist.name)

const options = Array(props.playlists.length)
for (let playlist in props.playlists) {
    options.push({value: playlist.id, label: playlist.name})
}

function updateDevice() {
    axios.defaults.timeout = 30000
    axios.put('/admin/device/' + props.device.id.toString(), {
        name: document.getElementById('deviceName').value,
        comment: document.getElementById('deviceComment').value,
        location: document.getElementById('deviceLocation').value
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
            router.reload()
        })
        .catch(e => {
            console.log(e)
        })
}
</script>

<template>
    <section class="flex gap-3 flex-col ml-32 pt-20">
        <a :href="`/admin/device`" class="mb-6">
            <el-button type="primary" round>Назад</el-button>
        </a>
        <h2 class="mb-4 text-4xl font-bold tracking-tight text-gray-900 dark:text-white">{{device.id}}</h2>
        <h3 class="mb-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{device.name}}</h3>
        <h3 class="mb-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Плейлист: {{currentPlaylist.name}}</h3>
        <p class="mb-4 font-normal text-gray-700 dark:text-gray-400">Комментарий: {{device.comment}}</p>
        <p class="mb-8 font-normal text-gray-700 dark:text-gray-400">Местонахождение: {{device.location}}</p>

        <div class="flex flex-row mb-14">
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

            <div class="border-gray-600 rounded-b-sm" style="
            border: #CFD3DC 1px solid;
            border-radius: 3px;
            margin-right: 30px;
            background-color: white">
                <select id="playlistSelect" v-model="playlistSelection" style="height: 32px; width: 240px">
                    <option disabled selected hidden>{{currentPlaylist.name}}</option>
                    <option v-for="playlist in playlists" :key="playlist.id" :value="playlist.id" :label="playlist.name"/>
                </select>
            </div>
            <el-button type="primary" @click="setPlaylist" round>Назначить плейлист</el-button>
        </div>

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
    </section>
</template>


