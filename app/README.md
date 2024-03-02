
![Logo](https://online-qr-generator.com/uploads/main/1702a3070f15169d3114d6a22027f025.png)


# Online QR Code Generator

The Online QR Generator is a easy-to-use tool for creating QR codes. With this website, you can generate QR codes for any URL, PDF, Menu, Business, Images, Vcard, List of Links, Video, WIFI, Mp3, App, Coupon and then download or share the code with others.


## Features

- Generate QR codes with multiple types
- Dynamic QR Codes
- Landing Pages and Live Previews
- Download or share the QR code with others
- Customizable color and size options
- Detailed statistics of each scans
- Light/dark mode


## How to use

- Go to https://online-qr-generator.com
- Enter the data you want to encode in the QR code
- Choose any customization options you want (color, size, etc.)
- Click the "Create" button
- Download or share the QR code as desired


## Tech Stack

**Client:** HTML, CSS, Javascript, JQuery

**Server:** PHP >= 7.4

**Database:** MySQL

**Requirenments**
- PHP	PHP 7.4 - 8.1
- Extensions	cURL, OpenSSL, mbstring, MySQLi
- Database	MySQL 5.7.3+ or MariaDB equivalent
- Server	Apache or Nginx
## Run Locally

- Clone the project

```bash
  git clone https://github.com/increast-team/qr-website.git
```

- Go to the project directory

```bash
  cd qr-new
```

Download Database
[File](https://drive.google.com/file/d/1BgQT5hh1iOz8vMHOvqyK4kBPfN1E04xG/view?usp=sharing)

- Import Database
```bash
  mysql -u {username} -p {database_name} < database.sql
```
*NOTE : You can also import it mannualy via any mysql GUI*

- Download Uploads
[Folder](https://drive.google.com/file/d/1xhRy65FoJPkSgpwHtCkTpBB2zxOnboM6/view?usp=sharing)
and Paste into qr-new (root directory)

- Create the config file
```bash
  mkdir config.php
```
- Paste and update the below block to config.php
```bash
  <?php
/* Configuration of the site */
define('APP_CONFIG', 'local');
define('DATABASE_SERVER',   'localhost');
define('DATABASE_USERNAME', '<Your database username>');
define('DATABASE_PASSWORD', '<Your database password>');
define('DATABASE_NAME',     '<Your database name>');
define('SITE_URL',          'http://localhost/qr-new/');
define('LANDING_PAGE_URL',  'https://scanned.page/');

define('ANALYTICS_DATABASE_SERVER',   'localhost');
define('ANALYTICS_DATABASE_USERNAME', '<Your database username>');
define('ANALYTICS_DATABASE_PASSWORD', '<Your database password>');
define('ANALYTICS_DATABASE_NAME', '<Your database name>');
```
## Documentation

[Documentation](https://66qrcode.com/docs/)


## Deployment

To deploy this project run just Push or Merge the code to main branch

```bash
  git push origin main
```
*Process of deployment:*
As the auto deployment and CI/CD is not available in github for Core PHP we have created the auto deployment via webhooks and SSH deploy key of our DigitalOcean server. You can see the webhook file `githubdeploy.php` in root directory.

[Followed this for setup](https://gist.github.com/zhujunsan/a0becf82ade50ed06115)
