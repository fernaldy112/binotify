Binotify
=========================================================

#### Table of Contents
- [About](#about)
- [Getting Started](#getting-started)
   - [Prerequisites](#prerequisites)
   - [Creating docker image](#creating-docker-image)
   - [Composing](#composing)
- [Usage](#usage)
- [Demo](#demo)
- [Contributors](#contributors)

## About
Binotify is a simple website for online music streaming. It is built on top
of LAMP (Linux-Apache-MySQL-PHP) and is self-contained using Docker. The website
consists of basic functionalities you could find in various online music
streaming services. It can list recently added songs in its homepage; search
for musics based on title, artist, and published year; play music using
customized audio player; and many more. Binotify also supports authentication
because of which users can sign up and log in to the site. It also provides
admin functionalities, such as adding new songs, adding new albums, modifying
existing song or album data, which can only be done using admin account.
This project is made to fulfill
`Tugas Besar 1 IF3110 Pengembangan Aplikasi Berbasis Web`.

## Getting Started

### Prerequisites

You will need [Docker](https://www.docker.com/) to containerize the web server.

### Creating docker image

To create a docker image for the web server, simply run

```shell
docker build -t tubes-1:latest .
```

in the terminal or run the shell script `./scripts/build-image.sh`.

```shell
sh ./scripts/build-image.sh
```

### Composing

After creating the image compose the image with `mysql` image using

```shell
docker compose up
```

or run

```shell
sh ./scripts/compose.sh
```

## Usage

With the setup done, the port `8008` will now be open to serve requests to
the website. You can open the website locally by accessing `localhost:8008`.
By opening the URL on the browser, you will be greeted with a homepage containing
navigation sidebar, header, and main section which consists of up to 10 most
recent song added. From the homepage, as an unauthenticated user, you may
go to album list page or search for a song you want to listen to. You can also
sign up or log in by clicking one of the buttons on the right of the header.
The rest of the site is pretty much self-explanatory.

## Demo

These are some screen captures of Binotify UI on various pages.
1. Failed to log in
![](demo/failed-login.png)
2. Failed to sign up
![](demo/failed-signup.png)
3. Usable credential validation
![](demo/usable-credential-valiation.png)
4. Homepage as unauthenticated user
![](demo/home-unauth.png)
5. Homepage as logged-in user
![](demo/home-user.png)
6. Homepage as admin
   ![](demo/home-admin.png)
7. Album list page
![](demo/album-list.png)
8. Listen page as user
![](demo/listen-user.png)
9. Listen page as admin
   ![](demo/listen-admin.png)
10. Editing music
![](demo/edit-music.png)
11. Successfully edited music
    ![](demo/edit-music-success.png)
12. Failed to edit music
![](demo/edit-music-failed.png)
13. Listening to music
![](demo/listen-playback.png)
14. Album detail page as user
![](demo/album-detail-user.png)
15. Album detail page as admin
![](demo/album-detail-admin.png)
16. Editing album
![](demo/edit-album.png)
17. Successfully edited album
![](demo/edit-album-success.png)
18. Failed to edit album
![](demo/edit-album-failed.png)
19. Failed to delete album
![](demo/delete-album-failed.png)
20. Successfully deleted music
![](demo/delete-song-success.png)
21. Successfully added new music
![](demo/add-music-success.png)
22. Failed to add new music
![](demo/add-music-failed.png)
23. Successfully added new album
![](demo/add-album-success.png)
24. Failed to add new album
![](demo/add-album-failed.png)
25. Search page
![](demo/search.png)
26. Filtering search result by genre
![](demo/genre-filter.png)
27. Sorting search result by published year
![](demo/search-sort-by-year.png)
28. Search result pagination
![](demo/search-pagination.png)
29. Users list page
![](demo/user-list.png)


## Contributors

Here are the list of contributors by functionalities worked on.

| Feature           | Server-side                  | Client-side                  |
|-------------------|------------------------------|------------------------------|
| Login             | 13520112                     | 13520112                     |
| Register          | 13520112                     | 13520112                     |
| Tambah lagu       | 13520112                     | 13520112                     |
| Hapus lagu        | 13520063, 13520112, 13520166 | 13520063, 13520112, 13520166 |
| Lihat detail lagu | 13520166                     | 13520063, 13520112, 13520166 |
| Ubah detail lagu  | 13520112                     | 13520063, 13520112, 13520166 |
| Dengar lagu       | 13520166                     | 13520063, 13520112, 13520166 |
| Search lagu       | 13520166                     | 13520166                     |
| Sort lagu         | 13520166                     | 13520166                     |
| Filter lagu       | 13520166                     | 13520166                     |
| Tambah album      | 13520063                     | 13520063                     |
| Edit album        | 13520063, 13520112, 13520166 | 13520063                     |
| Hapus album       | 13520063, 13520112, 13520166 | 13520063                     |