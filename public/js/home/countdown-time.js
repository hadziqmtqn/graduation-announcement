document.addEventListener('DOMContentLoaded', function () {
    const dateDiv = document.querySelector('div[data-start-date][data-end-date]');
    if (!dateDiv) return;

    const startDateStr = dateDiv.getAttribute('data-start-date');
    const endDateStr = dateDiv.getAttribute('data-end-date');
    const countdownTitle = document.getElementById('countdown-title');
    const countdownDiv = document.getElementById('countdown-timer');
    const alertDiv = countdownTitle.closest('.alert');
    if (!countdownTitle || !countdownDiv || !alertDiv) return;

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

    function updateCountdown() {
        const now = new Date();
        const startDate = new Date(startDateStr.replace(/-/g, '/'));
        const endDate = new Date(endDateStr.replace(/-/g, '/'));
        // Reset display
        countdownDiv.style.display = "block";
        if (now < startDate) {
            countdownTitle.textContent = "Pengumuman akan dimulai dalam:";
            countdownDiv.innerHTML = formatDuration(startDate - now);
            alertDiv.classList.remove('alert-primary');
            alertDiv.classList.add('alert-danger');
        } else if (now >= startDate && now <= endDate) {
            countdownTitle.textContent = "Silahkan masukkan Nomor Ujian";
            countdownDiv.innerHTML = "";
            countdownDiv.style.display = "none";
            alertDiv.classList.remove('alert-danger');
            alertDiv.classList.add('alert-primary');
        } else {
            countdownTitle.textContent = "Pengumuman telah berakhir.";
            countdownDiv.innerHTML = "";
            countdownDiv.style.display = "none";
            alertDiv.classList.remove('alert-primary');
            alertDiv.classList.add('alert-danger');
        }
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);
});