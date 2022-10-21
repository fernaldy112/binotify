<?php

namespace Binotify\Model;

class Song
{
    private int $id;
    private string $title;
    private string $artist;
    private string $publish_date;
    private string $genre;
    private int $duration;
    private string $audio_path;
    private string $image_path;
    private int $album_id;

    function __construct(
        int $id,
        string $title,
        string $artist,
        string $publish_date,
        string $genre,
        int $duration,
        string $audio_path,
        string $image_path,
        int $album_id,
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->artist = $artist;
        $this->publish_date = $publish_date;
        $this->genre = $genre;
        $this->duration = $duration;
        $this->audio_path = $audio_path;
        $this->image_path = $image_path;
        $this->album_id = $album_id;
    }
}