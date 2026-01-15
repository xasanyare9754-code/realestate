# Git Deployment Guide for cPanel

This guide covers how to deploy your Laravel application using Git.

## Prerequisites
1.  **Git Repository**: You need a remote repository (GitHub, GitLab, Bitbucket, or hosted on cPanel).
2.  **SSH Access**: Highly recommended for running composer commands on cPanel.

## Scenario A: Build on Server (Recommended if Node/NPM/Composer available)
*Use this if your server allows running `npm run build` and `composer install`.*

1.  **Prepare your code**:
    ```bash
    git add .
    git commit -m "Prepare for deployment"
    git push origin main
    ```

2.  **Clone on cPanel**:
    *   Navigate to the directory where you want the app (e.g., `~/repositories/realestate`).
    *   `git clone <your-repo-url> .`

3.  **Install Dependencies (SSH)**:
    ```bash
    cd ~/repositories/realestate
    composer install --optimize-autoloader --no-dev
    npm install
    npm run build
    ```

4.  **Configure**:
    *   Copy `.env.example` to `.env` and update database credentials.
    *   Run `php artisan key:generate`.
    *   Run `php artisan migrate`.
    *   Run `php artisan storage:link`.

5.  **Go Live (Document Root Method)**:
    *   In cPanel **Domains**, change the **Document Root** of your domain to point to your repository's public folder:
        *   Path: `/home/user/repositories/realestate/public`

## Scenario B: Build Locally (If server has no Node/NPM)
*Use this if your server cannot run `npm run build`.*

1.  **Modify .gitignore**:
    *   Open `.gitignore`.
    *   Remove or comment out `/public/build`.
    *   This allows you to commit your compiled CSS/JS assets.

2.  **Build and Commit**:
    ```bash
    npm run build
    git add .
    git commit -m "Deploy with built assets"
    git push origin main
    ```

3.  **Deploy on Server**:
    *   Clone your repo as in Scenario A.
    *   Run `composer install --optimize-autoloader --no-dev`.
    *   (Skip npm steps).
    *   Follow the "Configure" and "Go Live" steps from Scenario A.
