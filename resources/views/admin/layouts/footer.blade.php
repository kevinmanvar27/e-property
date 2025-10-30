<footer class="page-footer">
    <p class="mb-0 footer-text"></p>
</footer>
<script>
fetch("/api/settings")
    .then((res) => res.json())
    .then((data) => {
        const footerText = data.footer_text || "";
        document.querySelector(".footer-text").innerText = footerText;
    })
    .catch((err) => console.error("Error loading settings:", err));
</script>