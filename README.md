# ruasjalantelegrambot

@Ruasjalanbot is bot to sharing latest traffic jam
you may upload pictures/photo , video or Voice through telegram,
the result will displayed on http://ruasjalan.com

Developed By Kukuh TW (kukuhtw.com)
kukuhtw@kukuhtw.com
kukuhtw@gmail.com
@kukuhtwbot http://telegram.me/kukuhtwbot

I am using Telegrambot sdk here
https://github.com/irazasyed/telegram-bot-sdk

I am using 2 apps here
One will act role as webhook (Telegram will forward users request to here)
the other ones will act role as database server (this apps will store/save images/video/audio uploaded by user)

1. Webhook - Apps that connect telegram Api
set weeb hook by doing this
https://api.telegram.org/botYOURTOKENHERE/setwebhook?url=https://yourhosted-weebhook-hosting-server.com/yourapp/ruasjalanhook.php

2. Webserver - Apps that will connect your hook apss to your database server

Demo:
1. open your telegram messenger, add @ruasjalanbot, upload pictures
2. see result at ruasjalan.com

