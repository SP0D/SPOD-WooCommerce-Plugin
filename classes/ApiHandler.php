<?php
/**
 * Base API Class
 *
 * @link       https://www.spod.com
 * @since      1.0.0
 * @package    spod_woocommerce_plugin
 * @subpackage spod_woocommerce_plugin/classes
 */

class ApiHandler
{
    protected $api_url = 'https://rest.spod.com/';

    /**
     * get main curl options
     * @since      1.0.0
     * @return array $options
     */
     protected function getOptions()
     {
         $options = [
             CURLOPT_HTTPHEADER => [
                 'Accept: application/json',
                 'Content-Type: application/json',
                 'User-Agent: WooCommerce/1.0',
                 'X-SPOD-ACCESS-TOKEN: ' . get_option('ng_spod_plugin_token')
             ],
             CURLOPT_RETURNTRANSFER => true,
         ];

         return $options;
     }

    /**
     * set request via curl
     * @since      1.0.0
     * @param string $api_url
     * @param string $method
     * @param array $params
     * @param array $data
     * @param string $request
     * @return string $data
     */
    public function setRequest($api_url, $method = 'get', $params = [], $data = [], $request = '')
    {
        $curl_url_params = '';

        if ( count($params)>0 ) {
            $curl_url_params = '?';
            foreach($params as $key => $value) {
                $curl_url_params.= $key.'='.$value.'&';
            }
        }
        $ch = curl_init();
        curl_setopt_array($ch, $this->getOptions());
        curl_setopt($ch, CURLOPT_URL,  $api_url.$curl_url_params);
        curl_setopt($ch, CURLOPT_POST, ($method==='get' ? 0 : 1) );
        if ( count($data)>0 ) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        if( $request!=='' ) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
        }

        $return_data = curl_exec($ch);

        curl_close($ch);

        return json_decode($return_data);
    }
}