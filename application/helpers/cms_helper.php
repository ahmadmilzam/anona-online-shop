<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function meta_title($string , $base_title)
	{
		return e($string) . ' - ' . e($base_title);
	}
	function btn_edit($uri)
	{
		return anchor($uri, '<i class="icon-edit"></i> Edit', array('class'=>'btn'));
	}
	function btn_delete($uri)
	{
		return anchor($uri, '<i class="icon-white icon-trash"></i> Delete', array('class'=>'btn btn-danger','onClick' => "return confirm('You are about delete a record. This cannot be undone. Are you sure ?');"));
	}

	function readmore($uri)
	{
		return anchor($uri, '<br><b>read more</b>');
	}

	function get_excerpt($article, $limit = 50)
	{
		$string = '';
		$url = 'research/article/' . intval($article['id_article']) . '/' . $article['slug'];
		$string .= '<p class="heading_title">' . anchor($url, $article['title'], array('title' => $article['title'], 'class' => 'url_title')) . '</p>';
		$string .= '<p>' . '<small>On '.date("D, d M Y", strtotime($article['pubdate'])) . '</small>' . '</p>';
		$string .= '<p class="excerpt">' . word_limiter(strip_tags($article['content']), $limit, '') . '</p>';
		$string .= '<p>' . anchor($url, 'Read more', array('title' => $article['title'], 'class' => 'url_title')). '</p>';
		return $string;
	}

	function e($string)
	{
		return htmlentities($string);
	}

	function new_property($object)
	{
		return isset($object) ? $object : '';
	}