</div>

<script>
    // Script pour activer le lien cliqué et désactiver les autres
    document.addEventListener("DOMContentLoaded", function () {
        let links = document.querySelectorAll(".nav-link");
        
        links.forEach(link => {
            link.addEventListener("click", function () {
                links.forEach(l => l.classList.remove("active")); // Retirer la classe active de tous les liens
                this.classList.add("active"); // Ajouter la classe active au lien cliqué
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>