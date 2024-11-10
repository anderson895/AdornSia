 <!-- Main Content goes here -->
 </main>
</div>

<!-- Optional: Material Icons CDN for icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>


<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script src="js/daily_sales.js"></script>
<script src="js/weekly_sales.js"></script>
<script src="js/monthly_sales.js"></script>



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