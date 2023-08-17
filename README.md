## Installation

### Clone the repository

    git clone https://github.com/peyas4854/inventory-management.git

### Switch to the repo folder

    cd inventory-management

### Install all the dependencies using composer

    composer install

### Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

### Database configuration

    DB_DATABASE=your_database_name
    DB_USERNAME=your_user_name
    DB_PASSWORD=your_password

### Generate a new application key & storage link create

    php artisan key:generate
    php artisan storage:link

### Create table & dummy data from seeder

    php artisan migrate --seed

### Start the local development server

    php artisan serve

### Credentials

    Admin Panel 
    ======
    Email: admin@gmail.com 
    password - 1234678

## Frontend Setup
    cd frontend
### Project setup
```
npm install
```
### create .env File and  set VUE_APP_API_URL Value with your api url

```
VUE_APP_API_URL : Your_api_url
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).



  
