# ruasjalantelegrambot

@Ruasjalanbot is bot to sharing latest traffic jam
you may upload pictures/photo , video or Voice through telegram,
the result will displayed on http://ruasjalan.com

I am using Telegrambot sdk here
you should clone or download this code, before using ruasjalantelegrambot code
https://github.com/irazasyed/telegram-bot-sdk



I am using 2 apps here
One will act role as webhook (Telegram will forward users request to here)
the other ones will act role as database server (this apps will store/save images/video/audio uploaded by user)

1. Webhook - Apps that connect telegram Api
set weeb hook by doing this
https://api.telegram.org/botYOURTOKENHERE/setwebhook?url=https://yourhosted-weebhook-hosting-server.com/yourapp/ruasjalanhook.php

2. Webserver - Apps that will connect your hook apss to your database server

Demo:

1. open your telegram messenger, add @ruasjalanbot (http://telegram.me/ruasjalanbot), upload pictures

2. see result at http://ruasjalan.com

Developed By Kukuh TW (kukuhtw.com)
kukuhtw@kukuhtw.com
kukuhtw@gmail.com
@kukuhtwbot http://telegram.me/kukuhtwbot

