# Morie API

Morie API is a collection of free APIs that you can use whenever you need, just like the name Morie comes from Japanese which means a forest with many trees, that's how this project describes a collection of APIs or is called a tree.



<div align="center">
    <img src="/icon.png" alt="icon">
</div>


## get anime news

```url
http://localhost/api/senpai/anime/news
```



### Get your IP address

```url
http://localhost/api/rap/ip
```

### Send Gmail API Messages

```url
http://localhost/api/rap/gmail/send/
```

-   email : Enter your email as the sender.
-   password : fill in your gmail account application password.
-   name : fill in your email account name.
-   title : Enter the title of your message.
-   message : the contents of the message what you want to send change the text or html code.
-   to : Fill in the destination email that you want to send the message to.

#### Example

```url
http://localhost/api/rap/gmail/send/?email=xxxxx@gmail.com&password=xxxxxxxxxx&name=Jhon Doe&title=Hari, here is a message for you&message=How are you?&to=xxxxx@gmail.com
```

### Facebook API

```url
http://localhost/api/rap/facebook/video/?url=<url>
```

### Instagram API

```url
http://localhost/api/rap/instagram/profile/?url=<url>
```

### YouTube API

```url
http://localhost/api/rap/youtube/video/?url=<url>
http://localhost/api/rap/youtube/channel/?url=<url>
```

### TikTok API

```url
http://localhost/api/rap/tiktok/video/?url=<url>
http://localhost/api/rap/tiktok/audio/?url=<url>
```


### Otakudesu API

- All
  ```url
  http://localhost/api/fdev/anime/all
  ```
- Specific Anime
  ```url
  http://localhost/api/fdev/anime/:uid
  ```



> © Teams of Termux Indonesia 2023