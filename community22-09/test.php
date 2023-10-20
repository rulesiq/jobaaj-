<style>
    .vjs {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--black,#000);
        color: var(--white,#fff);
        overflow: hidden;
        width: 30rem;
        height: 30rem;
        max-width: 100%;
        padding-top: 0;
        position: relative; /* Added position: relative */
    }

    video {
        position: absolute; /* Added position: absolute */
        width: 100%;
        height: 30rem;
        top: 0;
        z-index: 111;
        left: 0;
    }

    .bg {
        position: absolute; /* Added position: absolute */
        filter: blur(5px);
        opacity: .9;
        background-position: 50% 50%;
        background-size: cover;
        background-repeat: no-repeat;
        transform: scale(1.1);
        width: 100%;
        height: 100%;
        top: 0;
        z-index: 110; /* Lower z-index than video to make it appear behind */
    }
</style>
<br />

<div class="vjs">
    <div class="bg" style="background-image:url('https://community.jobaajlearnings.com/data/1688457119thumb_vid_1.jpg');"></div>
    <video controls muted="muted">
        <source src="https://community.jobaajlearnings.com/data/1688457119vid_1.mp4" type="video/mp4">
    </video>
</div>