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
        return ParsedownExtra::instance()
            ->setBreaksEnabled(true)
            ->text($text);
    }
}
