<script setup>
import {ref} from 'vue'
import draggable from 'vuedraggable'

const props = defineProps({
    playlists: Array,
    devices: Array
})

console.log(props.playlists)
</script>

<template>
    <div class="flex flex-row gap-20">
        <draggable
            v-model="devices"
            group="deviceDrag"
            item-key="id">
            <template #item="{element}">
                <div>{{element.id}}</div>
            </template>
        </draggable>

        <div v-for="playlist in playlists">
            <draggable
                v-model="playlist.devices_id"
                group="deviceDrag"
                item-key="id">
                <template #item="{element}">
                    <div>{{element.id}}</div>
                </template>
            </draggable>
        </div>
    </div>
</template>

<style scoped>

</style>
