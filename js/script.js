
let currentIndex = 0;

const audio = document.getElementById("audioEl");


function formatTime(seconds) {

    if (isNaN(seconds)) return "0:00";

    let mins = Math.floor(seconds / 60);
    let secs = Math.floor(seconds % 60);

    if (secs < 10) {
        secs = "0" + secs;
    }

    return mins + ":" + secs;
}


function loadSong(card, index) {

    currentIndex = index;

    const title = card.dataset.title;
    const artist = card.dataset.artist;
    const cover = card.dataset.cover;
    const audioFile = card.dataset.audio;

    const heroTitle = document.getElementById("hero-title");
    const heroImg = document.getElementById("hero-img");

    if (heroTitle) heroTitle.textContent = title;
    if (heroImg) heroImg.src = cover;

    document.getElementById("player-title").textContent = title;
    document.getElementById("player-artist").textContent = artist;
    document.getElementById("player-thumb").src = cover;

    audio.src = audioFile;
    audio.play();
}

// NEXT SONG

function nextSong() {

    const cards = document.querySelectorAll(".song-card");

    if (cards.length === 0) return;

    currentIndex++;

    if (currentIndex >= cards.length) {
        currentIndex = 0;
    }

    loadSong(cards[currentIndex], currentIndex);
}


// PREVIOUS SONG


function prevSong() {

    const cards = document.querySelectorAll(".song-card");

    if (cards.length === 0) return;

    currentIndex--;

    if (currentIndex < 0) {
        currentIndex = cards.length - 1;
    }

    loadSong(cards[currentIndex], currentIndex);
}


// SIDEBAR


function openSidebar() {

    document.getElementById("sidebar").classList.add("open");
    document.getElementById("overlay").classList.add("show");
}

function closeSidebar() {

    document.getElementById("sidebar").classList.remove("open");
    document.getElementById("overlay").classList.remove("show");
}


document.addEventListener("DOMContentLoaded", function () {

    // Sidebar
    const hamburgerBtn = document.getElementById("hamburgerBtn");
    const sidebarClose = document.getElementById("sidebarClose");
    const overlay = document.getElementById("overlay");

    if (hamburgerBtn) {
        hamburgerBtn.addEventListener("click", openSidebar);
    }

    if (sidebarClose) {
        sidebarClose.addEventListener("click", closeSidebar);
    }

    if (overlay) {
        overlay.addEventListener("click", closeSidebar);
    }

    // Song Cards
    const cards = document.querySelectorAll(".song-card");

    cards.forEach(function (card, index) {

        card.addEventListener("click", function () {

            loadSong(card, index);

        });

    });

    // Playlist Items
    const playlistItems = document.querySelectorAll(".playlist-item");

    playlistItems.forEach(function (item, index) {

        item.addEventListener("click", function () {

            const cards = document.querySelectorAll(".song-card");

            if (cards[index]) {
                loadSong(cards[index], index);
            }

        });

    });

    // Hero Play Button
    const heroPlayBtn = document.getElementById("heroPlayBtn");

    if (heroPlayBtn) {

        heroPlayBtn.addEventListener("click", function () {

            const cards = document.querySelectorAll(".song-card");

            if (cards[currentIndex]) {
                loadSong(cards[currentIndex], currentIndex);
            }

        });

    }

    // Play / Pause
    const playIcon = document.getElementById("playIcon");
    audio.addEventListener("play", function () {

        playIcon.innerHTML = `
        <rect x="6" y="4" width="4" height="16"></rect>
        <rect x="14" y="4" width="4" height="16"></rect>
    `;

    });
    audio.addEventListener("pause", function () {

        playIcon.innerHTML = `
        <polygon points="5 3 19 12 5 21"></polygon>
    `;

    });
    const playBtn = document.getElementById("playMainBtn");

    if (playBtn) {

        playBtn.addEventListener("click", function () {

            if (audio.paused) {
                audio.play();
            } else {
                audio.pause();
            }

        });

    }

    // Next
    const nextBtn = document.getElementById("nextBtn");

    if (nextBtn) {
        nextBtn.addEventListener("click", nextSong);
    }

    // Previous
    const prevBtn = document.getElementById("prevBtn");

    if (prevBtn) {
        prevBtn.addEventListener("click", prevSong);
    }

    //volume
   const muteBtn = document.getElementById("muteBtn");
const volSlider = document.getElementById("volSlider");

let lastVolume = 100;

muteBtn.addEventListener("click", function () {

    if (audio.muted || audio.volume === 0) {

        audio.muted = false;
        audio.volume = lastVolume / 100;
        volSlider.value = lastVolume;

    } else {

        lastVolume = volSlider.value;
        audio.muted = true;
        volSlider.value = 0;
        audio.volume = 0;

    }

});

volSlider.addEventListener("input", function () {

    audio.volume = this.value / 100;

    if (this.value == 0) {
        audio.muted = true;
    } else {
        audio.muted = false;
        lastVolume = this.value;
    }

});
    // Progress Click
    const progressBar = document.getElementById("progressBar");

    if (progressBar) {

        progressBar.addEventListener("click", function (e) {

            if (!audio.duration) return;

            const rect = this.getBoundingClientRect();

            const percent =
                (e.clientX - rect.left) / rect.width;

            audio.currentTime =
                percent * audio.duration;

        });

    }

    // Songs Slider
    const songsLeft = document.getElementById("songsLeft");
    const songsRight = document.getElementById("songsRight");
    const songsRow = document.getElementById("songsRow");

    if (songsLeft && songsRow) {

        songsLeft.addEventListener("click", function () {

            songsRow.scrollBy({
                left: -300,
                behavior: "smooth"
            });

        });

    }

    if (songsRight && songsRow) {

        songsRight.addEventListener("click", function () {

            songsRow.scrollBy({
                left: 300,
                behavior: "smooth"
            });

        });

    }

    // Artists Slider
    const artistsLeft = document.getElementById("artistsLeft");
    const artistsRight = document.getElementById("artistsRight");
    const artistsRow = document.getElementById("artistsRow");

    if (artistsLeft && artistsRow) {

        artistsLeft.addEventListener("click", function () {

            artistsRow.scrollBy({
                left: -300,
                behavior: "smooth"
            });

        });

    }

    if (artistsRight && artistsRow) {

        artistsRight.addEventListener("click", function () {

            artistsRow.scrollBy({
                left: 300,
                behavior: "smooth"
            });

        });

    }

    // First Song Load
    if (cards.length > 0) {

        const firstCard = cards[0];

        const heroTitle = document.getElementById("hero-title");
        const heroImg = document.getElementById("hero-img");

        if (heroTitle) {
            heroTitle.textContent = firstCard.dataset.title;
        }

        if (heroImg) {
            heroImg.src = firstCard.dataset.cover;
        }

        document.getElementById("player-title").textContent =
            firstCard.dataset.title;

        document.getElementById("player-artist").textContent =
            firstCard.dataset.artist;

        document.getElementById("player-thumb").src =
            firstCard.dataset.cover;

        const audiofiles = audio.src = firstCard.dataset.audio;


    }

});



// Auto Next Song
audio.addEventListener("ended", function () {

    nextSong();

});

// Progress Update
audio.addEventListener("timeupdate", function () {

    if (!audio.duration) return;

    const percent =
        (audio.currentTime / audio.duration) * 100;

    document.getElementById("progressFill").style.width =
        percent + "%";

    document.getElementById("curTime").textContent =
        formatTime(audio.currentTime);

});

// Duration Update
audio.addEventListener("loadedmetadata", function () {

    document.getElementById("durTime").textContent =
        formatTime(audio.duration);

});

