<div class="table-responsive" >
    <table class="table datanew">
        <thead>
            
            <tr>
                <th >
                    <label hidden class="checkboxs">
                        <input hidden type="checkbox" id="selectAll">
                        <span class="checkmarks"></span>
                    </label>
                </th>
                <th >Address code</th>
                <th >Address</th>
                <th >Shipping</th>
                <th >Rider Assign</th>
                <th >Status</th>
                <!--<th >Cod</th>-->
                <!--<th >Pay first</th>-->
                <th >Action</th>
            </tr>
        </thead>
        
        <tbody id="content">
          
            <!-- JavaScript will populate rows here -->
        </tbody>
    </table>
</div>
<?php include "delivery_place/controller/query_address.php"; ?>