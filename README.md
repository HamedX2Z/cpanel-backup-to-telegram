# PHP Telegram Backup Script 📦🤖

A simple PHP script that creates a full backup of your **MySQL database** and **`public_html` folder** on a cPanel host, compresses it into a `.zip` archive, and sends it straight to a Telegram chat via a bot.

---

## 📋 About

This script automates off-site backups without third-party cloud storage. It’s ideal for developers or sysadmins who run PHP apps (or Telegram bots) on shared or cPanel servers and want quick, external backups delivered to Telegram.

---

## 🚀 Features

- ✅ Dumps your MySQL database  
- ✅ Compresses the entire `public_html` directory  
- ✅ Sends backups to Telegram using a bot  
- ✅ Easy to automate with Cron jobs  
- ✅ Lightweight — no external PHP libraries required  

---

## 📁 Contents

| File          | Purpose                           |
|---------------|-----------------------------------|
| `backup.php`  | Main backup script                |
| `README.md`   | Project information & setup guide |

---

## ⚙️ Setup Instructions

### 1  📥 Download the Script

Clone the repo **or** upload `backup.php` to a safe location in your host:

---

### 2  🛠️ Configuration

Open **`backup.php`** and edit the variables at the top:

~~~php
$botToken   = 'YOUR_TELEGRAM_BOT_TOKEN'; // from @BotFather
$chatId     = 'YOUR_TELEGRAM_CHAT_ID';   // see step 3 below

$dbHost     = 'localhost';               // usually localhost on cPanel
$dbName     = 'cpanel_db_name';
$dbUser     = 'cpanel_db_user';
$dbPass     = 'cpanel_db_password';

$cpanelUser = 'cpanel_username';         // without domain
~~~

Replace each placeholder with your real values and **save the file**.

---

### 3  💬 Get Your Telegram Chat ID

1. Create a bot via **[@BotFather](https://t.me/BotFather)**  
2. Send a message (e.g. `/hi`) to your new bot  
3. In a browser, open  

https://api.telegram.org/bot<YOUR_BOT_TOKEN>/getUpdates

4. Locate `"chat":{"id": <NUMBER>}` — that number is your **`chatId`**.

---

### 4  🧪 Test the Script Manually

SSH into your cPanel account (or use the Terminal feature) and run:

~~~bash
php -q /home/<cpanel-user>/backup/backup.php
~~~

If everything is configured correctly, you’ll receive a `.zip` file in the Telegram chat.

---

### 5  📅 Set Up a Cron Job

Automate daily backups at **03:00** server time:

1. Log in to **cPanel → Cron Jobs**  
2. Add a new Cron entry:

~~~bash
0 3 * * * php -q /home/<cpanel-user>/backup/backup.php
~~~

> **Tip:** Confirm the `php` path if your host uses a version-specific binary (e.g. `php81`).

---

## 💡 Tips

- **`mysqldump`** must be available (it is on most cPanel hosts).  
- Do **not** store backup archives inside `public_html`; keep them private.  
- Telegram bots can upload files up to ~50 MB. For larger data, exclude big folders or split the archive.  
- Rotate or delete old archives if disk space is limited.

---

## 🤝 Contributing

Pull requests, issues, and suggestions are welcome! Feel free to fork and improve.

---

## 🛡️ License

Distributed under the **MIT License**. See the [`LICENSE`](LICENSE) file for details.

---

## 🙏 Acknowledgments

- Telegram Bot API  
- cPanel / php.net documentation  
- Community scripts and tutorials that inspired this tool
