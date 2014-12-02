<?php

	namespace Core;
	/*
	 * HTML helper class
	 * Using for generation html tags
	 */
	class Html
	{

		public function __construct()
		{
		}

		// make a string attribute = value ...
		public static function makeAttrString($attr = array())
		{
			$attributes = '';
			foreach ($attr as $key => $value) {
				$attributes .= $key . '="' . $value .'"';
			}
			return $attributes;
		}

		public static function addAttr($array, $attr)
		{
			return array_merge($array, $attr);
		}

		public static function tag($tagname, $options = '', $content = null)
		{
			$tag = '<'. $tagname .' ' . $options;
			if ($content !== null)
				$tag .= '>' . $content . '</' . $tagname . '>';
			else
				$tag .= '/>';
			return $tag;
		}

		public static function link($href,$anhor, $attr)
		{
			$attributes['href'] = $href;
			if (is_array($attr))
			{
				$attributes = self::addAttr($attributes, $attr);
			}
			else
				Error::view('its not an array!');
			$attributes = self::makeAttrString($attributes);
			return self::tag('a', $attributes, $anhor);
		}

		public static function image($src,$attr)
		{
			$attributes['src'] = $src;
			if (is_array($attr))
			{
				$attributes = self::addAttr($attributes, $attr);
			}
			else
				Error::view('its not an array!');
			$attributes = self::makeAttrString($attributes);
			return self::tag('img', $attributes);
		}

		public static function textArea($name, $content, $attr)
		{
			if (!empty($name))
				$attributes['name'] = $name;
			$attributes = self::addAttr($attributes, $attr);
			$attributes = self::makeAttrString($attributes);
			return self::tag('textarea', $attributes, $content);
		}

		public static function input($type, $value, $attr)
		{
			if (empty($type))
				Error::view('dont find the type of input!');
			$attributes['type'] = $type;
			$attributes['value'] = $value;
			$attributes = self::addAttr($attributes, $attr);
			$attributes = self::makeAttrString($attributes);
			return self::tag('input', $attributes);
		}

		public static function dropDownBox($name, $values = array(), $attr)
		{
			$attributes['name'] = $name;
			$attributes = self::addAttr($attributes, $attr);
			$attributes = self::makeAttrString($attributes);
			foreach ($values as $key=>$val)
			{
				$options .= self::tag('option', 'value="' . $key . '"', $val);
			}
			return self::tag('select', $attributes, $options);
		}

		public static function listBox($name, $values = array(), $attr, $size = 4, $multi = true)
		{
		}

		public static function checkListBox($name, $values = array(), $attr)
		{
			$attributes['name'] = $name;
			$attributes = self::addAttr($attributes, $attr);
			foreach ($values as $key=>$val)
			{
				$group .= self::input('checkbox', $val, $attributes);
			}
			return $group;
		}

		public static function radioBox($name, $values = array(), $attr)
		{
			$attributes['name'] = $name;
			$attributes = self::addAttr($attributes, $attr);
			foreach ($values as $key=>$val)
			{
				$group .= self::input('radiobox', $val, $attributes);
			}
			return $group;
		}

		public static function form($action = '', $method = 'post', $attr, $content)
		{
			$attributes['action'] = $action;
			$attributes['method'] = $method;
			$attributes = self::addAttr($attributes, $attr);
			$attributes = self::makeAttrString($attributes);
			return self::tag('form', $attributes, $content);
		}

		public static function beginForm($action = '', $method = 'post', $attr)
		{
			$attributes['action'] = $action;
			$attributes['method'] = $method;
			$attributes = self::addAttr($attributes, $attr);
			$attributes = self::makeAttrString($attributes);
			return '<form '.$attributes.' >';
		}

		public static function endForm()
		{
			return '</form>';
		}

		public static function scriptFiles($urls)
		{
			$scripts = '';
			if (is_array($urls))
				$base = Config::get('public');
				$base = $base['js'];
				foreach ($urls as $url) {
					$scripts .= '<script type="text/javascript" src="' . $base . $url . '"></script>';
				}
			return $scripts;
		}

		public static function getScript($content = '', $attr = array())
		{
			$attributes = self::makeAttrString($attr);
			return self::tag('script', $attributes, $content);
		}

		public static function cssFiles($urls)
		{
			$links = '';
			if (is_array($urls))
			{
				$base = Config::get('public');
				$base = $base['css'];
				foreach ($urls as $url) {
					$links .= '<link rel="stylesheet" type="text/css" href="'. $base . $url.'"/>';
				}
			}
			return $links;
		}
	}
