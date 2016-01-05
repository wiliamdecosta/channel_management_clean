<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Code Igniter

* @package		CodeIgniter
* @author		Gery

**/
function getBreadcrumb($bc)
{

	$obj =& get_instance();
	$base_url = $obj->config->item('base_url');
    $link = count($bc);
    switch ($link) {
        case '1':
            $bc = '<div class="breadcrumbs" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="'.$base_url.'">Home</a>
							</li>

							<li class="active">'.$bc[0].'</li>
						</ul><!-- /.breadcrumb --
						<!-- /section:basics/content.searchbox -->
					 </div>';
        break;
        case '2':
            $bc = '<div class="breadcrumbs" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="'.$base_url.'">Home</a>
							</li>

                            <li>
								<a href="#">'.$bc[0].'</a>
							</li>

							<li class="active">'.$bc[1].'</li>
						</ul><!-- /.breadcrumb --
						<!-- /section:basics/content.searchbox -->
					 </div>';
        break;
        case '3':
            $bc = '<div class="breadcrumbs" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="'.$base_url.'">Home</a>
							</li>

							<li>
								<a href="#">'.$bc[0].'</a>
							</li>

							<li>
								<a href="#">'.$bc[1].'</a>
							</li>

							<li class="active">'.$bc[2].'</li>
						</ul>
					 </div>';

        break;
        default:
            $bc = '<div class="breadcrumbs" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="'.$base_url.'">Home</a>
							</li>
					 </div>';
    }



    return $bc;
}

