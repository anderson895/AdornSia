  
const getDataAnalytics = () => {
    $.ajax({
      url: 'backend/end-points/getDataAnalytics.php', 
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        //   console.log(response); 
          let userCount = response.userCount;
          let totalSales = response.totalSales;
          let pendingCount = response.pendingCount;
        
            $('.count_users').text(userCount).show(); 
            $('.totalSales').text('₱' + totalSales.toLocaleString()).show();

            $('.numOrders').text(pendingCount).show(); 

            
      },
    });
  };
  
  getDataAnalytics();
  
  setInterval(() => {
    getDataAnalytics();
  }, 1000)
  