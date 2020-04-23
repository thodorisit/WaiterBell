<img width="300" alt="waiterbell logo" src="https://user-images.githubusercontent.com/3685481/80137226-a3122a80-85ab-11ea-9f60-d5dbc49a4cc9.png">

## Welcome to WaiterBell random person!

WaiterBell is an application that helps your customers call the employees of your business easily without having to stand up, shout or move their hands in an abnormal way. Customers are not referees!

### How it works
The customer scans the QR code that belongs to his table (label) and he gets redirected to a web page where there is a list of possible requests. He selects one request and instantly the business and all the employees that are connected to this label are getting notified via web push notifications.

## Let's get started, step by step

First things first, you have to create a database and update the .env file with the correct credentials.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
Update and all other necessary variables in .env file (APP_KEY, ...)!

Install the required packages.
```
composer install
```

Generate database tables and relations.
```
php artisan migrate
```


## How to set up web push notifications

You have to create a Google Firebase app, that's how the application will send web push notifications.
Now you have to update the .env file with the correct Firebase key.
```
FIREBASE_KEY=
```

Now, edit the "public/vendor/web-push/firebase-script.js" file and update with the correct credentials the javascript object below.
```
var firebaseConfig = {
    apiKey: "",
    authDomain: "",
    databaseURL: "",
    projectId: "",
    storageBucket: "",
    messagingSenderId: "",
    appId: "",
    measurementId: ""
};
```

In the same folder you have to update the "public/vendor/web-push/manifest.json" file with the correct credentials.
```
{
    "name": "",
    "gcm_sender_id": ""
}
```

The last update you have to do to make web push notifications work, is in the  "public/firebase-messaging-sw.js" file. This file is the service worker that firebase needs.
```
var firebaseConfig = {
    apiKey: "",
    authDomain: "",
    databaseURL: "",
    projectId: "",
    storageBucket: "",
    messagingSenderId: "",
    appId: "",
    measurementId: ""
};
```


## Create or Delete a business

As you will see in the .env file, there is an option
```
MASTER_ACCESS=1
MASTER_SECURITY_KEY=098f6bcd4621d373cade4e832627b4f6
```

The "MASTER_ACCESS=1" allows the user to CREATE or DELETE a business. WaiterBell supports multiple business accounts out of the box, so you don't have to host multiple laravel apps.

The "MASTER_SECURITY_KEY={string}" is the md5 hashed password that gives access to the Master Controller which contains the methods for creating or deleting businesses. ("098f6bcd4621d373cade4e832627b4f6" equals to "test")

### Now you will wonder, ok, how do I create or delete a business?

#### To create a business, you have to visit the link below:
```
your-domain.com/master/create_business?securiy_key={MASTER_SECURITY_KEY}&business_username={username}&business_password={password}
```
```
{MASTER_SECURITY_KEY} is the unhashed MASTER_SECURITY_KEY key (for example "098f6bcd4621d373cade4e832627b4f6" equals to "test").
{username} is the username which will use the business to login to the platform.
{password} is the password (plan-text) which will use the business to login to the platform.
```

#### To delete a business, you have to visit the link below:
```
your-domain.com/master/delete_business?securiy_key={MASTER_SECURITY_KEY}&business_id={id}
```
```
{MASTER_SECURITY_KEY} is the unhashed MASTER_SECURITY_KEY key (for example "098f6bcd4621d373cade4e832627b4f6" equals to "test").
{id} is a unique id which will be given to your account automatically and you can get it by visiting the homepage.
```

##### Your should use the browser in incognito mode to keep passwords secure.

You can create a md5 hashed string using the link below:
```
your-domain.com/master/md5?value={string}
```

After you have finished creating or deleting business accounts, edit the .env file and set
```
MASTER_ACCESS=0
```

### Now it's time for the good part...

## WaiterBell consists of three subapplications.
#### [1. Business app](https://github.com/thodorisit/WaiterBell#1-business-app-1)
#### [2. Employee app](https://github.com/thodorisit/WaiterBell#2-employee-app-1)
#### [3. Customer app](https://github.com/thodorisit/WaiterBell#3-customer-app-1)



* ## 1. Business app

To access business app you have to visit the link below:
```
your-domain.com/business/login
```
Now you have to insert the login credentials and you will be redirected to the homepage of the administration panel.

<img style="width:100%;" alt="waiterbell logo" src="https://user-images.githubusercontent.com/3685481/80146109-f7bca200-85b9-11ea-86e3-fcc0dc6c3614.png">

Homepage shows some usefull information about the business account.
If you have successfully setted up Web Push Notifications and your browser supports it, you can click on the "Subscribe device" button.

<img style="width:100%;" alt="waiterbell logo" src="https://user-images.githubusercontent.com/3685481/80146525-a3fe8880-85ba-11ea-9448-56d465252e27.png">

From now on, you will receive a push notification for every request a customer makes.

Let's take a mouse (...walk) in the administration panel.

* ### Employees

You can create, edit, delete employees. The password (PIN) of an employee is not being saved as a hash string, it is being saved as plain-text.

<img style="width:100%;" alt="waiterbell logo" src="https://user-images.githubusercontent.com/3685481/80147042-8847b200-85bb-11ea-8e26-af11aff64a13.png">

* ### Labels

You can create, edit, delete labels. Labels are the seats, tables etc...
You can restrict access to the labels by defining the allowed IP addresses in each label or globally from the settings (continue to the settings).

<img style="width:100%;" alt="waiterbell logo" src="https://user-images.githubusercontent.com/3685481/80147170-c349e580-85bb-11ea-843f-07294932dd7c.png">

* ### Connect Labels - Employees

When you connect a label to an employee, each time a customer submits a request, all the connected employees that have subscribed to Push Notifications will get notified.

<img style="width:100%;" alt="waiterbell logo" src="https://user-images.githubusercontent.com/3685481/80147417-263b7c80-85bc-11ea-8f5d-34f95e44d384.png">

* ### Languages - Languages

There are 182 available languages to add for your customers! The languages you add, are only for the customers part. If you want to translate WaiterBell's business' and employee's panel, use the default Laravel Localization system.

<img style="width:100%;" alt="waiterbell logo" src="https://user-images.githubusercontent.com/3685481/80147510-44a17800-85bc-11ea-9c2c-364882c1b3d1.png">

* ### Languages - Translations

There are some necessary phrases that need to be translated to the languages you have added!

<img style="width:100%;" alt="waiterbell logo" src="https://user-images.githubusercontent.com/3685481/80147547-5420c100-85bc-11ea-8f40-4c31ffee53eb.png">

* ### Requests for Customers

These are the available requests a customer can make via the web app. All the requests need to be translated to the languages you have added previously.

<img style="width:100%;" alt="waiterbell logo" src="https://user-images.githubusercontent.com/3685481/80148545-dfe71d00-85bd-11ea-9a24-74a6aa4a8a47.png">

* ### Notifications

If you have subscribed to push notifications and you have the admin panel opened, you will get notified with a toast.

<img style="width:100%;" alt="waiterbell logo" src="https://user-images.githubusercontent.com/3685481/80148958-7f0c1480-85be-11ea-8980-80f1e90644b7.png">

You can check and search through all notifications by using the search form. This is how the list is going to look like.

<img style="width:100%;" alt="waiterbell logo" src="https://user-images.githubusercontent.com/3685481/80149262-078ab500-85bf-11ea-83a6-50e7a290b640.png">

* ### Settings

You can update business information.
#### But the most important part is the global firewall for the customers web app. You can add specific IP addresses (e.g. IP address of your business), so users outside your network will not be able to make requests and they will be redirected to 404!

<img style="width:100%;" alt="waiterbell logo" src="https://user-images.githubusercontent.com/3685481/80149898-1cb41380-85c0-11ea-876b-b1e6fa641841.png">



* ## 2. Employee app

To access employee app you have to visit the link below:
```
your-domain.com/employee/login
```
Now you have to insert the login credentials (Business ID, Employee ID, Password (pin)) and you will be redirected to the homepage of the administration panel.

<img style="width:100%;" src="https://user-images.githubusercontent.com/3685481/80151625-0c516800-85c3-11ea-9070-9996a6bc8c53.png">


* ## 3. Customer app

A customer can access a label using the following links
```
your-domain.com/{label_id}
your-domain.com/customer/home?label_id={label_id}
```
<img style="width:100%;" src="https://user-images.githubusercontent.com/3685481/80152391-3f482b80-85c4-11ea-99ee-457dc1454bc3.png">

#### Built With
* ##### [LARAVEL](https://laravel.com/)
* ##### [SB ADMIN 2](https://github.com/BlackrockDigital/startbootstrap-sb-admin-2)
* ##### [GOOGLE FIREBASE](https://firebase.google.com/)

### License
This project is licensed under the MIT License

##### Crafted by Thodoris Itsios (https://itsios.eu)
