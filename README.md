<p align="center"><a href="https://nuraweb.com" target="_blank"><img src="https://cdn.nurasoftware.com/img/logo/nuraweb/logo-bg-white.png" alt="NuraWeb Logo"></a></p>

<p><b>High performance website builder for businesses, companies, presentation websites or personal websites. Create a websites in just a few hours, without any development knowledge.</b></p>

Author: [Gabriel Chimilevschi](https://github.com/chimilevschi)

## About NuraWeb

NuraWeb is an open source website builder. Building a professional website without coding.

<b>Core features:</b>
- Optimized for speed and performance.
- Multi-lingual website builder.
- Template builder with content blocks.
- Homepage builder
- Create unlimited pages
- Navigation menu management
- Footer builder (with content blocks)
- Users roles and internal permissions
- Recycle Bin (recover deleted items: deleted accounts, deleted pages, deleted contact messages).

Create professional pages (full responsive) using content blocks. 

<b>Choose from this block types:</b>
- Text editor (text with formating options using WYSIWYG editor)
- Simple text
- Image / Banner
- Images Gallery
- Video
- Cards
- Hero
- Slider
- Accordion
- Google Map
- Alerts
- Blockquote
- Testimonial
- Custom code

<b>Technical details:</b>
- Backend: Laravel framework (version 11)
- Frontend: Laravel Blade and Bootstrap 5.
- PHP 8.2
- Full responsive template (backend and frontend)

## Installation
NuraWeb utilizes Composer to manage its dependencies. So, before using NuraWeb, make sure you have Composer installed on your machine.

You can install NuraWeb by issuing the Composer create-project command in your terminal:

```composer create-project nurasoftware/nura-web --prefer-dist mywebsite```

After creating the project move to the project folder eg: cd mywebsite and run the command to set up database, configuration files, setup default language and create the initial admin account:

```php artisan nura:install```

Run this command to generate a fresh application key:
```php artisan key:generate```

Install is done. You can login as administrator:
```https://your-website-url/login```

## License

NuraWeb is open-sourced software licensed under the [GPL-3.0 license](https://opensource.org/license/gpl-3-0).

NuraWeb is powered by [Nura Software](https://nurasoftware.com)
