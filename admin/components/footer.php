 <!-- Main Content goes here -->
 </main>
</div>











<!-- Optional: Material Icons CDN for icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script src="../node_modules/apexcharts/dist/apexcharts.js"></script>
<script src="js/datatable.js"></script>
<script src="js/app.js"></script>
<script src="js/modal.js"></script>



<script>
  
  
  const overlay = document.getElementById('overlay');


  menuButton.addEventListener('click', () => {
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
  });



  overlay.addEventListener('click', () => {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
  });
</script>
</body>
</html>