<?php
class Zend_View_Helper_ProductImg extends Zend_View_Helper_HtmlElement
{
//	private $_attrs;
	
//	public function productImg($imgFile, $attrs = false)
	public function productImg($imgFile)
	{
		if (empty($imgFile)) {
			$imgFile = 'default.jpg';
		}
//		if (null !== $attrs) {
//			$_attrs = $this->_htmlAttribs($attrs);
//		} else {
//			$_attrs = '';
//		}
//		$tag = '<img src="' . $this->view->baseUrl('import/' . $imgFile) . '" ' . $_attrs . '>';
		$tag= $this->view->baseUrl('import/' . $imgFile);
		return $tag;
	}
}