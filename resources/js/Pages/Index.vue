<script setup>
import {Head, usePage, usePoll} from '@inertiajs/vue3'
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
        console.log(props.readyForVideos)

        //нужно для того, чтобы если плейлист не назначен или пустой, отображался id
        if (!props.readyForVideos) {
            router.get('/devices/' + device_id.toString() + '/playlist')
        }
        else {
            usePoll(2000, {
                onStart() {
                    console.log('Polling request started')
                },
                onFinish() {
                    console.log('Polling request finished')
                }
            }, { keepAlive: true })
        }

    }
}

</script>

<template>
    <div class="empty">
        <h1>{{device_id}}</h1>
    </div>
</template>

<style scoped>
    .empty {
        display: flex;
        justify-content: center;
        align-content: center;
        align-self: center;
    }

    .empty h1 {
        font-size: 256px;
        font-weight: bold;
    }
</style>
