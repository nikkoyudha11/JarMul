<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aplikasi Radio Streaming</title>
    <link rel="stylesheet" href="radio.css" />
</head>

<body>
    <h1>Aplikasi Radio Streaming</h1>

    <p id="radioSelect">Stasiun Saat Ini : Suara_Surabaya</p>
    <!-- <select id="radioSelect">
      <option value="Suara_Surabaya">Suara Surabaya</option>
      <option value="Zeno_FM">Zeno FM</option>
      <option value="Delta_FM">Delta FM</option>
      <option value="Prambors_FM">Prambors FM</option>
      <option value="I_Radio_Jakarta">I-Radio Jakarta</option>
    </select> -->
    <audio id="radioPlayer" controls>
        <source id="radioSource" src="" type="audio/mpeg" />
    </audio>
    <div class="button">
        <button id="startButton">Start</button>
        <button id="pauseButton">Pause</button>
        <button id="nextButton">Next</button>
        <button id="backButton">Back</button>
    </div>
    <label for="newChannel">Nama Channel Baru:</label>
    <input type="text" id="newChannel" />
    <label for="streamingLink">Link Streaming:</label>
    <input type="text" id="streamingLink" />
    <button id="addChannelButton">Tambah Channel Baru</button>

    <script>
        const radioPlayer = document.getElementById("radioPlayer");
        const radioSelect = document.getElementById("radioSelect");
        const radioSource = document.getElementById("radioSource");
        const startButton = document.getElementById("startButton");
        const pauseButton = document.getElementById("pauseButton");
        const nextButton = document.getElementById("nextButton");
        const backButton = document.getElementById("backButton");
        const addChannelButton = document.getElementById("addChannelButton");
        const newChannelInput = document.getElementById("newChannel");
        const streamingLinkInput = document.getElementById("streamingLink");


        const radioStreams = {
            Suara_Surabaya: "https://c5.siar.us/proxy/ssfm/stream",
            Zeno_FM:
                "https://stream-154.zeno.fm/av6xzace6ehvv?zs=38TJvYxaRPuRKElp0w8UdA",
            Delta_FM: "https://stream.cloudmu.id/listen/delta_fm/stream?icy=http",
            Prambors_FM:
                "https://22243.live.streamtheworld.com/PRAMBORS_FM_SC?dist=pramborsweb&pname=tdwidgets",
            I_Radio_Jakarta:
                "https://n03.radiojar.com/4ywdgup3bnzuv?rj-tok=AAABi2b2p4gA_GfD3clkUolvyg&rj-ttl=5",
        };

        let StasiunSaatIni = "Suara_Surabaya"; // Set station awal

        startButton.addEventListener("click", () => {
            radioSource.src = radioStreams[StasiunSaatIni];
            radioSelect.value = StasiunSaatIni;
            radioPlayer.load();
            radioPlayer.play();
            console.log("Saat ini memainkan " + StasiunSaatIni);
            radioSelect.textContent = "Stasiun Saat Ini : " + StasiunSaatIni;
        });

        pauseButton.addEventListener("click", () => {
            radioPlayer.pause();
        });

        nextButton.addEventListener("click", () => {
            const stationKeys = Object.keys(radioStreams);
            const currentIndex = stationKeys.indexOf(StasiunSaatIni);
            StasiunSaatIni = stationKeys[(currentIndex + 1) % stationKeys.length]; // Perpindahan siklis ke stasiun berikutnya
            radioSource.src = radioStreams[StasiunSaatIni];
            radioSelect.textContent = "Stasiun Saat Ini: " + StasiunSaatIni;
            radioPlayer.load();
            radioPlayer.play();
            console.log("Berpindah Ke " + StasiunSaatIni);
        });

        backButton.addEventListener("click", () => {
            const stationKeys = Object.keys(radioStreams);
            const currentIndex = stationKeys.indexOf(StasiunSaatIni);
            const newIndex = (currentIndex - 1 + stationKeys.length) % stationKeys.length; // Perpindahan siklis ke stasiun sebelumnya
            StasiunSaatIni = stationKeys[newIndex];
            radioSource.src = radioStreams[StasiunSaatIni];
            radioSelect.textContent = "Stasiun Saat Ini: " + StasiunSaatIni;
            radioPlayer.load();
            radioPlayer.play();
            console.log("Berpindah Ke " + StasiunSaatIni);
        });
        addChannelButton.addEventListener("click", () => {
            const newChannelName = newChannelInput.value;
            const newStreamingLink = streamingLinkInput.value;

            if (newChannelName && newStreamingLink) {
                // Kirim data ke server
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "add_channel.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Tanggapi dari server (biasanya berupa konfirmasi penyimpanan)
                        console.log(xhr.responseText);
                        // Clear input fields
                        newChannelInput.value = "";
                        streamingLinkInput.value = "";
                        // Perbarui tampilan stasiun radio jika diperlukan
                    }
                };
                xhr.send(`namaStasiun=${newChannelName}&urlStreaming=${newStreamingLink}`);
            } else {
                alert("Nama channel dan link streaming harus diisi.");
            }
        });
        

    </script>
</body>

</html>