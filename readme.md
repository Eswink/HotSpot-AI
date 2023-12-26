# HotSpot AI 热点创作
**基于AI技术的WordPress插件，旨在帮助您分析获取全网热词并帮助构思和写作，提高您网站的整体权重**

- [![GitHub release](https://img.shields.io/github/v/release/Eswink/HotSpot-AI.svg?style=for-the-badge&logo=appveyor)](https://github.com/Eswink/HotSpot-AI/releases/latest)[![GitHub Release Date](https://img.shields.io/github/release-date/Eswink/HotSpot-AI?style=for-the-badge&logo=appveyor)](https://github.com/Eswink/HotSpot-AI/releases)![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/Eswink/HotSpot-AI?style=for-the-badge&logo=appveyor)
- Contributors: ersanwu
- Tags: hotspot,writer,ai
- Requires at least: 5.8
- Tested up to: 6.4.1
- Requires PHP: 7.4
- Stable tag: 1.3.8
- License: GNU General Public License v2.0 or later
- License URI: http://www.gnu.org/licenses/gpl-2.0.html


## Description 简介 ##

> Hotspot使用机器学习算法来分析全网热词，自动生成观点、标题、摘要等内容，并为您提供有关该主题的更多详细信息。通过这种方式，Hotspot可以帮助您快速构思和编写高质量的内容，从而提高您网站的整体权重。

> WordPress插件市场：https://wordpress.org/plugins/hotspot-ai/，搜索「热点创作」即可安装插件！

[作者博客](https://blog.eswlnk.com "作者博客") | [插件教程](https://docs.eswlnk.com "插件教程")

> 开发者交流 ~~大佬吹牛~~ 群：689155556

## Installation 安装教程

1. 进入WordPress仪表盘，点击“插件-安装插件”；
2. 点击界面左上方的“上传按钮”，选择本地提前下载好的插件压缩包hotspot-ai.zip，点击“现在安装”；
3. 安装完毕后，启用”HotSpot AI 热点创作”插件；
4. 通过“设置”->”HotSpot AI 热点创作”进入插件设置界面.
5. 填写相关选项，选择接口，点击保存即可


## FAQ 常见问题

- **文章编辑页面为何没有出现"Hotspot AI Sidebar"选项？**
请保证当前WordPress > 5.8 ，PHP > 7.4，且保证古腾堡编辑器处于启用状态，重新启用插件即可解决当前问题。目前已经支持经典编辑器，开启经典编辑器开关即可！

- **为何无法正常使用热词筛序功能？**
请保证热词筛选的相关项填写正确，相关教程请前往<a href="https://docs.eswlnk.com" rel="friend" title="Eswlnk docs">文档</a>。

## Screenshots 截图
1. 热词筛选截图
2. 设置界面截图
3. 统计分析截图
4. 关于界面截图
5. AI创作截图

## Changelog 更新日志

1.3.8

> 1. 修复登录/注册验证码API接口

1.3.7

> 1. 维护国内接口，修复文章输出逻辑
> 2. 热更新搜图接口，接入全网搜图

1.3.6

> 1. 接口常规维护，请用户及时更新

1.3.5

> 1. 修复国内代理接口，后续将会进行下架处理！


1.3.4

> 1. 重大更新: 修复AI通信接口问题，务必更新！

1.3.3

> 1. 修复热词API接口问题
> 2. 修复一些BUGs

1.3.2.4

> 1. 更新热词筛选接口，更加符合生成标准
> 2. 修复部分浏览器无法正常加载文件，导致无法正常登录的BUG

1.3.2.3

> 1. 小版本迭代


1.3.2.2

> 1. 修复更新问题


1.3.2.1

> 1. 修复自定义接口问题

1.3.2

> 1. 修复经典编辑器的智能搜图问题
> 2. 更换搜图接口为全网搜图接口


1.3.1

> 1. 支持经典编辑器

1.2.5
> 1. 修复免费API接口BUG
> 2. 修复设置界面问题

1.2.4

> 1. 发布稳定版本号

1.2.3

> 1. 新增鉴权
> 2. 新增用户注册接口
> 3. 全网热词不再需要填写百家号cookies，注册用户可直接使用
> 4. 接入新免费API接口

1.2

> 1. 新增SEO分析
> 2. 新增智能搜图
> 3. 优化依赖库



1.1 beta

> 1. 新增API测速接口
> 2. 修复JQuery依赖问题
> 3. 修复热点筛选获取问题

1.1

> 1. 新增教程：https://docs.eswlnk.com
> 2. 新增验证接口
> 3. 优化文件结构
> 4. 优化相关函数
> 5. 优化命名空间
> 6. 优化输出方式 

1.0

> 1. 优化插件目录结构
> 2. 使用更安全的WP REST API

