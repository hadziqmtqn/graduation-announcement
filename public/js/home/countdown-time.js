document.addEventListener('DOMContentLoaded', function () {
    const dateDiv = document.querySelector('div[data-start-date][data-end-date]');
    if (!dateDiv) return;

    const startDateStr = dateDiv.getAttribute('data-start-date');
    const endDateStr = dateDiv.getAttribute('data-end-date');
    const countdownTitle = document.getElementById('countdown-title');
    const countdownDiv = document.getElementById('countdown-timer');
    if (!countdownTitle || !countdownDiv) return;

    function pad(n) { return n < 10 ? '0' + n : n; }
    function formatDuration(ms) {
        if (ms < 0) ms = 0;
        let totalSeconds = Math.floor(ms / 1000);
        const days = Math.floor(totalSeconds / (3600 * 24));
        totalSeconds %= 3600 * 24;
        const hours = Math.floor(totalSeconds / 3600);
        totalSeconds %= 3600;
        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;
        return (
            '<span class="badge bg-primary mx-1" style="font-size: large">' + pad(days) + ' Hari</span>' +
            '<span class="badge bg-info mx-1" style="font-size: large">' + pad(hours) + ' Jam</span>' +
            '<span class="badge bg-warning mx-1" style="font-size: large">' + pad(minutes) + ' Menit</span>' +
            '<span class="badge bg-danger mx-1" style="font-size: large">' + pad(seconds) + ' Detik</span>'
        );
    }

    function setTitle(text, colorClass) {
        countdownTitle.textContent = text;
        countdownTitle.className = 'text-center display-6 fw-semibold ' + colorClass;
    }

    function updateCountdown() {
        const now = new Date();
        const startDate = new Date(startDateStr.replace(/-/g, '/'));
        const endDate = new Date(endDateStr.replace(/-/g, '/'));
        countdownDiv.style.display = "block";
        if (now < startDate) {
            setTitle("Pengumuman akan dimulai dalam:", "text-danger");
            countdownDiv.innerHTML = formatDuration(startDate - now);
        } else if (now >= startDate && now <= endDate) {
            setTitle("Masukkan Nomor Ujian untuk melihat hasil kelulusan", "text-primary");
            countdownDiv.innerHTML = "";
            countdownDiv.style.display = "none";
        } else {
            setTitle("Pengumuman telah berakhir.", "text-secondary");
            countdownDiv.innerHTML = "";
            countdownDiv.style.display = "none";
        }
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);
});