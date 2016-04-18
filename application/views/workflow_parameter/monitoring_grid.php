<table  id="grid-basic" class="table table-striped table-bordered table-hover">
    <thead>
      <tr>
        <?php 
            $i = 0;
            foreach ($header as $rowH) {
                $dt = "data".$i;
                if($i == 0){
                    echo "<th data-column-id=$dt  data-visible='false'>".$rowH."</th>";
                }else{
                    echo "<th data-column-id=$dt >".$rowH."</th>";
                }
                $i++;
            }
        ?>
      </tr>
    </thead>
</table>

<script>
    jQuery(function($) {
        $("#grid-basic").bootgrid({
            rowCount:[5,10],
            ajax: true,
            post: function ()
            {
                return {
                    "p_workflow_id": "<?php echo $p_workflow_id?>"
                };
            },
            url: "<?php echo site_url('workflow_parameter/getMonProcess');?>",
            selection: true,
            sorting:true
        });
    });

</script>
