<script setup>
    import {ref} from 'vue'
    import {router} from "@inertiajs/vue3";
    const props = defineProps({
        videos: Array
    })

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

</script>

<template>
    <video preload="auto" autoplay ref="videoPlayer" muted v-on:ended="changeVideo">
        <source :src="videoUrl">
    </video>
</template>
