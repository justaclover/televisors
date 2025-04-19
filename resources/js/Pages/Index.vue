<script setup>
import {usePoll} from '@inertiajs/vue3'
import {computed, reactive, onMounted, ref, onErrorCaptured} from 'vue'
import { router } from '@inertiajs/vue3'
import 'video.js/dist/video-js.css'
import {useAsyncState} from "@vueuse/core";

const props = defineProps({
    device_id: Number,
    muted: Boolean,
    videos: Array
    // readyForVideos: Boolean
});

onMounted(() => {
    const expires = (new Date(Date.now()+ 86400*10000000)).toUTCString();
    document.cookie = `device_id=${props.device_id}; expires=` + expires;
});

// usePoll(2000);
    usePoll(4000, {
        onFinish() {
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

// setInterval(() => {
//     axios.get('/setping/' + props.device_id.toString())
//         .then(response => {
//             console.log(response.data)
//         })
// }, 300000)

const {} = useAsyncState(
    setInterval(() => {
        axios.get('/setping/' + props.device_id.toString())
            .then(response => {
                console.log(response.data)
            })
    }, 3000),
    {}
)

</script>

<template>
    <section>
        <div v-if="props.videos.length === 0" class="empty">
            <h1>{{props.device_id}}</h1>
        </div>

        <div v-else class="video-container">
            <!--<video-player src="http://127.0.0.1:8000/storage/1/WIN_20250131_16_44_39_Pro.mp4" autoplay preload="auto" muted/>-->
            <video v-if="muted" :src="videoUrl" preload="auto" muted autoplay ref="videoPlayer" v-on:ended="changeVideo" :style="videoStyle"/>
            <video v-else :src="videoUrl" preload="auto" autoplay ref="videoPlayer" v-on:ended="changeVideo" :style="videoStyle"/>
        </div>
    </section>
</template>

<style scoped>
    .empty {
        display: flex;
        justify-content: center;
        align-content: center;
        align-self: center;
        margin-top: 8%;
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

    video-player {
        width: 100%;
        height: 100vh;
        object-fit: contain;
    }

</style>
