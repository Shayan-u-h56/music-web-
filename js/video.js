//vidoe
document.addEventListener('DOMContentLoaded', function() {

  var videoOverlay  = document.getElementById('videoOverlay');
  var videoPlayer   = document.getElementById('videoPlayer');
  var videoSource   = document.getElementById('videoSource');
  var videoTitle    = document.getElementById('videoTitle');
  var videoCloseBtn = document.getElementById('videoCloseBtn');

  // Video card click — popup open karo
  var videoCards = document.querySelectorAll('.video-card');
  videoCards.forEach(function(card) {
    card.addEventListener('click', function() {
      var src   = this.getAttribute('data-video');
      var title = this.getAttribute('data-title');

      videoSource.src  = src;
      videoTitle.textContent = title;
      videoPlayer.load();
      videoPlayer.play();
      videoOverlay.classList.add('show');
    });
  });

  // Sidebar items click
  var sidebarItems = document.querySelectorAll('.sidebar-queue .playlist-item');
  sidebarItems.forEach(function(item) {
    item.addEventListener('click', function() {
      var src   = this.getAttribute('data-video');
      var title = this.getAttribute('data-title');

      videoSource.src = src;
      videoTitle.textContent = title;
      videoPlayer.load();
      videoPlayer.play();
      videoOverlay.classList.add('show');
    });
  });

  // Close button
  videoCloseBtn.addEventListener('click', function() {
    videoPlayer.pause();
    videoOverlay.classList.remove('show');
  });

  // Overlay background click se close
  videoOverlay.addEventListener('click', function(e) {
    if (e.target === videoOverlay) {
      videoPlayer.pause();
      videoOverlay.classList.remove('show');
    }
  });

  // Sidebar hamburger
  document.getElementById('hamburgerBtn').addEventListener('click', function() {
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('overlay').classList.add('show');
  });

  document.getElementById('sidebarClose').addEventListener('click', function() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('overlay').classList.remove('show');
  });

  document.getElementById('overlay').addEventListener('click', function() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('overlay').classList.remove('show');
  });

});