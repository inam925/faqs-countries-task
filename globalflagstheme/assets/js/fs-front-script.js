if(localStorage.getItem('gft_preferred_theme') == 'dark') {
  setDarkMode(true)
}

function setDarkMode(isDark) {
  let gft_global_dark_button = document.getElementById("gft-dark-button");
  let gft_global_light_button = document.getElementById("gft-light-button");

  if(isDark) {
   gft_global_light_button.style.display = "block"
    gft_global_dark_button.style.display = "none"
    localStorage.setItem('gft_preferred_theme', 'dark');
  } else {
 gft_global_light_button.style.display = "none"
  gft_global_dark_button.style.display = "block"
  localStorage.removeItem('gft_preferred_theme');
}

document.body.classList.toggle("darkmode");
}
