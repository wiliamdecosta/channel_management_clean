<!-- #section:basics/content.breadcrumbs -->
<div class="breadcrumbs" id="breadcrumbs">
    <?= $this->breadcrumb; ?>
</div>

<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">
    <div class="row">
        <div id="notif"></div>
        <table id="grid-table"></table>
        <div id="grid-pager"></div>
    </div><!-- /.row -->
    
    <div class="row" id="mitra_row_content" style="margin-top:20px;display:none;">
    	<div class="col-xs-12">
    	    <div class="well well-sm"> <h4 class="blue" id="mitra_title"> User </h4></div>
    	    <form class="form-horizontal"  method="post"  id="form-pgl-cust">
                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right"> User ID </label>
                    <div class="col-sm-7">
                        <input id="form_user_id" type="text" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right"> Mitra </label>
                    <div class="col-sm-7">
                        
                        <input id="form_pgl_id" type="text"  style="display:none;">
                        <input id="form_user_email" type="text"  style="display:none;">
                        <input id="form_pgl_name" type="text" class="col-xs-10 col-sm-5 required" placeholder="Pilih Mitra" required>
                        <span class="input-group-btn">
    						<button class="btn btn-warning btn-sm" type="button" id="btn_lov_cust_pgl">
    							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
    						</button>
    					</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-1"></div>
    		        <div class="col-sm-7">
    			      	<button type="submit" class="btn btn-primary btn-xs btn-round">
    			      		<i class="ace-icon fa fa-floppy-o bigger-120"></i>
    			      		Simpan
    			      	</button>
    			      	
    			      	<button type="button" id="btn-delete-mitra" class="btn btn-danger btn-xs btn-round">
    			      		<i class="ace-icon fa fa-floppy-o bigger-120"></i>
    			      		Hapus
    			      	</button>
    			    </div>
		        </div>
            </form>
    	</div>
    </div>
    
    <?php $this->load->view('parameter/lov_cust_pgl.php'); ?>
    
</div><!-- /.page-content -->

<script type="text/javascript">
    
    $(document).ready(function(){
        $("#btn_lov_cust_pgl").on(ace.click_event, function() {
            modal_lov_cust_pgl_show("form_pgl_id","form_pgl_name");
        });
        
        $("#btn-delete-mitra").click(function(){
            
            swal({
                title: "Konfirmasi Hapus",
                text: "Apakah Anda yakin untuk menghapus data mitra user?",
                type: "warning",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Tidak, Batalkan",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm){
                if(isConfirm) {
                    $.post( "<?php echo site_url('mapping_user_mitra/deletemitra');?>",
                        {items: JSON.stringify({
                                user_id : $("#form_user_id").val()
                            })
                        },
                        function( response ) {
                            
                            var response = JSON.parse(response);
                            if(response.success == false) {
                                swal({title: "Perhatian",text: response.message, html: true, type : 'warning'});
                            }else {
                    	        swal("Berhasil", response.message, "success");
                    	        var grid = jQuery("#grid-table");
                                grid.trigger("reloadGrid", [{page: 1}]);
                            }
                        }
                    );    
                }
            });        
        });
        
        $("#form-pgl-cust").on('submit', (function (e) {
            
            e.preventDefault();
            if($("#form_pgl_id").val() == "") {
                swal("Perhatian","Anda belum memilih mitra","info");    
                return false;
            }
            
            if($("#form_user_email").val() == "") {
                swal("Perhatian","Email user yang bersangkutan belum ada. Data tidak dapat disimpan.","info");    
                return false;
            }
            
            
            swal({
                title: "Konfirmasi Simpan",
                text: "Data akan disimpan dan User akan dikirimkan email berisikan link untuk menuju halaman submit profile. Apakah Anda yakin?",
                type: "info",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonText: "Ya, Simpan dan Kirim",
                cancelButtonText: "Tidak, Batalkan",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm){
                if(isConfirm) {
                    
                    $.post( "<?php echo site_url('mapping_user_mitra/savemitra');?>",
                        {items: JSON.stringify({
                                user_id : $("#form_user_id").val(),
                                user_email : $("#form_user_email").val(),
                                pgl_id : $("#form_pgl_id").val()
                            })
                        },
                        function( response ) {
                            
                            var response = JSON.parse(response);
                            if(response.success == false) {
                                swal({title: "Perhatian",text: response.message, html: true, type : 'warning'});
                            }else {
                    	        swal("Berhasil", response.message, "success");
                    	        var grid = jQuery("#grid-table");
                                grid.trigger("reloadGrid", [{page: 1}]);
                                $("#modal_upload_kontrak").modal("hide");
                            }
                        }
                    );
                    return false;     
                }else {
                    return false;    
                }
            });
            
            
        }));
    });
        
    $(document).ready(function () {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        //resize to fit page size
        $(window).on('resize.jqGrid', function () {
            $(grid_selector).jqGrid('setGridWidth', $("#contentJgGrid").width());
        });

        $(window).on('resize.jqGrid', function () {
            $(pager_selector).jqGrid('setGridWidth', $("#contentJgGrid").width());
        });
        
        jQuery("#grid-table").jqGrid({
            url: '<?php echo site_url('mapping_user_mitra/gridUser');?>',
            datatype: "json",
            mtype: "POST",
            //colNames:['Inv No','Date', 'Client', 'Amount','Tax','Total','Notes'],
            colModel: [
                {label: 'ID', name: 'USER_ID', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'User Name', name: 'USER_NAME', width: 90, align: "left", editable: true, editrules: {required: true}},
                {label: 'Full Name', name: 'FULL_NAME', width: 150, align: "left", editable: true},
                {label: 'Email', name: 'EMAIL', width: 100, align: "left", editable: true},
                {label: 'Loker', name: 'LOKER', width: 100, align: "left", editable: true},
                {label: 'City', name: 'ADDR_CITY', width: 90, align: "left", editable: true},
                {label: 'Mitra', name: 'PGL_ID', width: 90, align: "left", editable: true, hidden: true},
                {label: 'Mitra', name: 'PGL_NAME', width: 90, align: "left", editable: true}
            ],
            width: 1120,
            //width: '100%',
            height: '100%',
            autowidth: true,
            rowNum: 5,
            viewrecords: true,
            rowList: [5, 10, 20],
            sortname: 'USER_NAME', // default sorting ID
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            sortorder: 'asc',
            altRows: true,
            shrinkToFit: true,
            //multiselect: true,
            //multikey: "ctrlKey",
            multiboxonly: true,
            onSelectRow: function (rowid) {
                var celValue = $('#grid-table').jqGrid('getCell', rowid, 'USER_ID');
                var userName = $('#grid-table').jqGrid('getCell', rowid, 'USER_NAME');
                
                var PGL_ID = $('#grid-table').jqGrid('getCell', rowid, 'PGL_ID');
                var PGL_NAME = $('#grid-table').jqGrid('getCell', rowid, 'PGL_NAME');
                var USER_EMAIL = $('#grid-table').jqGrid('getCell', rowid, 'EMAIL');
                
                $("#form_user_id").val(celValue);
                $("#form_pgl_id").val(PGL_ID);
                $("#form_pgl_name").val(PGL_NAME);
                $("#form_user_email").val(USER_EMAIL);
                
                $("#mitra_title").html("USER ::" + userName);
                $("#mitra_row_content").show();
            },
            onSortCol: clearSelection,
            onPaging: clearSelection,
            //#pager merupakan div id pager
            pager: '#grid-pager',
            jsonReader: {
                root: 'Data',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function () {
                var table = this;
                setTimeout(function () {
                    //  styleCheckbox(table);

                    //  updateActionIcons(table);
                    updatePagerIcons(table);
                    enableTooltips(table);
                }, 0);
                $("#form-pgl-cust")[0].reset();
                $("#mitra_row_content").hide();
            },

            //memanggil controller jqgrid yang ada di controller crud
            editurl: '',
            caption: "Mapping User Mitra"

        });
    });


    //navButtons grid master
    jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
        { 	//navbar options
            edit: false,
            excel: false,
            editicon: 'ace-icon fa fa-pencil blue',
            add: false,
            addicon: 'ace-icon fa fa-plus-circle purple',
            del: false,
            delicon: 'ace-icon fa fa-trash-o red',
            search: true,
            searchicon: 'ace-icon fa fa-search orange',
            refresh: true,
            afterRefresh: function () {
                // some code here
            },
            refreshicon: 'ace-icon fa fa-refresh green',
            view: false,
            viewicon: 'ace-icon fa fa-search-plus grey'
        },
        {
            // options for the Edit Dialog
            closeAfterEdit: true,
            width: 500,
            errorTextFormat: function (data) {
                return 'Error: ' + data.responseText
            },
            recreateForm: true,
            beforeShowForm: function (e, form) {
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                style_edit_form(form);
                $("#NIK").prop("readonly", true);

            }
        },
        {
            //new record form
            width: 400,
            errorTextFormat: function (data) {
                return 'Error: ' + data.responseText
            },
            closeAfterAdd: true,
            recreateForm: true,
            viewPagerButtons: false,
            beforeShowForm: function (e, form) {
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
                    .wrapInner('<div class="widget-header" />')
                style_edit_form(form);
                $("#tr_PASSWD", form).show();
            }
        },
        {
            //delete record form
            recreateForm: true,
            beforeShowForm: function (e) {
                var form = $(e[0]);
                if (form.data('styled')) return false;

                form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                style_delete_form(form);

                form.data('styled', true);
            },
            onClick: function (e) {
                //alert(1);
            },
            msg: 'Penghapusan terhadap data User akan secara otomatis menghapus data User Attribute yang berkaitan.<br>Apakah Anda yakin menghapus data tersebut?',
            width: '400px'
        },
        {
            //search form
            // closeAfterSearch: true,
            recreateForm: true,
            afterShowSearch: function (e) {
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                style_search_form(form);
            },
            afterRedraw: function () {
                style_search_filters($(this));
            }

//            multipleSearch: true,
            //           showQuery: true
            /**
             multipleGroup:true,
             showQuery: true
             */
        },
        {
            //view record form
            recreateForm: true,
            beforeShowForm: function (e) {
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
            }
        }
    );

    
    function clearSelection() {
        //jQuery("#jqGridDetails").jqGrid('setGridParam',{url: "empty.json", datatype: 'json'}); // the last setting is for demo purpose only
        jQuery("#jqGridDetails").jqGrid('setCaption', 'Menu Child ::');
        jQuery("#jqGridDetails").trigger("reloadGrid");

    }

    function style_edit_form(form) {
        //enable datepicker on "sdate" field and switches for "stock" field
        form.find('input[name=sdate]').datepicker({format: 'yyyy-mm-dd', autoclose: true})

        form.find('input[name=stock]').addClass('ace ace-switch ace-switch-5').after('<span class="lbl"></span>');
        //don't wrap inside a label element, the checkbox value won't be submitted (POST'ed)
        //.addClass('ace ace-switch ace-switch-5').wrap('<label class="inline" />').after('<span class="lbl"></span>');


        //update buttons classes
        var buttons = form.next().find('.EditButton .fm-button');
        buttons.addClass('btn btn-sm').find('[class*="-icon"]').hide();//ui-icon, s-icon
        buttons.eq(0).addClass('btn-primary').prepend('<i class="ace-icon fa fa-check"></i>');
        buttons.eq(1).prepend('<i class="ace-icon fa fa-times"></i>')

        buttons = form.next().find('.navButton a');
        buttons.find('.ui-icon').hide();
        buttons.eq(0).append('<i class="ace-icon fa fa-chevron-left"></i>');
        buttons.eq(1).append('<i class="ace-icon fa fa-chevron-right"></i>');
    }

    function style_delete_form(form) {
        var buttons = form.next().find('.EditButton .fm-button');
        buttons.addClass('btn btn-sm btn-white btn-round').find('[class*="-icon"]').hide();//ui-icon, s-icon
        buttons.eq(0).addClass('btn-danger').prepend('<i class="ace-icon fa fa-trash-o"></i>');
        buttons.eq(1).addClass('btn-default').prepend('<i class="ace-icon fa fa-times"></i>')
    }

    function style_search_filters(form) {
        form.find('.delete-rule').val('X');
        form.find('.add-rule').addClass('btn btn-xs btn-primary');
        form.find('.add-group').addClass('btn btn-xs btn-success');
        form.find('.delete-group').addClass('btn btn-xs btn-danger');
    }
    function style_search_form(form) {
        var dialog = form.closest('.ui-jqdialog');
        var buttons = dialog.find('.EditTable')
        buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');
        buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');
        buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');
    }

    function beforeDeleteCallback(e) {
        var form = $(e[0]);
        if (form.data('styled')) return false;

        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
        style_delete_form(form);

        form.data('styled', true);
    }

    function beforeEditCallback(e) {
        var form = $(e[0]);
        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
        style_edit_form(form);
    }


    //it causes some flicker when reloading or navigating grid
    //it may be possible to have some custom formatter to do this as the grid is being created to prevent this
    //or go back to default browser checkbox styles for the grid
    function styleCheckbox(table) {
        /**
         $(table).find('input:checkbox').addClass('ace')
         .wrap('<label />')
         .after('<span class="lbl align-top" />')


         $('.ui-jqgrid-labels th[id*="_cb"]:first-child')
         .find('input.cbox[type=checkbox]').addClass('ace')
         .wrap('<label />').after('<span class="lbl align-top" />');
         */
    }


    //unlike navButtons icons, action icons in rows seem to be hard-coded
    //you can change them like this in here if you want
    function updateActionIcons(table) {
        /**
         var replacement =
         {
             'ui-ace-icon fa fa-pencil' : 'ace-icon fa fa-pencil blue',
             'ui-ace-icon fa fa-trash-o' : 'ace-icon fa fa-trash-o red',
             'ui-icon-disk' : 'ace-icon fa fa-check green',
             'ui-icon-cancel' : 'ace-icon fa fa-times red'
         };
         $(table).find('.ui-pg-div span.ui-icon').each(function(){
						var icon = $(this);
						var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
						if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
					})
         */
    }

    //replace icons with FontAwesome icons like above
    function updatePagerIcons(table) {
        var replacement =
        {
            'ui-icon-seek-first': 'ace-icon fa fa-angle-double-left bigger-140',
            'ui-icon-seek-prev': 'ace-icon fa fa-angle-left bigger-140',
            'ui-icon-seek-next': 'ace-icon fa fa-angle-right bigger-140',
            'ui-icon-seek-end': 'ace-icon fa fa-angle-double-right bigger-140'
        };
        $('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function () {
            var icon = $(this);
            var $class = $.trim(icon.attr('class').replace('ui-icon', ''));

            if ($class in replacement) icon.attr('class', 'ui-icon ' + replacement[$class]);
        })
    }

    function enableTooltips(table) {
        $('.navtable .ui-pg-button').tooltip({container: 'body'});
        $(table).find('.ui-pg-div').tooltip({container: 'body'});
    }

</script>