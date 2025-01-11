<script setup>
import {Head, usePage} from '@inertiajs/vue3'
import {computed, reactive} from 'vue'
import { router } from '@inertiajs/vue3'

let device_id
let ready_to_play = false

checkForId()

function checkForId() {
    if (localStorage.getItem('device_id') === null) {
        axios.get('/add-device')
            .then(response => {
                localStorage.setItem('device_id', response.data['device_id'].toString())
                router.reload(checkForId())
            })
            .catch(error => {
                alert(error)
            })
    }
    device_id = localStorage.getItem('device_id')
    getVideos(device_id)

}

function getVideos(id) {
    let url = '/devices/' + id.toString() + '/playlist'
    axios(url)
        .then(response => {
            //localStorage.setItem('ready_to_play', response.data['ready'])
            //ready_to_play = response.data['ready']
            //console.log(response.data['ready'])
            router.reload(playVideos(response.data['ready']))
        })
        .catch(error => {
            alert(error)
        })
}

function playVideos(ready){
    console.log(ready)
    ready_to_play = ready
}

</script>

<template>
    <div v-if="ready_to_play">
        <h1>Тут видеоплеер</h1>
    </div>
    <h1 v-else>{{ device_id }}</h1>
</template>

<style scoped>

</style>
