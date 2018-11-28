<?php
/**
 * foreground-check.php
 *
 * Check database before start container
 *
 * @category   CategoryName
 * @package    PackageName
 * @author     Francesco Bianco
 * @copyright  2018 Javanile.org
 */

namespace Javanile\HttpRobot;

use GuzzleHttp\Client;

class HttpRobot
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * HttpRobot constructor.
     *
     * @param $args
     */
    public function __construct($args)
    {
        $this->client = new Client($args);
    }

    /**
     *
     *
     * @param $client
     * @param $path
     * @param null $returns
     * @return array
     */
    public function get($path, $returns = null)
    {
        $response = $this->client->request('GET', $path);

        return VALUES($response->getBody()->getContents(), $returns);
    }

    /**
     * @param $path
     * @param null $params
     * @param null $returns
     * @return array
     * @internal param $client
     */
    public function post($path, $params = null, $returns = null)
    {
        $response = $this->client->request('POST', $path, [ 'form_params' => $params ]);

        return static::values($response->getBody()->getContents(), $returns);
    }

    /**
     * @param $html
     * @param $returns
     * @return array
     */
    protected static function values($html, $returns = null)
    {
        if (!$returns) {
            return $html;
        }

        if (!is_array($returns)) {
            $returns = [$returns];
        }

        $prev = libxml_use_internal_errors(true);

        $doc = new DOMDocument();
        $doc->loadHTML($html);
        $xpath = new DOMXPath($doc);

        $returnValues = [];
        foreach ($returns as $key) {
            $returnValues[$key] = $xpath->query('//input[@name="'.$key.'"]/@value')->item(0)->nodeValue;
        }

        libxml_use_internal_errors($prev);

        return count($returns) > 1 ? $returnValues : $returnValues[$returns[0]];
    }
}
