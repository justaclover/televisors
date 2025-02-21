<script setup>
import {Head, usePage, usePoll} from '@inertiajs/vue3'
import {computed, reactive, onMounted, ref, onErrorCaptured} from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    device_id: Number,
    videos: Array
    // readyForVideos: Boolean
});

onMounted(() => {
    document.cookie = `device_id=${props.device_id}; max-age=3600`;
});

usePoll(2000);
    // usePoll(2000, {
    //     onStart() {
    //         console.log('Polling request started')
    //     },
    //     onFinish() {
    //         console.log('Polling request finished')
    //         console.log(props.videos)
    //     }
    // }, { keepAlive: true })

    // console.log(props.videos)
    const videoPlayer = ref(null);

    const videoIndex = ref(0);


    const videoUrl = computed(() => `/file/${props.videos[videoIndex.value].uuid}`);

    // console.log(props.videos[videoIndex.value].original_url);

    function changeVideo(){
        try {
            videoIndex.value = (videoIndex.value + 1) % props.videos.length;
            // console.log(videoIndex);
            // videoUrl = props.videos[videoIndex].original_url;
            // videoPlayer.value.src = videoUrl;
            // console.log(videoPlayer.value.src);
            videoPlayer.value.play();
        }
        catch (e) {
            // router.visit('/');
        }
    }

    onErrorCaptured((NotSupportedError) => {
        changeVideo();
    })

</script>

<template>
    <div v-if="props.videos.length == 0" class="empty">
        <h1>{{props.device_id}}</h1>
    </div>

    
    <video v-else :src="videoUrl" preload="auto" autoplay ref="videoPlayer" muted v-on:ended="changeVideo" class="w-full h-full" />
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
