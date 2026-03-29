        </div> <!-- End Main Content col -->
    </div> <!-- End row -->
</div> <!-- End container-fluid -->
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    // Simple script to set active class on sidebar based on current URL
    const currentLocation = location.href;
    const menuItem = document.querySelectorAll('.sidebar a');
    const menuLength = menuItem.length;
    for (let i = 0; i < menuLength; i++) {
        // Just checking if href matches end of current location to accommodate query params and differences
        if (currentLocation.includes(menuItem[i].getAttribute('href')) && menuItem[i].getAttribute('href') !== '#') {
            menuItem[i].classList.add("active");
        }
    }
</script>
</body>
</html>
