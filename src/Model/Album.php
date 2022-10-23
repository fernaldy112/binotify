<?php

namespace Binotify\Model;

class Album
{

    private int $id;
    private string $title;
    private string $artist;
    private int $total_duration;
    private string $image_path;
    private string $publish_date;
    private string $genre;


    function __construct(
        int $id,
        string $title,
        string $artist,
        int $total_duration,
        string $image_path,
        string $publish_date,
        string $genre,
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->artist = $artist;
        $this->total_duration = $total_duration;
        $this->image_path = $image_path;
        $this->publish_date = $publish_date;
        $this->genre = $genre;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
    public function getArtist(): string
    {
        return $this->artist;
    }

   /**
     * @return int
     */
    public function getTotalDuration(): int
    {
        return $this->total_duration;
    }

    /**
     * @return string
     */
    public function getTotalDurationString(): string
    {
        $hour = intdiv($this->total_duration, 3600);
        $minutePortion = $this->total_duration % 3600;
        $min = intdiv($minutePortion, 60);
        $sec = $minutePortion % 60;

        $total_duration = "";

        if ($hour > 0) {
            $total_duration = "$hour:";
            $min = str_pad($min, 2, "0", 2);
        }

        $sec = str_pad($sec, 2, "0", 2);
        return $total_duration."$min:$sec";
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
    public function getGenre(): string
    {
        return $this->genre;
    }

}