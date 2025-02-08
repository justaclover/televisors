<script setup>
    import {ref} from 'vue'
    const props = defineProps({
        videos: Array
    })

    // console.log(props.videos)
    const videoPlayer = ref(null)

    let videoIndex = 0

    console.log(props.videos[videoIndex].original_url)

    videoPlayer.src = props.videos[videoIndex].original_url;
    videoPlayer.onended = function(){
        videoIndex = (videoIndex + 1) % props.videos.length;
        videoPlayer.src = props.videos[videoIndex].original_url;
    }

</script>

<template>
    <video preload="auto" autoplay ref="videoPlayer" muted src="">
    </video>
</template>
