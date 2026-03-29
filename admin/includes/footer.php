        </div> <!-- End Main Content col -->
    </div> <!-- End row -->
</div> <!-- End container-fluid -->
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    // Highlight active sidebar navigation
    const currentLocation = location.href;
    const menuLinks = document.querySelectorAll('.sidebar a.nav-link');
    menuLinks.forEach((link) => {
        if (currentLocation.includes(link.getAttribute('href')) && link.getAttribute('href') !== '#') {
            link.classList.add("active");
        }
    });
</script>
</body>
</html>
