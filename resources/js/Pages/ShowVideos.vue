<script setup>
    import {ref} from 'vue'
    const props = defineProps({
        videos: Array
    })

    // console.log(props.videos)
    const videoPlayer = ref(null)

    let videoIndex = 0
    var videoUrl = props.videos[videoIndex].original_url

    console.log(props.videos[videoIndex].original_url)

    function changeVideo(){
        videoIndex = (videoIndex + 1) % props.videos.length;
        console.log(videoIndex)
        videoUrl = props.videos[videoIndex].original_url;
        videoPlayer.value.src = videoUrl
        console.log(videoPlayer.value.src)
        videoPlayer.value.play()
    }

</script>

<template>
    <video preload="auto" autoplay ref="videoPlayer" muted v-on:ended="changeVideo">
        <source :src="videoUrl">
    </video>
</template>
