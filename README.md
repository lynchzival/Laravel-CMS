<div id="top"></div>

<h3 align="center">Laravel CMS</h3>

  <p align="center">
    a completely rewritten CMS from previous project with Laravel, flash with new features.
  </p>
  
  ![homepage_screenshot](https://raw.githubusercontent.com/lynchzival/Laravel-CMS/main/screenshot/Screenshot%202022-04-11%20at%2010-31-38%20Home.png)
</div>

### Built With

* [Laravel](https://laravel.com)
* [Bootstrap](https://getbootstrap.com)
* [JQuery](https://jquery.com)

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- GETTING STARTED -->
## Getting Started

To get a local copy up and running follow these simple steps.

### Prerequisites

* [Download Composer](https://getcomposer.org/download/)
* [Download XAMPP](https://www.apachefriends.org/index.html)
* [PHP intl extension](https://www.php.net/manual/en/book.intl.php)
* [Create Stripe Account](https://stripe.com/)
* [Create Mailtrap Account](https://mailtrap.io/)

1. In **Stripe**, create subscription plans in product section with recurring option.
  ![stripe_screenshot](https://raw.githubusercontent.com/lynchzival/Laravel-CMS/main/screenshot/Screenshot%202022-04-11%20at%2015-37-00%20Products%20%E2%80%93%20New%20Business%20%E2%80%93%20Stripe%20Test.png)
2. In **Mailtrap**, create new inbox
  ![mailtrap_screenshot](https://raw.githubusercontent.com/lynchzival/Laravel-CMS/main/screenshot/Screenshot%202022-04-11%20at%2015-42-33%20Mailtrap%20-%20Safe%20Email%20Testing.png)

### Installation

1. Get your api key from [Stripe](https://dashboard.stripe.com/test/apikeys) & SMTP settings from [Mailtrap](https://mailtrap.io/inboxes) inbox.
   
   ![stripe_api](https://raw.githubusercontent.com/lynchzival/Laravel-CMS/main/screenshot/6050469652bc9a2aa6ea39ef25bd4980a723ad2a.png)
   ![mailtrap_api](https://raw.githubusercontent.com/lynchzival/Laravel-CMS/main/screenshot/Screenshot%202022-04-11%20at%2019-44-52%20Mailtrap%20-%20Safe%20Email%20Testing.png)
2. Clone the repo
   ```sh
   git clone https://github.com/lynchzival/Laravel-CMS.git
   ```
3. Copy and rename .env.example to .env
4. Update config information in `.env`
   ```env   
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT="YOUR DB PORT"
   DB_DATABASE="YOUR DB NAME"
   DB_USERNAME="YOUR DB USERNAME"
   DB_PASSWORD="YOUR DB PASSWORD"
   
   STRIPE_KEY="YOUR STRIPE PUBLISHABLE KEY"
   STRIPE_SECRET="YOUR STRIPE SECRET KEY"
   
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME="YOUR MAILTRAP GIVEN USERNAME"
   MAIL_PASSWORD="YOUR MAILTRAP GIVEN PASSWORD"
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="ANY EMAIL YOU WANT"
   MAIL_FROM_NAME="${APP_NAME}"
   ```
5. Install Composer dependencies
   ```sh
   composer install
   ```
6. Generate Laravel application key
   ```sh
   php artisan key:generate
   ```
7. Database migration & seeding
   ```sh
   php artisan migrate
   php artisan db:seed
   ```
8. Run project
   ```sh
   php artisan serve
   ```

<p align="right">(<a href="#top">back to top</a>)</p>

<!-- FEATURES -->
## Features

- Account login & registration
- Profile Management
- Roles
  - Admin
    - Articles Management
    - Users Management
    - Categories Management
    - **Default Account: admin@email.com/admin**
  - Author
    - Self Articles Management
    - Followers Feature
    - **Default Account: author@email.com/author**
  - Reader
    - Premium Subscription
    - Article Like, Saved, Comment
    - Followings Feature
    - Public/Private Profile
    - **Default Account: reader@email.com/reader**

<p align="right">(<a href="#top">back to top</a>)</p>
