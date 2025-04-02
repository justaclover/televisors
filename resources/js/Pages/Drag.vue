<script setup>
import {ref} from 'vue'
import draggable from 'vuedraggable'

const props = defineProps({
    playlists: Array,
    devices: Array
})

console.log(props.playlists)
console.log(props.devices)

const devicesDragArray = ref(props.devices)
const playlistsDragArray = ref(props.playlists)
</script>

<template>
    <div class="flex flex-row gap-20">
        <draggable
            v-model="devicesDragArray"
            group="deviceDrag"
            item-key="id">
            <template #item="{element}">
                <div>{{element.id}}</div>
            </template>
        </draggable>

        <div v-for="playlist in playlistsDragArray">
            <draggable
                v-model="playlist.devices_array"
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
