<script setup>
import {Link, router} from "@inertiajs/vue3";
import {Delete, Picture as IconPicture} from '@element-plus/icons-vue'
import * as Icons from '@element-plus/icons-vue';
import {onMounted, ref} from "vue";
import { useDropzone } from "vue3-dropzone";
import { uploadService } from 'vuejs-chunks-upload';

const props = defineProps({videos: Array, playlist: Object})

const allowedFileTypes = ['video/mp4', 'video/webm', 'video/mpeg', 'video/ogg'];

const videoFile = ref()
const progress = ref(0)
const startedUploading = ref(false)
const fileList = ref(null)

const nameInput = ref(props.playlist.name)
const commentInput = ref(props.playlist.comment)


onMounted(() => {
    console.log(props)
    console.log(props.videos[0].custom_properties.thumb_url)
    if (props.newFile != null){
        console.log(props)
        console.log(props.newFile)
        //onDrop(props.newFile);
    }
})

function onDrop(f, rejectReasons) {
    console.log(f.raw);
    videoFile.value = f.raw;
    console.log(fileList.value)
    if (!(allowedFileTypes.includes(videoFile.value.type))){
        alert("Файл не поддерживаемого формата!")
        videoFile.value.clearFiles()
    }
    //Object.defineProperty(videoFile.value, "name", {value: "#\\p{C}+#u"})
}

const { getRootProps, getInputProps, ...rest } = useDropzone({ onDrop });

function updatePlaylist() {
    axios.defaults.timeout = 30000
    axios.put('/admin/playlist/' + props.playlist.id.toString(), {
        name: nameInput.value,
        comment: commentInput.value,
    })
        .then(response => {
            router.reload()
        })
        .catch(e => {
            console.log(e)
        })
}

function uploadVideo(){
    //console.log(videoFile.value)

    startedUploading.value = true
    uploadService.chunk("/admin/playlist/" + props.playlist.id.toString() + "/file", videoFile.value,
        // Progress
        percent => {
            progress.value = percent;
            //console.log(progress.value)
        },
        err => {
            console.log(err)
            alert("Имя файла некорректно! Оно будет изменено на " + err.response.data.new_filename)
            Object.defineProperty(videoFile.value, "name", {value: err.response.data.new_filename})
            console.log(videoFile.value)
            //console.log(videoFile.value)
            uploadVideo()
        },
        // Success
        res => {
            //console.log('uploaded')
            progress.value = 0
            startedUploading.value = false
            videoFile.value = null
            fileList.value.clearFiles()
            router.reload()
        },
        // Error
    );
}
</script>

<template>
    <body class="ml-32 pt-20 pb-20">
    <el-link type="primary" :href="`/admin/playlist`" class="mb-6">Назад</el-link>
    <section class="flex gap-3 flex-col pb-10">
        <h2 class="mb-8 text-4xl font-bold tracking-tight text-gray-900 dark:text-white">{{playlist.name}}</h2>
        <p class="mb-4 font-normal text-gray-700 dark:text-gray-400">Комментарий: {{playlist.comment}}</p>

        <div class="mb-14">
            <el-form id="deviceForm" class="mr-8">
                <el-form-item label="Название плейлиста">
                    <el-input v-model="nameInput" style="width: 240px" class="w-36 border-1 border-gray-600 rounded" type="text" id="playlistName"/>
                </el-form-item>
                <el-form-item label="Комментарий к плейлисту">
                    <el-input v-model="commentInput" style="width: 240px" class="w-72 border-1 border-gray-600 rounded" type="text" id="playlistComment"/>
                </el-form-item>
                <el-button type="primary" @click="updatePlaylist" round>Обновить данные</el-button>
            </el-form>
        </div>
        <div class="mb-14">
            <h3 class="mb-8 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Видео</h3>
            <p class="font-normal mb-4 text-gray-700 dark:text-gray-400">Количество видео: {{playlist.video_count}}</p>
            <a v-for="i in videos" :href="`/file/${i.uuid}`" class="mb-4 relative flex items-center bg-white border border-gray-200 rounded-lg md:flex-row max-w-3xl shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                <el-image v-if="i.custom_properties.thumb_url" :fit="scale-down" :src="`/file/${i.uuid}/thumb`" class="rounded-lg max-w-60"/>
                <el-image v-else class="ml-6">
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
                <Link method="DELETE" :href="`/file/${i.uuid}`" class="absolute right-5 bottom-5">
                    <el-button type="danger" :icon="Delete" round>Удалить</el-button>
                </Link>
            </a>
        </div>

        <div class="upload-demo flex flex-row gap-5 align-baseline" id="videoForm">
            <!--
            <div v-bind="getRootProps()">
                <label for="videoInput" class="custom-video-input font-normal mr-6">Перетащите видео сюда или нажмите, чтобы выбрать</label>
                <input accept="video/*" type="file" name="file" class="font-normal video-input" id="videoInput" v-bind="getInputProps()">
            </div>
            -->
            <el-upload ref="fileList" drag :on-change="onDrop" :auto-upload="false" accept="video/mp4, video/webm, video/mpeg, video/ogg">
                <el-icon class="el-icon--upload">
                    <Icons.UploadFilled />
                </el-icon>
                <div class="el-upload__text">
                    Переместите или <em>выберите файл</em>
                </div>
            </el-upload>
            <!--<button v-on:click="uploadVideo" class="font-normal text-white rounded-3xl text-center pl-5 pr-5 h-8" style="background-color: #409EFF">Загрузить видео</button>-->
            <el-button v-on:click="uploadVideo" round type="primary" size="large">Загрузить видео</el-button>
        </div>
        <el-progress
            :text-inside="true"
            :stroke-width="20"
            :percentage=progress
            v-if="startedUploading"
            width="200"
        />
        <p v-if="startedUploading">Процесс начался</p>
    </section>
    </body>
</template>

<style scoped>
    .video-input {
        display: none;
    }

    .custom-video-input {
        color: #409EFF;
        font-size: 16px;
    }

    .custom-video-input:hover {
        color: rgb(102.2, 177.4, 255);
        cursor: pointer;
    }
</style>

