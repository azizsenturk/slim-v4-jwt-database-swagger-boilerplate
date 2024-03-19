# Slim 4 JWT Database Swagger Boilerplate

[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://github.com/azizsenturk/slim-v4-jwt-database-swagger-boilerplate/blob/master/LICENSE)

A skeleton of a project prepared for Slim Framework v4 developed with PHP, containing features such as JWT Token system, database connection, file upload processes, error/exception handling, Swagger documentation, etc.

## Features

- **JWT Authentication**: System for authentication using JWT tokens
- **Database Management**: Easy-to-use database management with [izniburak\pdox](https://github.com/izniburak/pdox)
- **File Uploads Operations**: Folder-based file upload management
- **Image Resizing and Cropping Operations**: Resizing and cropping images using [gumlet/php-image-resize](https://github.com/gumlet/php-image-resize)
- **Error / Exception Handling**: Customized Error Handling
- **Authentication Controller**: Example authentication controller
- **CRUD Operations**: Examples of basic data operations (create, read, update, delete)
- **Environment Variables**: Configuration settings for `local` and `production` environments
- **Allowing Origins**: Allowed sources for CORS
- **Swagger Documentation**: Swagger for testing and documentation
- **Snippets**: Ready-to-use code snippets for VSCode

## Installation

```bash
  composer install
```

## Run Project

*You can use the `composer` tool if you want to run the project, or you can access it directly via `localhost`.*

#### Using Directly

> Go to `http://localhost/your-project-folder`

#### Using Composer  

  ```bash
    composer start

    # Go to `http://localhost:8080`
  ```

## Creating a New Path

1. Open a new controller file under the src/App/Controller directory. Add CRUD functions using the `controller` snippet. Customize it as you wish.
2. Open a new repository file under the src/App/Repository directory. Add CRUD functions using the `repository` snippet. Customize it as you wish.
3. Don't forget to add your new files to Repositories.php and Routes.php files under the src/Core/Config directory.

## Settings and Features Detail

#### Database Sample

> You can access the sample database in the `@exampleDB` folder.

#### Allow Origins

> Add your allowed origins to the `src/Core/Config/AllowedOrigins.php` file.

#### Swagger Documentation

> Go to `http://localhost/your-project-folder/v1/swagger`

#### Environment Variables

| Name | Default Value |
| --- | --- |
| PROJECT_NAME | `Your Project Name` |
| PROJECT_DOMAIN | `http://localhost/your-project-folder` |
| SWAGGER_VERSION | `1.0.0` |
| SWAGGER_SECRET | `c3dhZ2dlcg` |
| SWAGGER_TEST_BEARER_TOKEN | `Your Project API` |
| DATABASE_HOST | `localhost` |
| DATABASE_NAME | `example_db` |
| DATABASE_USER | `root` |
| DATABASE_PASS | `root` |
| DATABASE_PREFIX | ` ` |
| JWT_SECRET | `!2Kb#G7@P$z&4*dQ` |
| JWT_ISSUER | `2W_Creative` |
| JWT_AUDIENCE | `YOUR_APP_NAME` |
| JWT_EXPIRE_DAY | `90` |
| IMAGE_RESIZE_LONG_SIDE | `1024` |
| IMAGE_CROP_SIZE | `1024` |
| SHOW_ERROR_REPORTING | `false` |

#### VSCode Snippets
| Snippet | Description |
| --- | --- |
| `controller` | Create a new controller |
| `controller-get` | Create a new GET method for controller |
| `controller-post` | Create a new POST method for controller |
| `controller-put` | Create a new PUT method for controller |
| `controller-delete` | Create a new DELETE method for controller |
| `repository` | Create a new repository |
| `repository-getall` | Create a new getAll method for repository |
| `repository-getsingle` | Create a new getsingle method for repository |
| `repository-create` | Create a new create method for repository |
| `repository-update` | Create a new update method for repository |
| `repository-delete` | Create a new delete method for repository |

### Min Recommended Version

PHP: **8.0**

### Authors

- [@azizsenturk](https:///azizsenturk.com)
