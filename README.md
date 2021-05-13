# 🛠️ Build and Secure a Laravel API

This repo demonstrates how to use [Auth0](https://auth0.com) to secure a Laravel 8 API.

For the full step-by-step tutorial, check out [Build and Secure a Laravel API](https://auth0.com/blog/build-and-secure-laravel-api).

## Prerequisites

- Composer
- PHP >= 7.3
- A [free Auth0 account](https://auth0.com/signup)

## Setup

Grab the repo and install the dependencies.

```bash
git clone git@github.com:auth0-blog/laravel-api-auth.git
cd laravel-api-auth
composer install
```

### Auth0 setup

If you haven't already, sign up for your [free Auth0 account](https://auth0.com/signup).

Once in your dashboard, you need to create and register your Laravel API with Auth0.

- Click on "Applications" > "APIs" in the left sidebar
- Click the "Create API" button
- Enter a "Name" and "Identifier" for your API
- Leave Signing Algorithm as is
- Click "Create"

Leave this tab open as you'll need it soon.

### Environment variables

Rename `.env.example` to `.env`

```bash
mv .env.example .env
```

Open up `.env` and fill in the values for `AUTH0_DOMAIN` and `API_IDENTIFIER`.

To find these values:

- Go to the Laravel API you just registered in your Auth0 dashboard
- Click on the "Quick Start" tab
- Click on "PHP"
- Copy the value for valid_audiences and paste it in as the value for API_IDENTIFIER
- Copy the value for authorized_iss and paste it in as the value for AUTH0_DOMAIN. For this one, omit the `https://` when you paste it in

```
AUTH0_DOMAIN=your-domain.auth0.com
API_IDENTIFIER=https://your-api.com
AUTH0_CLIENT_SECRET=
AUTH0_CLIENT_ID=
```

The last two values can be left empty, but the SDK requires them to exist.

## Database Setup

This demo uses SQLite. Create your database by running:

```bash
touch database/database.sqlite
```

Open up your `.env` file again, find the following variables, and replace them with:

```
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

> Note: You need to use the absolute path to the database.sqlite file you just created as the value for DB_DATABASE. You can usually get this by right-clicking the file in your code editor and clicking "Copy path".

### Migrate and Seed your database

Run the migrations and seed the database with:

```bash
php artisan migrate --seed
```

## Running your app

Run the application with:

```bash
php artisan serve
```

If you get the message that your app key is missing, click on the button to generate one, and then refresh.

## Testing

The endpoints to get all comments and get a single comment should be public and accessible without an access token. Run the following cURL command and you should get a response with all comments.

```bash
curl http://localhost:8000/api/comments -i
```

Now, try to create a comment with the following:

```bash
curl -X POST -H 'Content-Type: application/json' -d '{
  "name": "Lucy",
  "text": "An authorized comment"
}' http://localhost:8000/api/comments -i
```

This should give you an error, as you haven't provided a valid access token.

### Test with an access token

To get an access token, head back to your [Auth0 dashboard](https://manage.auth0.com) and go to your Laravel API page. Click on the "Test" tab and then click the copy symbol under "Response".

Use the following command, but first replace `YOUR_ACCESS_TOKEN_HERE` with the test token you just copied:

```bash
curl -X POST -H 'Authorization: Bearer YOUR_ACCESS_TOKEN_HERE' -H 'Content-Type: application/json' -d '{
    "name": "Lucy",
    "text": "An authorized comment"
}' http://localhost:8000/api/comments -i
```

You should now be able to create a comment! If you ran into any issues, reach out in the [comments of the tutorial](https://auth0.com/blog/build-and-secure-laravel-api) or [feel free to tweet me](https://twitter.com/hollylawly). Thanks!
