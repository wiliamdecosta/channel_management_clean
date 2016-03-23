<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.custom.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/chosen.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/datepicker.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/daterangepicker.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.css" />
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/ckfinder/ckfinder.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/ckeditor/ckeditor.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/jspdf.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/plugins/from_html.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/plugins/split_text_to_size.js"> </script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/plugins/standard_fonts_metrics.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/plugins/standard_fonts_metrics.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/dist/jspdf.debug.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/plugins/addimage.js.js"></script>


<div id="list_template"> <!--harusnya dokPKS -->
    <form class="form-horizontal" role="form">
        <div class="rows">
            <div class="form-group" id="all_table">
                <div class="col-xs-11">
                        <div class="clearfix">
                        </div>
                        <div class="table-header">
                            Daftar Template
                        </div>
                        <div>
                            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>									
                                    <th class="center">NO</th>
									<th>Ax</th>
                                    <th class="center"> Nama Dokumen</th>
                                    <th class="center"> Jenis Dokumen</th>
                                    <th class="center"> Template</th>
                                    <th class="center"> Update By</th>
                                    <th class="center"> Update Date</th>
                                    <th class="center"> Action </th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php $i = 1;
                                foreach ($result['V_DOC'] as $content){

                                    ?>
                                    <tr value=<?php echo '"'.$content->DOC_ID.'"'; ?> class="table_head">
										<td class="center"><?php echo $i; ?> </td>
										<td></td>
                                        <td value="1XKLI">
                                            <a href="#"><?php echo $content->DOC_NAME; ?></a>
                                        </td>
                                        <td class="center" value="1XKLI"> <?php echo $content->DOC_TYPE_NAME; ?> </td>
                                        <td value="1XKLI"> <?php echo $content->LANG; ?> </td>
                                        <td class="class1" id="classic" value="1XKLI"> <?php echo $content->UPDATE_BY; ?> </td>
                                        <td value="1XKLI"> <?php echo $content->UPDATE_DATE; ?> </td>
                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a class="purple" data-rel="tooltip" data-original-title="Download">
                                                    <i class="ace-icon fa fa-download bigger-130"></i>
                                                </a>

                                                <a class="blue" data-rel="tooltip" data-original-title="View" onClick="Back()">
                                                    <i class= "ace-icon fa fa-search-plus bigger-130"></i>
                                                </a>

                                                <a class="green" data-rel="tooltip" data-original-title="Edit" onClick="Back2()">
                                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                </a>

                                                <a class="red" data-rel="tooltip" data-original-title="Delete">
                                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                </a>
                                            </div>

                                            <div class="hidden-md hidden-lg">
                                                <div class="inline pos-rel">
                                                    <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                                        <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                                    </button>

                                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                        <li>
                                                            <a  class="tooltip-download" data-rel="tooltip" title="Download">
																				<span class="blue">
																					<i class="ace-icon fa fa-download bigger-120">ss</i>
																				</span>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a class="tooltip-info" data-rel="tooltip" title="View" onClick="Back()">
																				<span class="blue">
																					<i class="ace-icon fa fa-search-plus bigger-120"></i>
																				</span>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a  class="tooltip-success" data-rel="tooltip" title="Edit" onClick="Back2()">
																				<span class="green">
																					<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																				</span>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a class="tooltip-error" data-rel="tooltip" title="Delete" >
																				<span class="red">
																					<i class="ace-icon fa fa-trash-o bigger-120"></i>
																				</span>
                                                            </a>
                                                        </li>                                                       

                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }

                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </form>
</div>
<div id="all_view">
	<div id="texteditorOne">
		<textarea id="textarea1" readonly>
		</textarea>
	</div>
	<div id="texteditorTwo">
		<textarea id="textarea2">
		</textarea>
	</div>
	<div id="buttonOne">
		<a id="findFilter" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset btn btn-sm btn-info" value="" onClick="showTable()">
						<!-- class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset btn btn-sm btn-info || fm-button ui-state-default ui-reset btn btn-sm btn-info center-block -->
						Finish</a>
	</div>
	<div id="hiddenval" style="display: none;"><input type="text" id="test3" value="LALALALA"></div>
</div>
<script type="text/javascript">
    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true
    })
        //show datepicker when clicking on the icon
        .next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
		
</script>
<script type="text/javascript">
jQuery(function($) {
    //initiate dataTables plugin
    var oTable1 =
        $('#dynamic-table')
            //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
            .dataTable( {
				// "columnDefs": [
				// { className: "hide_column", "targets": [ 0 ] }
				// ]
				"aoColumnDefs": [{ "bVisible": false, "aTargets": [1] }]
            } );
    //TableTools settings
    TableTools.classes.container = "btn-group btn-overlap";
    TableTools.classes.print = {
        "body": "DTTT_Print",
        "info": "tableTools-alert gritter-item-wrapper gritter-info gritter-center white",
        "message": "tableTools-print-navbar"
    }
    //initiate TableTools extension
    var tableTools_obj = new $.fn.dataTable.TableTools( oTable1, {
        "sSwfPath": "../assets/js/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf", //in Ace demo ../assets will be replaced by correct assets path

        "sRowSelector": "td:not(:last-child)",
        "sRowSelect": "multi",
        "fnRowSelected": function(row) {
            //check checkbox when row is selected
            try { $(row).find('input[type=checkbox]').get(0).checked = true }
            catch(e) {}
        },
        "fnRowDeselected": function(row) {
            //uncheck checkbox
            try { $(row).find('input[type=checkbox]').get(0).checked = false }
            catch(e) {}
        },

        "sSelectedClass": "success",
        "aButtons": [
            {
                "sExtends": "copy",
                "sToolTip": "Copy to clipboard",
                "sButtonClass": "btn btn-white btn-primary btn-bold",
                "sButtonText": "<i class='fa fa-copy bigger-110 pink'></i>",
                "fnComplete": function() {
                    this.fnInfo( '<h3 class="no-margin-top smaller">Table copied</h3>\
									<p>Copied '+(oTable1.fnSettings().fnRecordsTotal())+' row(s) to the clipboard.</p>',
                        1500
                    );
                }
            },

            {
                "sExtends": "csv",
                "sToolTip": "Export to CSV",
                "sButtonClass": "btn btn-white btn-primary  btn-bold",
                "sButtonText": "<i class='fa fa-file-excel-o bigger-110 green'></i>"
            },

            {
                "sExtends": "pdf",
                "sToolTip": "Export to PDF",
                "sButtonClass": "btn btn-white btn-primary  btn-bold",
                "sButtonText": "<i class='fa fa-file-pdf-o bigger-110 red'></i>"
            },

            {
                "sExtends": "print",
                "sToolTip": "Print view",
                "sButtonClass": "btn btn-white btn-primary  btn-bold",
                "sButtonText": "<i class='fa fa-print bigger-110 grey'></i>",

                "sMessage": "<div class='navbar navbar-default'><div class='navbar-header pull-left'><a class='navbar-brand' href='#'><small>Optional Navbar &amp; Text</small></a></div></div>",

                "sInfo": "<h3 class='no-margin-top'>Print view</h3>\
									  <p>Please use your browser's print function to\
									  print this table.\
									  <br />Press <b>escape</b> when finished.</p>"
            }
        ]
    } );
    //we put a container before our table and append TableTools element to it
    $(tableTools_obj.fnContainer()).appendTo($('.tableTools-container'));

    //also add tooltips to table tools buttons
    //addding tooltips directly to "A" buttons results in buttons disappearing (weired! don't know why!)
    //so we add tooltips to the "DIV" child after it becomes inserted
    //flash objects inside table tools buttons are inserted with some delay (100ms) (for some reason)
    setTimeout(function() {
        $(tableTools_obj.fnContainer()).find('a.DTTT_button').each(function() {
            var div = $(this).find('> div');
            if(div.length > 0) div.tooltip({container: 'body'});
            else $(this).tooltip({container: 'body'});
        });
    }, 200);

    //ColVis extension
    var colvis = new $.fn.dataTable.ColVis( oTable1, {
        "buttonText": "<i class='fa fa-search'></i>",
        "aiExclude": [0, 6],
        "bShowAll": true,
        //"bRestore": true,
        "sAlign": "right",
        "fnLabel": function(i, title, th) {
            return $(th).text();//remove icons, etc
        }

    });

    //style it
    $(colvis.button()).addClass('btn-group').find('button').addClass('btn btn-white btn-info btn-bold')

    //and append it to our table tools btn-group, also add tooltip
    $(colvis.button())
        .prependTo('.tableTools-container .btn-group')
        .attr('title', 'Show/hide columns').tooltip({container: 'body'});

    //and make the list, buttons and checkboxed Ace-like
    $(colvis.dom.collection)
        .addClass('dropdown-menu dropdown-light dropdown-caret dropdown-caret-right')
        .find('li').wrapInner('<a href="javascript:void(0)" />') //'A' tag is required for better styling
        .find('input[type=checkbox]').addClass('ace').next().addClass('lbl padding-8');



    /////////////////////////////////
    //table checkboxes
    $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

    //select/deselect all rows according to table header checkbox
    $('#dynamic-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
        var th_checked = this.checked;//checkbox inside "TH" table header

        $(this).closest('table').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) tableTools_obj.fnSelect(row);
            else tableTools_obj.fnDeselect(row);
        });
    });

    //select/deselect a row when the checkbox is checked/unchecked
    $('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
        var row = $(this).closest('tr').get(0);
        if(!this.checked) tableTools_obj.fnSelect(row);
        else tableTools_obj.fnDeselect($(this).closest('tr').get(0));
    });
    $(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
        e.stopImmediatePropagation();
        e.stopPropagation();
        e.preventDefault();
    });
	
	$(document).on('click', '#dynamic-table .tooltip-download', function(e) {
		var id_DOC = $(this).closest('tr').attr('value');			
		$.ajax({
                type: "POST",
				url: "<?php echo base_url(); ?>"+"template/POST_idDOC",
                data:  {id_doc: id_DOC},
				dataType:"text",
				success: function(data){
					if (data.length > 0){
						var docpdf = new jsPDF('p', 'pt', 'letter');
						margins = { top: 60, bottom: 60, left: 40, width: 500 };
						var elmtHandler = 
						{
							'#CreateReport' : function (elmtHandler, renderer){
							return true;	
						},
							'#PrintReport' : function (elmtHandler, renderer){
							return true;	
						},
						'#ignorePDF': function (element, renderer) {
						return true;}
						};				
						docpdf.fromHTML(
						data,margins.left,margins.top,
							{
							'width':margins.width, 'elementHandlers' : elmtHandler 
							}, 
							function(dispose){docpdf.output("dataurlnewwindow");}, margins);
					}
                }
		});
    });
	
	$(document).on('click', '#dynamic-table .tooltip-error', function(e) {
		var id_DOC = $(this).closest('tr').attr('value');		
		$.ajax({
                type: "POST",
				url: "<?php echo base_url(); ?>"+"template/delete_DOC",
                data:  {id_doc: id_DOC},
				dataType:"text",
				success: function(data){
					swal("Sukses","Data template berhasil dihapus","success");
                }
		});
    });


    //And for the first simple table, which doesn't have TableTools or dataTables
    //select/deselect all rows according to table header checkbox
    var active_class = 'active';
    $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
        var th_checked = this.checked;//checkbox inside "TH" table header

        $(this).closest('table').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
            else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
        });
    });

    //select/deselect a row when the checkbox is checked/unchecked
    $('#simple-table').on('click', 'td input[type=checkbox]' , function(){
        var $row = $(this).closest('tr');		
        if(this.checked) $row.addClass(active_class);
        else $row.removeClass(active_class);		
    });



    /********************************/
        //add tooltip for small view action buttons in dropdown menu
    $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

    //tooltip placement on right or left
    function tooltip_placement(context, source) {
        var $source = $(source);
        var $parent = $source.closest('table')
        var off1 = $parent.offset();
        var w1 = $parent.width();

        var off2 = $source.offset();
        //var w2 = $source.width();

        if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
        return 'left';
    }

    $(function() {
       // $( document ).tooltip();
    });
	
})
  var editor = CKEDITOR.replace( 'textarea1', {
        height: 350,
        filebrowserBrowseUrl : '<?php echo base_url();?>assets/js/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl : '<?php echo base_url();?>assets/js/ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl : '<?php echo base_url();?>assets/js/ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl : '<?php echo base_url();?>assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl : '<?php echo base_url();?>assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl : '<?php echo base_url();?>assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
     });
     CKFinder.setupCKEditor( editor, '../' );
	   var editor2 = CKEDITOR.replace( 'textarea2', {
        height: 350,
        filebrowserBrowseUrl : '<?php echo base_url();?>assets/js/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl : '<?php echo base_url();?>assets/js/ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl : '<?php echo base_url();?>assets/js/ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl : '<?php echo base_url();?>assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl : '<?php echo base_url();?>assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl : '<?php echo base_url();?>assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
     });
     CKFinder.setupCKEditor( editor, '../' );
$(document).ready(function () {
	var edit = true;
		jQuery("#texteditorOne").hide();
		jQuery("#buttonOne").hide();		
		jQuery("#texteditorTwo").hide();		
    });
	//var oTable = $('#dynamic-table').DataTable();	
	function Back(){
		edit = false;
		jQuery("#all_table").hide(1000);
		jQuery("#texteditorOne").show(1000);		
		jQuery("#buttonOne").show(1000);
		$("#textarea1").val("WEW");
		$('#dynamic-table tbody').on('click', 'tr', function () {
			var id_DOC = $(this).attr('value');			
			$.ajax({
                type: "POST",
				url: "<?php echo base_url(); ?>"+"template/POST_idDOC",
                data:  {id_doc: id_DOC},
				dataType:"text",
				success: function(data){
				CKEDITOR.instances["textarea1"].setData(data);
                }
                });
		});	
	}
	function showTable(){
		jQuery("#texteditorOne").hide(1000);
		jQuery("#texteditorTwo").hide(1000);		
		jQuery("#buttonOne").hide(1000);
		jQuery("#all_table").show(1000);		
			var DOC_content = CKEDITOR.instances["textarea2"].getData();
			if (edit){
				ID = $('#findFilter').val();
				
				$.ajax({
                type: "POST",
				url: "<?php echo base_url(); ?>"+"template/update_Content",
                data:  {docx_contents: DOC_content, idx : ID},
				dataType:"text",
				success: function(data){
					swal("Sukses","Data template berhasil diupdate","success");
                }					
                });
			}			
	}
	function Back2(){
		edit = true;
		jQuery("#all_table").hide(1000);
		jQuery("#texteditorTwo").show(1000);		
		jQuery("#buttonOne").show(1000);
		$('#dynamic-table tbody').on('click', 'tr', function () {
			var id_DOC = $(this).attr('value');			
			$.ajax({
                type: "POST",
				url: "<?php echo base_url(); ?>"+"template/POST_idDOC",
                data:  {id_doc: id_DOC},
				dataType:"text",
				success: function(data){
				CKEDITOR.instances["textarea2"].setData(data);
				$('#findFilter').val(id_DOC);				
                }
                });
		});	
	}	
</script>