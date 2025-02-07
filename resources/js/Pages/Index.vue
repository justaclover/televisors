<script setup>
import {Head, usePage} from '@inertiajs/vue3'
import {computed, reactive} from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    readyForVideos: Boolean
})

let device_id

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
        // axios.get('/devices/' + device_id.toString() + '/playlist')
        //     .then(response => {
        //         console.log(response)
        //     })
        if (!props.readyForVideos) {
            router.get('/devices/' + device_id.toString() + '/playlist')
        }

    }
}

</script>

<template>
    <h1>{{ device_id }}</h1>
</template>

<style scoped>

</style>
