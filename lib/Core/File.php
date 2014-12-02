<?php

/**
 *
 */
namespace Core;

/**
 * This class help in work with files
 */
class File
{
	/**
	 *
	 */
	private $filename;

	/**
	 *
	 */
	public $upload_dir;

	/**
	 *
	 */
	public $exts = array();

	/**
	 *
	 */
	public function File()
	{
		$this->upload_dir = 'uploads';
	}

	/**
	 *
	 */
	public function setExt( $exts = array())
	{
		if (!empty($exts)) {
			$this->exts = $exts;
		}

		return $this;
	}

	/**
	 *
	 */
	public function setDir( $name )
	{
		$name = trim($name, '/');
		$this->upload_dir = $name;
		return $this;
	}

	/**
	 *
	 */
	public function download($fname)
	{
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . basename($fname));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		readfile($fname);
		die;
	}

	/**
	 *
	 */
	public function upload($name)
	{
		if ( !isset($_FILES[$name]) || empty($_FILES[$name])) {
			return false;
		}

		$file = $_FILES[$name];

		if ( !$file['size'] && !is_array($file['name'])) {
			return false;
		}

		if ( !is_dir($this->upload_dir)) {
			mkdir($this->upload_dir);
		}

		if ($this->checkExt($file['name'])) {
			if (move_uploaded_file($file['tmp_name'], $this->upload_dir . DS . md5($file['name']) . $this->getExt($file['name']))) {
				$this->path = $this->upload_dir;

				$this->filename = md5($file['name']) . $this->getExt($file['name']);
				return true;
			}
		}

		return false;

	}

	/**
	 *
	 */
	public function safeSave($name)
	{
		if ( !isset($_FILES[$name]) || empty($_FILES[$name])) {
			return false;
		}

		$file = $_FILES[$name];

		if ( !$file['size'] && !is_array($file['name'])) {
			return false;
		}

		if ( !is_dir($this->upload_dir)) {
			mkdir($this->upload_dir);
		}

		if ($this->checkExt($file['name'])) {
			$hashname = md5($file['name']);
			$sub1 = substr($hashname, 0, 2);
			$sub2 = substr($hashname, 2, 2);
			$path = $this->upload_dir . DS . $sub1 . DS . $sub2 . DS . $hashname . $this->getExt($file['name']);
			if (move_uploaded_file($path)) {
				$this->path = $this->upload_dir;
				$this->filename = md5($file['name']) . $this->getExt($file['name']);
				return true;
			}
		}

		return false;
	}

	/**
	 *
	 */
	public function getSafePath($filename)
	{
		$path  = '';
		if (!empty($this->upload_dir))
			$path = $this->upload_dir . DS;

		$sub1  = substr($filename, 0, 2);
		$sub2  = substr($filename, 2, 2);
		$path .= $sub1 . DS . $sub2 . DS . $filename;

		if (!file_exists($path))
			return false;

		return $path;
	}

	/**
	 *
	 */
	public function checkExt($fname)
	{
		if (empty($this->exts)) {
			return true;
		}

		preg_match('/\.[a-zA-Z]{2,4}$/', $fname, $res);

		if (in_array($res[0], $this->exts)) {
			return true;
		}

		return false;
	}

	/**
	 *
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 *
	 */
	public function getName()
	{
		return $this->filename;
	}

	/**
	 *
	 */
	public function getFullPath()
	{
		$path = $this->getPath();
		$path = trim($path, '/');
		$path = "{$path}/";

		return $path . $this->getName();
	}

	/**
	 *
	 */
	public function uploadMany($fnames = array())
	{

	}

	/**
	 *
	 */
	public function isFile($fname)
	{
		return is_file($fname);
	}

	/**
	 *
	 */
	public function fileExists($fname)
	{
		return file_exists($fname);
	}

	/**
	 *
	 */
	public function fileInfo($fname)
	{
		if ($this->isFile($fname)&&$this->fileExists($fname))
		{
			return array(
				'type' => filetype($fname),
				'size' => filesize($fname),
				'perms' => fileperms($fname),
				'owner' => fileowner($fname),
				'atime' => fileatime($fname),
				'mtime' => filemtime($fname)
			);
		}
		else
			return array(
			);
	}

	/**
	 *
	 */
	public function isFileExt($ext = array(), $fname)
	{
		if (!empty($ext))
		{
			preg_match('/\.[a-zA-Z]{2,4}$/', $fname, $res);
			if (in_array($res[0], $fname))
				return true;
		}
		return false;
	}

	/**
	 *
	 */
	public function deleteFile($fname)
	{
		if ($this->isFile($fname) && $this->fileExists($fname))
		{
			unlink($fname);
		}
	}

	/**
	 *
	 */
	public function getExt($fname)
	{
		preg_match('/\.[a-zA-Z]{2,4}$/', $fname, $res);
		if (isset( $res[0] )) {
			return $res[0];
		} else {
			return false;
		}
	}

}
