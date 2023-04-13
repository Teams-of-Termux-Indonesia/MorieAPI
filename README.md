# Morie API

Morie API is a collection of free APIs that you can use whenever you need, just like the name Morie comes from Japanese which means a forest with many trees, that's how this project describes a collection of APIs or is called a tree.

### Get your IP address

```bash
http://hostname/api/rap/ip
```

### Send Gmail API Messages

```bash
http://hostname/api/rap/gmail/send/
```

-   email
    Enter your email as the sender.
-   password
    fill in your gmail account application password.
-   name
    fill in your email account name.
-   title
    Enter the title of your message.
-   message
    the contents of the message what you want to send change the text or html code.
-   to
    Fill in the destination email that you want to send the message to.

#### Example

```bash
http://hostname/api/rap/gmail/send/?email=xxxxx@gmail.com&password=xxxxxxxxxx&name=Jhon Doe&title=Hari, here is a message for you&message=How are you?&to=xxxxx@gmail.com
```

### Facebook API

```bash
http://hostname/api/rap/facebook/video/<url>
```

### Instagram API

```bash
http://hostname/api/rap/instagram/profile/<url>
```

### YouTube API

```bash
http://hostname/api/rap/youtube/video/<url>
http://hostname/api/rap/youtube/channel/<url>
```

### TikTok API

```bash
http://hostname/api/rap/tiktok/video/<url>
http://hostname/api/rap/tiktok/audio/<url>
```
