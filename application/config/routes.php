<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// --- Static Pages ---
$route['about-us'] = 'home/about';
$route['contact-us'] = 'home/contact';
$route['gallery'] = 'home/gallery';
$route['privacy-policy'] = 'home/privacy_policy';
$route['terms'] = 'home/policy/terms';
$route['refund-policy'] = 'home/policy/refund-policy';

// --- Member Authentication ---
$route['login']     = 'memberauth/login';
$route['register']  = 'memberauth/register';
$route['logout']    = 'memberauth/logout';
$route['my-profile'] = 'memberauth/dashboard';
$route['my-applications'] = 'memberauth/my_applications';
$route['donation-history'] = 'memberauth/donation_history';
$route['request-update'] = 'memberauth/request_update';
$route['edit-profile'] = 'memberauth/edit_profile';

// --- Public Directory ---
$route['members']             = 'listing/members';
$route['members/(:num)']      = 'listing/members/$1';
$route['member/(:num)']       = 'listing/member_profile/$1';
$route['business']            = 'listing/business';
$route['business/category/(:any)'] = 'listing/business_category/$1';
$route['business/(:num)']     = 'listing/business_profile/$1';

// --- Services (Donation & Assistance) ---
$route['donate'] = 'services/donate';
$route['medical-assistance']   = 'services/apply/medical';
$route['education-assistance'] = 'services/apply/education';
$route['pension-assistance']   = 'services/apply/pension';

// --- Information Directories ---
$route['information/maharaj']      = 'information/maharaj';
$route['information/maharaj/(:num)'] = 'information/maharaj/$1';
$route['information/temples']      = 'information/temples';
$route['information/temples/(:num)'] = 'information/temples/$1';
$route['information/dharmshalas']  = 'information/dharmshalas';
$route['information/dharmshalas/(:num)'] = 'information/dharmshalas/$1';
$route['information/jobs']         = 'information/jobs';
$route['information/jobs/(:num)']  = 'information/jobs/$1';

// --- Programs / Events ---
$route['programs/upcoming'] = 'programs/upcoming';
$route['programs/recent']   = 'programs/recent';
$route['programs/(:any)']   = 'programs/detail/$1';

// --- News ---
$route['news']        = 'news/index';
$route['news/(:any)'] = 'news/detail/$1';

// --- Admin Panel ---
// --- Admin Panel ---
// Community Module Routes (Priority High)
$route['admin/community'] = 'admin/community/dashboard';
$route['admin/community/members'] = 'admin/community/members';
$route['admin/community/add_member'] = 'admin/community/add_member';
$route['admin/community/save_member'] = 'admin/community/save_member';
$route['admin/community/edit_member/(:num)'] = 'admin/community/edit_member/$1';
$route['admin/community/update_member/(:num)'] = 'admin/community/update_member/$1';
$route['admin/community/delete_member/(:num)'] = 'admin/community/delete_member/$1';
$route['admin/community/categories'] = 'admin/community/categories';
$route['admin/community/posts'] = 'admin/community/posts';
// Catch-all for community just in case
$route['admin/community/(:any)'] = 'admin/community/$1';


// Main Admin Dashboard
// $route['admin'] = 'dashboard';
// $route['admin/(:any)'] = 'dashboard/$1';

// --- Catch-all (MUST be last) ---
$route['(:any)'] = 'home/service/$1';