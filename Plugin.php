<?php
/**
 * 使用更高效的 ParsedownExtra 解析器替换 Typecho 内置的 Markdown 解析器
 *
 * @package ParsedownExtra
 * @author Gold John King
 * @version 1.0
 * @link https://github.com/GoldJohnKing/ParsedownExtra-for-Typecho
 */

class ParsedownExtra_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Abstract_Contents')->markdown = array('ParsedownExtra_Plugin', 'markdown');
        Typecho_Plugin::factory('Widget_Abstract_Comments')->markdown = array('ParsedownExtra_Plugin', 'markdown');
    }

    /**
     * 禁用插件
     */
    public static function deactivate()
    {}

    /**
     * 插件设置
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {}

    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {}

    public static function markdown($text)
    {
	require_once dirname(__FILE__) . '/Parsedown.php';
	require_once dirname(__FILE__) . '/ParsedownExtra.php';
        $content ParsedownExtra::instance()
            ->setBreaksEnabled(true)
            ->text($text);
        return preg_match('#^<p> *\[TOC\]\s*</p>$#m', $content) ? self::buildToc($content) : $content;
    }

    /**
    * 增加TOC支持
    * 代码参考自mrgeneralgoo：https://github.com/mrgeneralgoo/typecho-markdown
    */
    public static function buildToc($content)
    {
        $document    = new \DOMDocument();
        $contentType = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">';
        $htmlStart   = '<html><head><meta charset="UTF-8"></head><body>';
        $htmlEnd     = '</body></html>';
        $document->loadHTML($contentType . $htmlStart . $content . $htmlEnd, LIBXML_COMPACT);
        $xpath    = new \DOMXPath($document);
        $elements = $xpath->query('//h1|//h2|//h3|//h4|//h5|//h6');
        if ($elements->length === 0) {
            return $content;
        }
        $tocContent   = '';
        $lastPosition = 0;
        foreach ($elements as $element) {
            sscanf($element->tagName, 'h%d', $currentPosition);
            if ($currentPosition > $lastPosition) {
                // parents start
                $tocContent .= '<ul>' . PHP_EOL;
            } elseif ($currentPosition < $lastPosition) {
                // Must have brother if style of title is right
                // brother's grandchild end
                // brother's child end
                // brother end
                $tocContent .= '</li></ul></li>' . PHP_EOL;
            } else {
                // brother end
                $tocContent .= '</li>' . PHP_EOL;
            }
            if ($element->hasAttribute('id')) {
                $id = $element->getAttribute('id');
            } else {
                $id = md5($element->textContent);
                $element->setAttribute('id', $id);
            }
            // child start
            $tocContent   .= '<li><a href="#' . $id . '">' . $element->textContent . '</a>' . PHP_EOL;
            $lastPosition = $currentPosition;
        }
        // child end and parents end
        $tocContent .= '</li></ul>';
        return preg_replace(['#^<p> *\[TOC\]\s*</p>$#m', "#$contentType#", "#$htmlStart#", "#$htmlEnd#"], [$tocContent], $xpath->document->saveHTML());
    }

}
