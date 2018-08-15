# ParsedownExtra for Typecho

### 主要特性

- 使用更高效的 ParsedownExtra 解析器替换 Typecho 内置的 Markdown 解析器
- 内置 [ParsedownExtra](https://github.com/erusev/parsedown-extra "ParsedownExtra") 版本：0.8.0-beta-1
- 内置 [Parsedown](https://github.com/erusev/parsedown "Parsedown") 版本：1.8.0-beta-5
- 支持全部 Markdown 基本语法及 ToC（Table of Contents）、Emoji表情、Task lists、@链接等 Markdown 扩展语法
- ParseDown 主旨：One File  //  Super Fast  //  Extensible  //  GitHub Flavored 
- Parsedown 项目主页：http://parsedown.org/
- Demo: http://parsedown.org/demo

### 使用说明

启用前请将插件目录重命名为ParsedownExtra。

### 其他

- 由 kokororin 开发的 [typecho-plugin-Parsedown](https://github.com/kokororin/typecho-plugin-Parsedown "typecho-plugin-Parsedown") 已经一年半没更新了（截至2018-08-15），Parsedown 已经由那时的 1.6.0 更新至 1.8.0。
- 本人也是 Typecho 用户，由于无法忍受 marked.js 的庞大加载体积（我的VPS带宽仅1M），因此在近期的博客重建过程中重制了这一插件，在更新 Parsedown 至最新版本的同时纳入了支持 Markdown 扩展语法的 Parsedown Extra。
- 本插件只接管前台内容解析（文章内容，独立页面和评论），不会接管后台编辑器的解析。
- 如在使用过程中发现 BUG，欢迎提交 Issue 共同讨论。