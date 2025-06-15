<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Page|The Fighters Club</title>
    <link rel="stylesheet" href="./styles/homepage.css">
</head>
<body>

    <div class="video-container">
        <button onclick="goBack()" class="exit-button">✕ Exit</button>
        <video id="videoPlayer" controls autoplay></video>
    </div>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const videoSrc = urlParams.get('src');
        document.getElementById('videoPlayer').src = `./videos/${videoSrc}`;
    </script>


    <script src="./script/test.js"></script>
</body>
</html>