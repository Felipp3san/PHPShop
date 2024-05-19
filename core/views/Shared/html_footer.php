</div>
<footer class="footer py-3 bg-dark text-light text-center">
  <div class="container-fluid">
    <span>© <?= date("Y") . " " . APP_NAME ?>. Felippe de Almeida Santana</span>
  </div>
</footer>
<script src="assets/js/bootstrap/bootstrap.bundle.js"></script>
<script src="assets/js/app.js"></script>
<script>
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>

</body>

</html>