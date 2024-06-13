# Yii2 Social and Email Authentication

This repository contains a Yii 2 Framework application that implements user authentication using social media platforms and traditional email/password methods. The supported authentication methods include:

- Sign in with Google
- Sign in with Facebook
- Sign in with Twitter
- Traditional email/password authentication

## Features

- **Social Media Authentication**: Users can sign in using their Google, Facebook, or Twitter accounts.
- **Email/Password Authentication**: Traditional method for user registration and login using email and password.
- **User Management**: Admin panel to manage users, view authentication methods used, and control user access.
- **Security**: Enhanced security measures including OAuth for social logins and hashed passwords for email/password authentication.

## Table of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Screenshots](#screenshots)
- [Contributing](#contributing)
- [License](#license)

## Installation

### Prerequisites

- PHP 7.4 or higher
- Composer
- MySQL or MariaDB
- Web server (e.g., Apache, Nginx)

### Steps

1. **Clone the repository**:
   git clone https://github.com/esdy/yii2-auth.git
   cd yii2-auth
 
2. **Install Dependencies**:
	composer install

3. **Set up the database**:

Create a new database and update the database configuration in config/db.php.

4. **Configure your web server** to point to the `web/` directory.
## Configuration
### Social Media Authentication
**Google**:

Create a new project in the Google Developer Console.
Enable the Google+ API.
Create OAuth 2.0 credentials and set the redirect URI to http://yourdomain.com/site/auth?authclient=google.
Copy the Client ID and Client Secret to config/params.php.
**Facebook**:

- Create a new app in the Facebook Developer Console.
- Set the redirect URI to http://yourdomain.com/site/auth?authclient=facebook.
- Copy the App ID and App Secret to config/params.php.
**Twitter**:

- Create a new app in the Twitter Developer Console.
- Set the redirect URI to http://yourdomain.com/site/auth?authclient=twitter.
- Copy the API Key and API Secret Key to config/params.php.
**Email/Password Authentication**
- Ensure the user table is migrated and configured properly.
- Set up SMTP settings in config/params.php for email-based authentication.
##Usage
###Running the Application
- Start your web server and navigate to the application's URL.
###Accessing the Admin Panel
- Access the admin panel at /admin (e.g., http://yourdomain.com/admin).
###Registering and Logging In
- Users can register using their email and password or sign in with their Google, Facebook, or Twitter accounts.
##Screenshots

- Screenshot of the login page with social media options.


- Screenshot of the admin panel for managing users.

##Contributing
- I welcome contributions! Please follow these steps to contribute:

1. Fork the repository.
2. Create a new branch (git checkout -b feature-branch).
3. Make your changes and commit them (git commit -m 'Add new feature').
4. Push to the branch (git push origin feature-branch).
5. Create a pull request.
##License
This project is licensed under the MIT License. See the LICENSE file for details.