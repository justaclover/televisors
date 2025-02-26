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
    document.cookie = `device_id=${props.device_id}`;
});

// usePoll(2000);
    usePoll(2000, {
        onFinish() {
            if (document.cookie.at((document.cookie.split('=')).indexOf('device_id') + 1) != props.device_id.toString()) {
                document.cookie = `device_id=${props.device_id}`;
            }
            console.log('Polling request finished')
            console.log(props.videos)
        }
    }, { keepAlive: true })

    // console.log(props.videos)
    const videoPlayer = ref(null);

    const videoIndex = ref(0);
    const videoUrl = computed(() => `/file/${props.videos[videoIndex.value].uuid}`);

    const videoStyle = ref({
        width: '100%',
        height: '100vh',
        objectFit: 'contain',
    });

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
            router.visit('/');
        }
    }

    onErrorCaptured((NotSupportedError) => {
        changeVideo();
    })

</script>

<template>
    <section>
        <div v-if="props.videos.length == 0" class="empty">
            <h1>{{props.device_id}}</h1>
        </div>

        <div v-else class="video-container">
            <video :src="videoUrl" preload="auto" autoplay ref="videoPlayer" muted v-on:ended="changeVideo" :style="videoStyle"/>
        </div>
    </section>
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

    section {
        display: flex;
        align-content: center;
        justify-content: center;
    }

</style>
