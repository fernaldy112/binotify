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
    private string $album_title;

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
        string $album_title
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
        $this->album_title = $album_title;
    }

    public static function deserialize($deserialized, $albumTitle): Song
    {
        return new Song(
            $deserialized["song_id"],
            $deserialized["judul"],
            $deserialized["penyanyi"],
            $deserialized["tanggal_terbit"],
            $deserialized["genre"],
            $deserialized["duration"],
            $deserialized["audio_path"],
            $deserialized["image_path"],
            $deserialized["album_id"],
            $albumTitle
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getAlbumId(): int
    {
        return $this->album_id;
    }

    /**
     * @return string
     */
    public function getArtist(): string
    {
        return $this->artist;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getImagePath(): string
    {
        return $this->image_path;
    }

    /**
     * @return string
     */
    public function getPublishDate(): string
    {
        return $this->publish_date;
    }

    /**
     * @return string
     */
    public function getPublishDateString(): string
    {
        $date = date_create($this->publish_date);
        return $date->format("j M Y");
    }

    /**
     * @return string
     */
    public function getAudioPath(): string
    {
        return $this->audio_path;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getDurationString(): string
    {
        $hour = intdiv($this->duration, 3600);
        $minutePortion = $this->duration % 3600;
        $min = intdiv($minutePortion, 60);
        $sec = $minutePortion % 60;

        $duration = "";

        if ($hour > 0) {
            $duration = "$hour:";
            $min = str_pad($min, 2, "0", 2);
        }

        $sec = str_pad($sec, 2, "0", 2);
        return $duration."$min:$sec";
    }

    /**
     * @return string
     */
    public function getGenre(): string
    {
        return $this->genre;
    }

    /**
     * @return string
     */
    public function getAlbumTitle(): string
    {
        return $this->album_title;
    }
}