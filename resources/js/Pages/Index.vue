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
    }
    else {
        device_id = localStorage.getItem('device_id')
        console.log(device_id)
        getVideos(device_id)
    }


}

function getVideos(id) {
    let url = '/devices/' + id.toString() + '/playlist'
    axios(url)
        .then(response => {
            router.reload(playVideos(response.data['ready']))
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
