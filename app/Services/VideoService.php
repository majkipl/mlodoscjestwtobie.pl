<?php

namespace App\Services;

class VideoService
{

    /**
     * @param $id
     * @return string
     */
    public function getVimeoImageId($id): string
    {
        $url = 'http://vimeo.com/api/v2/video/' . $id . '.xml';
        $xmlData = file_get_contents($url);

        $xml = simplexml_load_string($xmlData);

        $title = $xml->video->title;
        $thumbnailUrl = $xml->video->thumbnail_large;


        return strval($thumbnailUrl);
    }

    /**
     * @param $url
     * @return int|string
     */
    public function getVideoImageID($url)
    {
        switch ($this->getVideoServiceType($url)) {
            case 'youtube':
                return $this->getYoutubeImageId($this->getVideoIdFromUrl($url));
            case 'vimeo':
                return $this->getVimeoImageId($this->getVideoIdFromUrl($url));
            default:
                return 0;
        }

    }

    /**
     * @param $url
     * @return mixed|string|null
     */
    public function getVideoIdFromUrl($url)
    {
        switch ($this->getVideoServiceType($url)) {
            case 'youtube':
                $query = parse_url($url, PHP_URL_QUERY);
                parse_str($query, $params);
                if (isset($params['v'])) {
                    return $params['v'];
                } elseif (preg_match('/embed\/([A-Za-z0-9\-_]+)/', $url, $matches)) {
                    return $matches[1];
                }
            case 'vimeo':
                $path = parse_url($url, PHP_URL_PATH);
                if (preg_match('/(\d+)/', $path, $matches)) {
                    return $matches[1];
                }
                break;
        }

        return null; // Jeśli nie można wyodrębnić ID
    }

    /**
     * @param $id
     * @return string
     */
    public function getYoutubeImageId($id): string
    {
        return 'https://img.youtube.com/vi/' . $id . '/default.jpg';
    }

    /**
     * @param $url
     * @return string
     */
    public function getVideoServiceType($url): string
    {
        if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
            return 'youtube';
        }

        if (strpos($url, 'vimeo.com') !== false) {
            return 'vimeo';
        }

        return 'unknown';
    }
}
