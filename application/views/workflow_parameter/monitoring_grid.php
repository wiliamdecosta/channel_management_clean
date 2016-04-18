<table  id="grid-basic" class="table table-striped table-bordered table-hover">
    <thead>
      <tr>
        <?php 
            foreach ($header as $rowH) {
                echo "<th data-column-id='$rowH' >$rowH</th>";
            }
        ?>
      </tr>
    </thead>
    <tbody> 
        <?php 
            for ($i=0; $i<count($data); $i++){
                echo "<tr>";
                foreach ($data[$i] as $rowD) {
                    echo "<th>$rowD</th>";                    
                }
                echo "</tr>";
            }    
            // exit;
        ?>
    </tbody>
</table>

<script>
    jQuery(function($) {
        // $("#grid-basic").bootgrid();
    });

    // $("#grid-basic").dataTable({
    //         "ordering": false,
    //         "info":     true,
    //         "bFilter" : false,               
    //         "bLengthChange": false
    //     });
</script>
