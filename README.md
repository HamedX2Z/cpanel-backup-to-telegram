# PHP Telegram Backup Script 📦🤖

A simple PHP script that creates a full backup of your **MySQL database** and **`public_html` folder** on a cPanel host, compresses it into a `.zip` file, and sends it directly to a Telegram chat using a bot.

---

## 📋 About

This script is designed to automate server backups without needing third-party cloud storage. It’s perfect for developers or sysadmins hosting Telegram bots or PHP apps on shared or cPanel servers and wanting offsite backups via Telegram.

---

## 🚀 Features

- ✅ Dumps your MySQL database  
- ✅ Compresses entire `public_html` directory  
- ✅ Sends backup to Telegram via bot  
- ✅ Easy to schedule using Cron Jobs  
- ✅ Lightweight and requires no external dependencies  

---

## 📁 Contents

- `backup.php` – the main script  
- `README.md` – project info and setup guide  

---

## ⚙️ Setup Instructions

### 1. 📥 Download the Script

Clone the repo or upload `backup.php` to a safe folder in your cPanel home directory (e.g., `/home/username/backup/` — **not** inside `public_html`).

---

### 2. 🛠️ Configuration

Edit the following variables at the top of the script:

```php
$botToken = 'YOUR_TELEGRAM_BOT_TOKEN';        // Get from BotFather
$chatId   = 'YOUR_TELEGRAM_CHAT_ID';          // Use getUpdates to find your ID

$dbHost   = 'localhost';                      // Usually localhost for cPanel
$dbName   = 'your_cpanel_db_name';            // Full DB name
$dbUser   = 'your_cpanel_db_user';
$dbPass   = 'your_cpanel_db_password';

$cpanelUser = 'your_cpanel_username';         // Without domain
You must replace these with your actual cPanel/database/bot credentials.

3. 💬 Get Your Telegram Chat ID
Create a bot via @BotFather

Send a message to your bot

Visit this URL (replacing TOKEN):

bash
Copy
Edit
https://api.telegram.org/bot<TOKEN>/getUpdates
Find your chat.id in the JSON response

4. 🧪 Test the Script Manually
Run the script via command line or a temporary PHP file:

bash
Copy
Edit
php -q /home/your_cpanel_user/backup/backup.php
If successful, a .zip file should be sent to your Telegram chat.

5. 📅 Set Up Cron Job
To automate the backup (e.g., daily at 3 AM):

Log in to cPanel

Go to Cron Jobs

Add a new cron job:

swift
Copy
Edit
0 3 * * * php -q /home/your_cpanel_user/backup/backup.php
📌 Make sure PHP path and file path are correct.

💡 Tips
Ensure mysqldump is available on your server (most cPanel hosts support it).

Don’t store backups inside public_html to avoid exposing them to the internet.

Telegram has a file size limit (approx. 50 MB for bots). If needed, consider excluding large folders or splitting files.

🤝 Contributing
Suggestions, improvements, or feature requests are welcome. Feel free to fork this repo or open issues.

🛡️ License
This project is licensed under the MIT License.

🙏 Acknowledgments
Telegram Bot API

cPanel / php.net documentation

Community scripts that inspired this tool

yaml
Copy
Edit

---

✅ This version:
- Keeps code inside proper code blocks
- Fixes indentation and block formatting
- Prevents any overflow or rendering issues on GitHub

Let me know if you want this turned into a downloadable `README.md` file.
