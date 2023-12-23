# Worker System Project

Welcome to the Worker System project! This system is designed to manage a workforce consisting of three roles: Admin, Worker, and Client. Each role has specific functionalities and permissions to facilitate a seamless workflow.

## Table of Contents

-   [Features](#features)
-   [Prerequisites](#prerequisites)
-   [Installation](#installation)
-   [Console Command](#console-command)
-   [Usage](#usage)
-   [API Documentation](#api-documentation)

## Features

1. **Authentication System:**

    - Login, register, and logout pages for each role (Admin, Worker, Client).

2. **Worker Functionality:**

    - Workers can create, edit, and delete posts.
    - Admin receives notifications when a new post is created by a worker.

3. **Admin Functionality:**

    - Admin can approve, reject, mark as pending, or delete worker-created posts.
    - Admin receives notifications when a new order is placed by a client.
    - Admin earns 5% of the order value for every order placed by a client.

4. **Client Functionality:**

    - Clients can book posts created by workers.
    - Workers receive notifications when a client places a new order.
    - Clients can provide reviews for posts they have tried.

5. **Search and Filters:**
    - Each table includes filters for searching based on specific requirements.

## Prerequisites

Ensure you have the following dependencies installed:

-   PHP version 8.1
-   Laravel framework version 10.10
-   Composer (for package management)

## Installation

1. **Clone the repository:**
   `bash
   git clone https://github.com/karim-boulad0/WorkerSystem.git
`
2. composer install

## Console Command

In this project, we have implemented a custom console command to streamline the process of generating service class files. This command extends the `FileFactoryCommand` class and utilizes stub files to create files with dynamically populated content.

### How to Use

To use the console command, run the following artisan command:

```bash
php artisan make:custom-file ClassName
```

## api documentations

1.  there is a file named WorkerProject.postman_collection.json in the project have the all APIs you can import it using Postman

## usage

1. ``php artisan serve
2. there is a file named WorkerProject.postman_collection.json in the project have the all APIs you can import it using Postman
