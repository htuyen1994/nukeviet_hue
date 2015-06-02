<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 10 Dec 2011 06:46:54 GMT
 */

if( !defined( 'NV_MAINFILE' ) )
	die( 'Stop!!!' );

if( !nv_function_exists( 'nv_block_news_groups_marquee' ) )
{
	function nv_block_config_news_groups_marquee( $module, $data_block, $lang_block )
	{
		global $site_mods;

		$html_input = '';
		$html = '';
		$html .= '<tr>';
		$html .= '<td>' . $lang_block['blockid'] . '</td>';
		$html .= '<td><select name="config_blockid" class="form-control w200">';
		$html .= '<option value="0"> -- </option>';
		$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_block_cat ORDER BY weight ASC';
		$list = nv_db_cache( $sql, '', $module );
		foreach( $list as $l )
		{
			$html_input .= '<input type="hidden" id="config_blockid_' . $l['bid'] . '" value="' . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $site_mods[$module]['alias']['groups'] . '/' . $l['alias'] . '" />';
			$html .= '<option alt="' . $linksite . '" value="' . $l['bid'] . '" ' . (($data_block['blockid'] == $l['bid']) ? ' selected="selected"' : '') . '>' . $l['title'] . '</option>';
		}
		$html .= '</select>';
		$html .= $html_input;
		$html .= '<script type="text/javascript">';
		$html .= '	$("select[name=config_blockid]").change(function() {';
		$html .= '		$("input[name=title]").val($("select[name=config_blockid] option:selected").text());';
		$html .= '		$("input[name=link]").val($("#config_blockid_" + $("select[name=config_blockid]").val()).val());';
		$html .= '	});';
		$html .= '</script>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>' . $lang_block['numrow'] . '</td>';
		$html .= '<td><input type="text" class="form-control w200" name="config_numrow" size="5" value="' . $data_block['numrow'] . '"/></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '	<td>' . $lang_block['direction'] . '</td>';
		$html .= '<td><select name="config_direction" class="form-control w200">';
		$se = $data_block['direction'] == 'top' ? 'selected="selected"' : '';
		$html .= '<option value="top" ' . $se . '>' . $lang_block['direction_top'] . '</option>';
		$se = $data_block['direction'] == 'bottom' ? 'selected="selected"' : '';
		$html .= '<option value="bottom" ' . $se . '>' . $lang_block['direction_bottom'] . '</option>';
		$se = $data_block['direction'] == 'left' ? 'selected="selected"' : '';
		$html .= '<option value="left" ' . $se . '>' . $lang_block['direction_left'] . '</option>';
		$se = $data_block['direction'] == 'right' ? 'selected="selected"' : '';
		$html .= '<option value="right" ' . $se . '>' . $lang_block['direction_right'] . '</option>';
		$html .= '</select></td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '	<td>' . $lang_block['scroll'] . '</td>';
		$html .= '	<td><input name="config_scroll" class="form-control w200" value="' . $data_block['scroll'] . '" /></td>';
		$html .= '</tr>';

		return $html;
	}

	function nv_block_config_news_groups_marquee_submit( $module, $lang_block )
	{
		global $nv_Request;
		$return = array( );
		$return['error'] = array( );
		$return['config'] = array( );
		$return['config']['blockid'] = $nv_Request->get_int( 'config_blockid', 'post', 0 );
		$return['config']['numrow'] = $nv_Request->get_int( 'config_numrow', 'post', 0 );
		$return['config']['scroll'] = $nv_Request->get_int( 'config_scroll', 'post', '1' );
		$return['config']['direction'] = $nv_Request->get_title( 'config_direction', 'post', 'left' );
		return $return;
	}

	function nv_block_news_groups_marquee( $block_config )
	{
		global $module_array_cat, $module_info, $site_mods, $module_config, $global_config, $db, $my_head;

		$module = $block_config['module'];

		$db->sqlreset( )->select( 't1.id, t1.catid, t1.title, t1.alias, t1.publtime' )->from( NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_rows t1' )->join( 'INNER JOIN ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_block t2 ON t1.id = t2.id' )->where( 't2.bid= ' . $block_config['blockid'] . ' AND t1.status= 1' )->order( 't2.weight' )->limit( $block_config['numrow'] );
		$list = nv_db_cache( $db->sql( ), '', $module );

		if( !empty( $list ) )
		{
			if( file_exists( NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/news/block_groups_marquee.tpl' ) )
			{
				$block_theme = $module_info['template'];
			}
			else
			{
				$block_theme = 'default';
			}

			if( !defined( 'MARQUEE' ) and file_exists( NV_ROOTDIR . '/themes/' . $block_theme . '/js/marquee.js' ) )
			{
				$my_head .= '<script type="text/javascript" src="' . NV_BASE_SITEURL . 'themes/' . $block_theme . '/js/marquee.js"></script>';
				define( 'MARQUEE', true );
			}

			$xtpl = new XTemplate( 'block_groups_marquee.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/news' );
			$xtpl->assign( 'DATA', $block_config );
			$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
			$xtpl->assign( 'THEME', $global_config['site_theme'] );
			$xtpl->assign( 'MODULE', $module );

			foreach( $list as $l )
			{
				$l['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $module_array_cat[$l['catid']]['alias'] . '/' . $l['alias'] . '-' . $l['id'] . $global_config['rewrite_exturl'];
				$newday = $l['publtime'] + ( 86400 * $module_array_cat[$l['catid']]['newday'] );

				if ( $newday >= NV_CURRENTTIME )
				{
					$xtpl->parse( 'main.loop.newday' );
				}

				$xtpl->assign( 'ROW', $l );
				$xtpl->parse( 'main.loop' );
			}

			$xtpl->parse( 'main' );
			return $xtpl->text( 'main' );
		}
	}

}
if( defined( 'NV_SYSTEM' ) )
{
	global $site_mods, $module_name, $global_array_cat, $module_array_cat;
	$module = $block_config['module'];
	if( isset( $site_mods[$module] ) )
	{
		if( $module == $module_name )
		{
			$module_array_cat = $global_array_cat;
			unset( $module_array_cat[0] );
		}
		else
		{
			$module_array_cat = array( );
			$sql = 'SELECT catid, parentid, title, alias, viewcat, subcatid, numlinks, description, inhome, keywords, groups_view, newday FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_cat ORDER BY sort ASC';
			$list = nv_db_cache( $sql, 'catid', $module );
			foreach( $list as $l )
			{
				$module_array_cat[$l['catid']] = $l;
				$module_array_cat[$l['catid']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
			}
		}
		$content = nv_block_news_groups_marquee( $block_config );
	}
}
