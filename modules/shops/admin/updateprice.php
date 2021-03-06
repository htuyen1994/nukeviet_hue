<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 28 May 2015 03:54:03 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
	die('Stop!!!');

$row = array();
$error = array();
$row['id'] = $nv_Request -> get_int('id', 'post,get', 0);
if ($nv_Request -> isset_request('submit', 'post')) {//xu li lưu
	$row['catid'] = $nv_Request -> get_int('catid', 'post', 0);
	$row['newprice'] = $nv_Request -> get_int('newprice', 'post', 0);

	$_sql = 'SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_catalogs where catid=' . $row['catid'];
	$_query = $db -> query($_sql);
	while ($row1 = $_query -> fetch()) {

		$_sql1 = 'UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_rows
			 SET product_price=' . $row['newprice'] . ' where listcatid=' . $row1['catid'];
		if ($row1['subcatid'] != 0) {
			$_sql1 .= ' OR listcatid IN (' . $row1['subcatid'] . ')';
		}
		$stmt = $db -> prepare($_sql1);
		if ($stmt -> execute()) {
			$error[] = 'đã thực hiện thành công';
			Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=items&listcatid=' . $row1['catid']);
			die();
		}

	}

} else {
	$row['id'] = 0;
	$row['cateid'] = 0;
	$row['newprice'] = 0;
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl -> assign('LANG', $lang_module);
$xtpl -> assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl -> assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl -> assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl -> assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl -> assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl -> assign('MODULE_NAME', $module_name);
$xtpl -> assign('OP', $op);
$xtpl -> assign('ROW', $row);

if (!empty($error)) {
	$xtpl -> assign('ERROR', implode('<br />', $error));
	$xtpl -> parse('main.error');
}
// //lấy dữ liệu bảng catalog vào selectbox
// $_sql = 'SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_catalogs';
// $_query = $db -> query($_sql);
// while ($row = $_query -> fetch()) {
// $xtpl -> assign('OPTION', array('key' => $row['catid'], 'title' => $row['vi_title'], 'selected' => ($row['catid'] == $row['catid']) ? ' selected="selected"' : ''));
// $xtpl -> parse('main.select_cateid');
// }
//lấy dữ liệu từ "global_array_shops_cat" trong content.php(phân cấp cha con)
foreach ($global_array_shops_cat as $catid_i => $rowscat) {
	$xtitle_i = '';
	if ($rowscat['lev'] > 0) {
		for ($i = 1; $i <= $rowscat['lev']; $i++) {
			$xtitle_i .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}
	}
	$rowscat['key'] = $rowscat['catid'];
	$rowscat['title'] = $xtitle_i . $rowscat['title'];
	$rowscat['selected'] = ($catid_i == $row['listcatid']) ? ' selected="selected"' : '';

	$xtpl -> assign('OPTION', $rowscat);
	$xtpl -> parse('main.select_cateid');
}
if (empty($row['id'])) {
	$xtpl -> parse('main.auto_get_alias');
}

$xtpl -> parse('main');
$contents = $xtpl -> text('main');

$page_title = $lang_module['updateprice'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
