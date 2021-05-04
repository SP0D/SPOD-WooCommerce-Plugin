<?php
/**
 * webhook file
 *
 * @since             1.0.0
 * @package           spod_woocommerce_plugin
 *
 */
// status code need spod api
http_response_code(202);

// response need spod api
echo '[accepted]';


define('WP_USE_THEMES', false);
$wp_did_header = true;
require_once( '../../../wp-load.php' );

// webhook data
$webhook_data = file_get_contents("php://input");
$spodData = json_decode($webhook_data);

// check type via webhook url get parameter
$type = sanitize_text_field($_GET['type']);
if (isset($spodData) && isset($spodData->eventType)) {
    $event_type = $spodData->eventType;
    switch ($type):
        case 'order_cancelled':
            $spod_order_id = $spodData->data->order->id;
            if (isset($spod_order_id) && $spod_order_id>0) {
                $ApiOrder = new ApiOrders();
                $ApiOrder->webHookOrder($spod_order_id, $type);
            }
            break;

        case 'order_processed':
            $spod_order_id = $spodData->data->order->id;
            if (isset($spod_order_id) && $spod_order_id>0) {
                if (isset($spod_order_id) && $spod_order_id>0) {
                    $ApiOrder = new ApiOrders();
                    $ApiOrder->webHookOrder($spod_order_id, $type);
                }
            }
            break;

        case 'shipment_sent':
            $spod_order_id = $spodData->data->shipment->id;
            if (isset($spod_order_id) && $spod_order_id>0) {
                if (isset($spod_order_id) && $spod_order_id>0) {
                    $infos = '';
                    if (isset($spodData->data->shipment->tracking[0]->url)) {
                        $infos = $spodData->data->shipment->tracking[0]->url;
                    }
                    $ApiOrder = new ApiOrders();
                    $ApiOrder->webHookOrder($spod_order_id, $type, $infos);
                }
            }
            break;

        case 'article_added':
            if (isset($spodData->data->article->variants[0]->sku)) {
                $ApiArticle = new ApiArticles();
                $ApiArticle->webhookArticle($spodData->data->article);
            }
            break;

        case 'article_updated':
            if (isset($spodData->data->article->variants[0]->sku)) {
                $ApiArticle = new ApiArticles();
                $ApiArticle->webhookArticle($spodData->data->article, 'updated');
            }
            break;

        case 'article_removed':
            if (isset($spodData->data->article->variants[0]->sku)) {
                $ApiArticle = new ApiArticles();
                $ApiArticle->webhookArticle($spodData->data->article, 'delete');
            }
            break;

        default:
            break;

    endswitch;
}