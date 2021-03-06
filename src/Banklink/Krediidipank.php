<?php

namespace Banklink;

use Banklink\Protocol\iPizza;

/**
 * Banklink implementation for Krediidipank bank using iPizza protocol for communication
 * For specs see http://www.krediidipank.ee/business/settlements/bank-link/tehniline_kirjeldus_inglise.pdf
 *
 * @author Roman Marintsenko <inoryy@gmail.com>
 * @since  1.11.2012
 */
class Krediidipank extends Banklink
{
    protected $requestUrl = 'https://i-pank.krediidipank.ee/teller/maksa';
    protected $testRequestUrl = 'https://pangalink.net/banklink/008/krediidipank';

    protected $responseEncoding = 'ISO-8859-13';

    /**
     * Force iPizza protocol
     *
     * @param \Banklink\iPizza $protocol
     * @param boolean          $testMode
     * @param string | null    $requestUrl
     */
    public function __construct(iPizza $protocol, $testMode = false, $requestUrl = null)
    {
        parent::__construct($protocol, $testMode, $requestUrl);
    }

    /**
     * Check for encoding field under VK_CHARSET
     *
     * @param array $responseData
     *
     * @return string
     */
    protected function getResponseEncoding(array $responseData)
    {
        if (isset($responseData['VK_CHARSET'])) {
            return $responseData['VK_CHARSET'];
        }

        return $this->responseEncoding;
    }

    /**
     * Force UTF-8 encoding
     *
     * @see Banklink::getAdditionalFields()
     *
     * @return array
     */
    protected function getAdditionalFields()
    {
        return array(
            'VK_CHARSET' => 'UTF-8'
        );
    }
}