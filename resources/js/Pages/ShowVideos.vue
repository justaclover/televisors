<script setup>
    const props = defineProps({
        videos: Array
    })

    setup()

    let video_url_array = []

    function setup() {
        console.log(props.videos)
        let videoIndex = 0;
        const videoPlayer = document.getElementById('videoPlayer')
        console.log(videoPlayer)

        videoPlayer.src = props.videos[videoIndex].original_url;
        videoPlayer.onended = function(){
            videoIndex = (videoIndex + 1) % props.videos.length;
            videoPlayer.src = props.videos[videoIndex].original_url;
        }
    }

</script>

<template>
    <video preload="auto" autoplay>
        <source id="videoPlayer" src="">
    </video>
</template>
