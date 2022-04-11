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
* [Download XAMPP (For SQL Connection)](https://www.apachefriends.org/index.html)
* [Create Stripe Account](https://stripe.com/)
* [Create MailTrap Account](https://mailtrap.io/)

### Installation

1. Get your public & secret api key from [Stripe](https://stripe.com) & [MailTrap](https://mailtrap.io)
2. Clone the repo
   ```sh
   git clone https://github.com/lynchzival/Laravel-CMS.git
   ```
3. Rename .env.example to .env
4. Generate Laravel application key
   ```sh
   php artisan key:generate
   ```
5. Update config information in `.env`
   ```env
   APP_KEY="YOUR GENERATED KEY"
   
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT="YOUR DB PORT"
   DB_DATABASE="YOUR DB NAME"
   DB_USERNAME="YOUR DB USERNAME"
   DB_PASSWORD="YOUR DB PASSWORD"
   
   STRIPE_KEY="YOUR STRIPE PUBLIC KEY"
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
6. Install Composer dependencies
   ```sh
   composer install
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
