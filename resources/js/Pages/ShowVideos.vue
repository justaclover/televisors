<script setup>
    import {ref} from 'vue'
    import {router} from "@inertiajs/vue3";
    import { usePoll } from '@inertiajs/vue3'
    import { onErrorCaptured } from "vue";


    const props = defineProps({
        videos: Array
    })

    usePoll(2000, {
        onStart() {
            console.log('Polling request started')
        },
        onFinish() {
            console.log('Polling request finished')
            console.log(props.videos)
        }
    }, { keepAlive: true })

    // console.log(props.videos)
    const videoPlayer = ref(null)

    let videoIndex = 0
    var videoUrl = props.videos[videoIndex].original_url

    console.log(props.videos[videoIndex].original_url)

    function changeVideo(){
        try {
            videoIndex = (videoIndex + 1) % props.videos.length;
            console.log(videoIndex)
            videoUrl = props.videos[videoIndex].original_url;
            videoPlayer.value.src = videoUrl
            console.log(videoPlayer.value.src)
            videoPlayer.value.play()
        }
        catch (e) {
            router.visit('/')
        }
    }

    onErrorCaptured((NotSupportedError) => {
        changeVideo()
    })

</script>

<template>
    <video preload="auto" autoplay ref="videoPlayer" muted v-on:ended="changeVideo" class="w-full h-full">
        <source :src="videoUrl">
    </video>
</template>
