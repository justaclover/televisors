<script setup>
import {Head, usePage} from '@inertiajs/vue3'
import {computed, reactive} from 'vue'
import { router } from '@inertiajs/vue3'

let device_id

checkForId()

function checkForId() {
    if (localStorage.getItem('device_id') === null) {
        axios.get('/add-device')
            .then(response => {
                localStorage.setItem('device_id', response.data['device_id'].toString())
                console.log(response.data['device_id'])
                //device_id = response.data['device_id']
                router.reload(checkForId())
            })
            .catch(error => {
                alert(error)
            })
    }
    device_id = localStorage.getItem('device_id')

}
</script>

<template>
    <h1>{{ device_id }}</h1>
</template>

<style scoped>

</style>
