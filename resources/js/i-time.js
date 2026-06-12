// techne.online time corner
d = new Date()

// UTC time
utc_hrs = String(d.getUTCHours()).padStart(2,'0');
utc_min = String(d.getUTCMinutes()).padStart(2,'0');
display_utc = `${utc_hrs}:${utc_min}Z`;
document.getElementById("z-time").innerText = display_utc;

// Swatch .beat internet time
utc_sec_total = d.getUTCHours() * 3600 + d.getUTCMinutes() * 60 + d.getUTCSeconds();
bmt_sec_total = (utc_sec_total + 3600) % 86400; // convert to BMT (UTC+1) and wrap into 0..86399
beat = Math.floor(bmt_sec_total / 86.4) % 1000;
display_beat = `@${String(beat).padStart(3,'0')}`
document.getElementById("i-time").innerText = display_beat;