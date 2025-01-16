<script setup>
import {Head, usePage} from '@inertiajs/vue3'
import {computed, reactive} from 'vue'
import { router } from '@inertiajs/vue3'

function uploadVideo() {
    const formData = new FormData(document.getElementById('videoForm'))

    axios.post('</admin/>playlists', {
        video: formData
    })
        .then(
            document.getElementById('videoForm').reset(),
            router.reload()
        )
}

function addPlaylist() {
    // const formData = new FormData()
    // formData.append('name', document.getElementById('playlistName').value)
    // formData.append('comment', document.getElementById('playlistComment').value)

    //console.log(formData)
    axios.defaults.timeout = 30000
    console.log(document.getElementById('playlistName').value)
    axios.post('/admin/playlists', {
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
    <Head>Панель администратора</Head>
    <form id="playlistForm" @submit.prevent="addPlaylist">
        <input type="text" placeholder="Название плейлиста" id="playlistName">
        <input type="text" placeholder="Комментарий к плейлисту" id="playlistComment">
        <button type="submit">Добавить плейлист</button>
    </form>

    <form id="videoForm">
        <input type="file" placeholder="Загрузить видео">
        <button type="submit" v-on:click="uploadVideo">Загрузить видео</button>
    </form>
</template>

<style scoped>

</style>
