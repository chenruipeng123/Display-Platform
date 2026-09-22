# 大屏展示平台（Display-Platform）

一个基于 PHP、MySQL、JavaScript 和 Swiper 的大屏内容展示平台，适用于商超、展厅、市场、企业宣传等场景。平台将首页栏目、分类内容和图片/视频素材组织成可轮播的展示页面，并提供后台管理入口维护展示内容。

> 项目原始版本较早，当前代码使用 PHP 已废弃的 `mysql_*` 扩展。部署前请使用与项目兼容的旧版 PHP 运行环境，或先完成数据库访问层迁移。

## 功能概览

- **多页面展示**：按照页面配置轮播展示不同主题内容。
- **栏目与分类**：支持一级栏目及子栏目导航，适合组织商品、人员、项目等信息。
- **图片与视频播放**：展示页支持读取上传素材，并以轮播方式播放图片或视频。
- **后台管理**：提供登录、验证码和后台管理页面，用于维护展示数据和素材。
- **大屏适配**：前端以固定尺寸布局设计，适合在大屏或横向显示器上运行。
- **本地资源依赖**：项目已包含 jQuery、Swiper、Layui、Ace、PHPExcel、UEditor 等相关资源。

## 在线预览

[http://www.etpt.com.cn/zhanshi/](http://www.etpt.com.cn/zhanshi/)

建议使用 **1920 × 1080** 分辨率查看，以获得更好的展示效果。

## 技术栈

| 类型 | 技术 |
| --- | --- |
| 服务端 | PHP 原生代码 |
| 数据库 | MySQL |
| 前端 | HTML5、CSS、JavaScript、jQuery |
| 交互与轮播 | Swiper、Layui |
| 后台界面 | Ace、Bootstrap、Font Awesome |
| 数据处理 | PHPExcel（项目内置） |

## 目录结构

```text
.
├── admin/             # 后台登录及管理页面
├── css/               # 前台样式、Swiper 样式
├── images/            # 默认图片及界面素材
├── inc/               # 数据库、上传、权限、分页等 PHP 公共类库
│   ├── assets/         # 后台依赖资源
│   ├── PHPExcel/       # PHPExcel 及示例代码
│   └── ueditor/        # UEditor 相关资源
├── js/                # 前台 JavaScript 和轮播逻辑
├── layui/              # Layui 前端资源
├── upFile/pic/         # 上传的图片、视频等展示素材
├── index.php           # 前台首页
├── content.php         # 栏目内容页
├── show.php            # 图片/视频轮播展示页
└── README.md
```

## 环境要求

由于当前版本使用 `mysql_connect`、`mysql_query` 等旧版 PHP MySQL 扩展，建议在隔离的兼容环境中运行：

- Apache 或 Nginx + PHP
- 与项目代码兼容的 PHP 版本及 `mysql` 扩展
- MySQL 数据库
- Web 服务进程对 `upFile/pic/` 具有写入权限

> PHP 7 及更高版本已移除 `mysql_*` 扩展，不能直接运行本项目。生产环境不建议为了运行旧代码而降低 PHP 版本；更推荐将数据库访问改造为 PDO 或 MySQLi，并补充输入校验及权限控制。

## 安装与配置

### 1. 获取代码

```bash
git clone https://github.com/chenruipeng123/Display-Platform.git
cd Display-Platform
```

将项目目录配置为 Web 服务器站点根目录，或配置为虚拟主机的 DocumentRoot。

### 2. 创建数据库

代码默认连接以下数据库配置：

- 主机：`127.0.0.1`
- 数据库：`et_show`
- 用户名：`root`
- 密码：`root`
- 字符集：`utf8`

请先创建 `et_show` 数据库并导入项目对应的数据表及初始数据。数据库连接配置位于 `inc/include.php`，使用前请根据本地环境修改，不要在生产环境使用默认账号和密码。

### 3. 配置上传目录

确认以下目录存在，并允许 Web 服务写入：

```text
upFile/pic/
```

上传的图片和视频会被前台页面从该目录读取。

### 4. 访问项目

- 前台首页：`http://你的域名/项目目录/`
- 后台入口：`http://你的域名/项目目录/admin/login.php`
- 展示页：`http://你的域名/项目目录/show.php?id=栏目ID`

后台登录需要数据库中已有可用的管理员账号，并依赖验证码接口 `inc/captcha.func.php`。

## 使用流程

1. 登录后台管理系统。
2. 创建或维护展示页面及栏目层级。
3. 上传栏目图片、展示图片或视频素材。
4. 设置内容状态和展示顺序。
5. 打开前台首页，在大屏浏览器中进入全屏展示模式。

## 数据与安全说明

本项目是早期版本，部署前请重点检查以下事项：

- 修改 `inc/include.php` 中的数据库账号和密码，并避免将真实凭据提交到公开仓库。
- 对 URL 参数、表单参数和上传文件进行严格校验，当前部分页面直接拼接 SQL 参数。
- 限制上传文件类型、大小和存储路径，禁止上传可执行脚本。
- 为后台启用 HTTPS，并设置强密码及合理的会话安全策略。
- 生产环境关闭详细错误输出，定期备份数据库和 `upFile/pic/` 素材。
- 尽快将旧版 `mysql_*` 数据库接口迁移到 PDO 或 MySQLi，并使用参数化查询。

## 开源协议

项目遵循 [Apache License 2.0](https://www.apache.org/licenses/LICENSE-2.0) 发布。项目中包含的第三方源码和二进制文件，其版权及许可信息以各自目录或文件中的说明为准。

版权所有 © 2020 ChenRuipeng（[vuecho.com](https://vuecho.com)）。

## 反馈与贡献

欢迎提交 Issue 反馈问题或提出改进建议。提交代码前，请确认修改不会破坏现有展示流程，并在兼容的 PHP/MySQL 环境中完成基本验证。
