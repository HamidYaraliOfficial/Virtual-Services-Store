فروشگاه خدمات مجازی (Virtual Services Store)
یک سایت فروشگاهی کامل برای ارائه خدمات مجازی با PHP و JSON DatabaseA complete e-commerce website for virtual services using PHP and JSON Database一个使用 PHP 和 JSON 数据库的虚拟服务完整电子商务网站  

فارسی (Persian)
درباره پروژه
فروشگاه خدمات مجازی یک پلتفرم کامل برای ارائه خدمات دیجیتال است که با استفاده از PHP و دیتابیس JSON توسعه یافته است. این پروژه با طراحی مدرن و کاربرپسند، امکانات متنوعی را برای کاربران و مدیران فراهم می‌کند.
ویژگی‌ها
طراحی و رابط کاربری

✅ طراحی مدرن و ریسپانسیو
✅ رنگ‌بندی سفید و مینیمال
✅ سازگار با موبایل و دسکتاپ
✅ استفاده از Bootstrap 5
✅ آیکون‌های Bootstrap Icons

عملکرد کاربران

✅ سیستم ثبت‌نام و ورود
✅ داشبورد کاربری
✅ مدیریت پروفایل
✅ سبد خرید پیشرفته
✅ تاریخچه سفارشات

خدمات و فروشگاه

✅ کاتالوگ خدمات کامل
✅ جستجو و فیلتر
✅ دسته‌بندی خدمات
✅ صفحه جزئیات محصول
✅ سیستم امتیازدهی

پرداخت

✅ درگاه پرداخت زرین‌پال
✅ پشتیبانی از حالت تست و عملیاتی
✅ تأیید خودکار پرداخت
✅ صفحه نتیجه پرداخت

پنل مدیریت

✅ داشبورد مدیریت کامل
✅ مدیریت کاربران
✅ مدیریت خدمات
✅ مدیریت سفارشات
✅ مدیریت درگاه پرداخت
✅ تنظیمات سایت

امنیت

✅ رمزنگاری رمز عبور
✅ محافظت از Session
✅ اعتبارسنجی ورودی‌ها
✅ محافظت از CSRF

نصب و راه‌اندازی
پیش‌نیازها

PHP 7.4 یا بالاتر
وب‌سرور (Apache/Nginx)
دسترسی به cURL

مراحل نصب

دانلود و استقرار فایل‌هافایل‌ها را در دایرکتوری وب‌سرور قرار دهید (مانند htdocs یا public_html).  

تنظیم مجوزها  
chmod 755 data/
chmod 644 data/*.json


تنظیم درگاه پرداخت  

وارد پنل مدیریت شوید
به بخش "مدیریت درگاه" بروید
شناسه درگاه زرین‌پال را وارد کنید



حساب مدیر پیش‌فرض

نام کاربری: Admin
رمز عبور: Admin123

ساختار فایل‌ها
├── index.php                 # صفحه اصلی
├── includes/
│   ├── config.php           # تنظیمات
│   └── functions.php        # توابع عمومی
├── pages/                   # صفحات سایت
│   ├── home.php
│   ├── services.php
│   ├── login.php
│   ├── register.php
│   ├── dashboard.php
│   └── ...
├── admin/                   # پنل مدیریت
│   ├── index.php
│   └── pages/
├── assets/                  # فایل‌های استاتیک
│   ├── css/
│   ├── js/
│   └── images/
├── data/                    # دیتابیس JSON
│   ├── users.json
│   ├── services.json
│   ├── orders.json
│   └── ...
├── payment/                 # سیستم پرداخت
└── ajax/                    # درخواست‌های AJAX

کار با API زرین‌پال
تنظیم درگاه

در سایت zarinpal.com ثبت‌نام کنید
درخواست درگاه ارسال کنید
Merchant ID دریافت‌شده را در پنل وارد کنید

تست اتصال

در پنل مدیریت > مدیریت درگاه
دکمه "تست اتصال" را کلیک کنید
در صورت موفقیت، درگاه آماده استفاده است

ویژگی‌های فنی
دیتابیس JSON

عدم نیاز به MySQL
سادگی در نصب و راه‌اندازی
قابلیت پشتیبان‌گیری آسان

ریسپانسیو دیزاین

Bootstrap 5 Framework
سازگار با تمام دستگاه‌ها
UI/UX مدرن و کاربرپسند

امنیت

Password Hashing با PHP
CSRF Protection
Input Validation
Session Security

سفارشی‌سازی
تغییر طرح و رنگ
فایل assets/css/style.css را ویرایش کنید:  
:root {
    --primary-color: #007bff;    /* رنگ اصلی */
    --secondary-color: #6c757d;  /* رنگ ثانویه */
    /* سایر متغیرها... */
}

افزودن خدمات جدید

وارد پنل مدیریت شوید
بخش "مدیریت خدمات" > "افزودن خدمت جدید"

تنظیمات سایت

پنل مدیریت > تنظیمات سایت
نام سایت، توضیحات و سایر تنظیمات

پشتیبانی و به‌روزرسانی
پشتیبان‌گیری
# پشتیبان‌گیری از دیتابیس
cp -r data/ backup/data-$(date +%Y%m%d)/

مشکلات رایج
خطای مجوز دسترسی:  
chmod 755 data/
chmod 644 data/*.json

خطای اتصال به زرین‌پال:  

Merchant ID را بررسی کنید
اتصال اینترنت سرور را چک کنید
تنظیمات SSL سرور را بررسی کنید

لایسنس
این پروژه تحت لایسنس MIT منتشر شده است.
مشارکت
برای مشارکت در پروژه:  

Repository را Fork کنید  
تغییرات خود را اعمال کنید  
Pull Request ارسال کنید

لینک پروژه: GitHub Repositoryاینستاگرام: HamidYaraliOfficial
نکته: این سایت برای استفاده در محیط آزمایشی و آموزشی طراحی شده است. برای استفاده تجاری، تنظیمات امنیتی اضافی و بهینه‌سازی‌های لازم را اعمال کنید.

English
About the Project
The Virtual Services Store is a comprehensive platform for providing digital services, developed using PHP and a JSON database. This project features a modern, user-friendly design and offers a wide range of functionalities for both users and administrators.
Features
Design and User Interface

✅ Modern and responsive design
✅ White and minimal color scheme
✅ Mobile and desktop compatible
✅ Built with Bootstrap 5
✅ Bootstrap Icons for UI elements

User Functionality

✅ Registration and login system
✅ User dashboard
✅ Profile management
✅ Advanced shopping cart
✅ Order history

Services and Store

✅ Complete services catalog
✅ Search and filter functionality
✅ Service categorization
✅ Product details page
✅ Rating system

Payment

✅ ZarinPal payment gateway
✅ Support for test and live modes
✅ Automatic payment verification
✅ Payment result page

Admin Panel

✅ Comprehensive admin dashboard
✅ User management
✅ Service management
✅ Order management
✅ Payment gateway management
✅ Site settings

Security

✅ Password encryption
✅ Session protection
✅ Input validation
✅ CSRF protection

Installation and Setup
Prerequisites

PHP 7.4 or higher
Web server (Apache/Nginx)
cURL access

Installation Steps

Download and Deploy FilesPlace the files in your web server directory (e.g., htdocs or public_html).  

Set Permissions  
chmod 755 data/
chmod 644 data/*.json


Configure Payment Gateway  

Log in to the admin panel
Navigate to "Payment Gateway Management"
Enter your ZarinPal Merchant ID



Default Admin Account

Username: Admin
Password: Admin123

File Structure
├── index.php                 # Main page
├── includes/
│   ├── config.php           # Configuration
│   └── functions.php        # General functions
├── pages/                   # Website pages
│   ├── home.php
│   ├── services.php
│   ├── login.php
│   ├── register.php
│   ├── dashboard.php
│   └── ...
├── admin/                   # Admin panel
│   ├── index.php
│   └── pages/
├── assets/                  # Static files
│   ├── css/
│   ├── js/
│   └── images/
├── data/                    # JSON database
│   ├── users.json
│   ├── services.json
│   ├── orders.json
│   └── ...
├── payment/                 # Payment system
└── ajax/                    # AJAX requests

Working with ZarinPal API
Gateway Setup

Sign up at zarinpal.com
Request a payment gateway
Enter the received Merchant ID in the admin panel

Test Connection

In the admin panel > Payment Gateway Management
Click the "Test Connection" button
If successful, the gateway is ready for use

Technical Features
JSON Database

No need for MySQL
Simple installation and setup
Easy backup capabilities

Responsive Design

Built with Bootstrap 5 Framework
Compatible with all devices
Modern and user-friendly UI/UX

Security

Password hashing with PHP
CSRF protection
Input validation
Session security

Customization
Change Design and Colors
Edit the assets/css/style.css file:  
:root {
    --primary-color: #007bff;    /* Primary color */
    --secondary-color: #6c757d;  /* Secondary color */
    /* Other variables... */
}

Add New Services

Log in to the admin panel
Go to "Service Management" > "Add New Service"

Site Settings

Admin panel > Site Settings
Configure site name, description, and other settings

Support and Updates
Backup
# Backup the database
cp -r data/ backup/data-$(date +%Y%m%d)/

Common Issues
Permission Error:  
chmod 755 data/
chmod 644 data/*.json

ZarinPal Connection Error:  

Verify the Merchant ID
Check the server’s internet connection
Review server SSL settings

License
This project is licensed under the MIT License.
Contribution
To contribute to the project:  

Fork the repository  
Apply your changes  
Submit a Pull Request

Project Link: GitHub RepositoryInstagram: HamidYaraliOfficial
Note: This website is designed for testing and educational purposes. For commercial use, apply additional security settings and optimizations.

简体中文 (Chinese)
项目简介
虚拟服务商店是一个为提供数字服务而设计的完整平台，使用 PHP 和 JSON 数据库开发。该项目采用现代化、用户友好的设计，为用户和管理者提供多种功能。
功能特性
设计与用户界面

✅ 现代响应式设计
✅ 白色极简风格配色
✅ 兼容手机与桌面端
✅ 使用 Bootstrap 5 框架
✅ 使用 Bootstrap Icons 图标

用户功能

✅ 注册与登录系统
✅ 用户仪表板
✅ 个人资料管理
✅ 高级购物车
✅ 订单历史记录

服务与商店

✅ 完整服务目录
✅ 搜索与过滤功能
✅ 服务分类
✅ 产品详情页面
✅ 评分系统

支付

✅ 支持 ZarinPal 支付网关
✅ 支持测试与生产模式
✅ 自动支付验证
✅ 支付结果页面

管理面板

✅ 全面的管理仪表板
✅ 用户管理
✅ 服务管理
✅ 订单管理
✅ 支付网关管理
✅ 网站设置

安全性

✅ 密码加密
✅ 会话保护
✅ 输入验证
✅ CSRF 防护

安装与设置
前提条件

PHP 7.4 或更高版本
网络服务器（Apache/Nginx）
cURL 访问权限

安装步骤

下载并部署文件将文件放置在网络服务器目录中（例如 htdocs 或 public_html）。  

设置权限  
chmod 755 data/
chmod 644 data/*.json


配置支付网关  

登录管理面板
进入“支付网关管理”部分
输入 ZarinPal 的 Merchant ID



默认管理员账户

用户名: Admin
密码: Admin123

文件结构
├── index.php                 # 主页
├── includes/
│   ├── config.php           # 配置文件
│   └── functions.php        # 通用函数
├── pages/                   # 网站页面
│   ├── home.php
│   ├── services.php
│   ├── login.php
│   ├── register.php
│   ├── dashboard.php
│   └── ...
├── admin/                   # 管理面板
│   ├── index.php
│   └── pages/
├── assets/                  # 静态文件
│   ├── css/
│   ├── js/
│   └── images/
├── data/                    # JSON 数据库
│   ├── users.json
│   ├── services.json
│   ├── orders.json
│   └── ...
├── payment/                 # 支付系统
└── ajax/                    # AJAX 请求

使用 ZarinPal API
设置网关

在 zarinpal.com 注册
申请支付网关
将收到的 Merchant ID 输入管理面板

测试连接

在管理面板 > 支付网关管理
点击“测试连接”按钮
如果成功，网关即可使用

技术特性
JSON 数据库

无需 MySQL
安装和设置简单
易于备份

响应式设计

使用 Bootstrap 5 框架
兼容所有设备
现代化、用户友好的 UI/UX

安全性

使用 PHP 进行密码哈希
CSRF 防护
输入验证
会话安全

自定义
更改设计与颜色
编辑 assets/css/style.css 文件：  
:root {
    --primary-color: #007bff;    /* 主颜色 */
    --secondary-color: #6c757d;  /* 副颜色 */
    /* 其他变量... */
}

添加新服务

登录管理面板
进入“服务管理” > “添加新服务”

网站设置

管理面板 > 网站设置
配置网站名称、描述等其他设置

支持与更新
备份
# 备份数据库
cp -r data/ backup/data-$(date +%Y%m%d)/

常见问题
权限错误:  
chmod 755 data/
chmod 644 data/*.json

ZarinPal 连接错误:  

检查 Merchant ID
检查服务器的互联网连接
检查服务器 SSL 设置

许可证
本项目基于 MIT 许可证发布。
贡献
参与项目的方式：  

Fork 仓库  
应用更改  
提交 Pull Request

项目链接: GitHub RepositoryInstagram: HamidYaraliOfficial
注意: 本网站专为测试和教育用途设计。用于商业用途时，请应用额外的安全设置和优化。