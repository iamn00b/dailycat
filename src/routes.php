<?php
// Routes

// $app->get('/[{name}]', function ($request, $response, $args) {
//     // Sample log message
//     $this->logger->info("Slim-Skeleton '/' route");

use Tgallice\FBMessenger\Messenger;
use Tgallice\FBMessenger\Message\Message;

$app->get('/webhook[/]', function ($req, $res, $args) {
    $query = $req->getQueryParams();
    $body = $res->getBody();

    if (!empty($query['hub_mode']) && 
        $query['hub_mode'] == 'subscribe' && 
        isset($query['hub_verify_token']) && 
        $query['hub_verify_token'] === $this->verify_token) {

        $body->write($query['hub_challenge']);
    } else {
        $body->write('Error');
    }
    return $res->withBody($body);
});

$app->get('/test[/]', function($req, $res, $args) {
    $message = array( 'text' => 'This is a simple text message.' );
    $headers = array('Content-Type' => 'application/json');
    $data = array(
        'recipient' => array( 'id' => 'sender'),
        'message' => $message
    );
    $options = array(
        'access_token' => $this->get('settings')['token']
    );
    $url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$options['access_token'];

    $response = Requests::post($url, $headers, $data, $options);
    var_dump($response->body);
});

$app->post('/webhook[/]', function ($req, $res, $args) {
    $parsedBody = $req->getParsedBody();
    var_dump($parsedBody['entry'][0]);
    $messaging_events = $parsedBody['entry'][0]['messaging'];

    foreach ($messaging_events as $event) {
        $sender = $event['sender']['id'];

        if (isset($event['message']) && isset($event['message']['text'])) {
            $this->logger->info("receive text message : \"". $event['message']['text'] . "\"");
            try {
                // $message = array( 'text' => 'This is a simple echo message: ' . $event['message']['text'] );
                // $messageData = array(
                //     "attachment" => array(
                //       "type" => "template",
                //       "payload" => array(
                //         "template_type" => "generic",
                //         "elements" => [array(
                //           "title" => "First cat",
                //           "subtitle" => "Element #1 of an hscroll",
                //           "image_url" => "http://thecatapi.com/api/images/get"
                //         ),array(
                //           "title" => "Second cat",
                //           "subtitle" => "Element #2 of an hscroll",
                //           "image_url" => "http://placekitten.com/200/300"
                //         )]
                //       )
                //     )
                // );
                // $headers = array('Content-Type' => 'application/json');
                // $data = array(
                //     'recipient' => array( 'id' => $sender),
                //     'message' => $messageData
                // );
                // $options = array(
                //     'access_token' => $this->get('settings')['token']
                // );
                // $url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$options['access_token'];

                // $response = Requests::post($url, $headers, $data);
                // $this->logger->info("send text message object to: ". $url);
                // $this->logger->info("send text message object : ". json_encode($response));

                $messenger = new Messenger($this->get('settings')['token']);
                $message = new Message($sender, 'My Message');
                $response = $messenger->sendMessage($message);

                
            } catch (Exception $e) {
                $this->logger->info("error sending text message object : ". json_encode($e));
            }
            // $this->logger->info("send text message object : ". json_encode($send));
        }
    } 

    return $res->withStatus(200);

    // foreach ($messaging_events as $message) {
    //    $sender = $message->sender->id;

    // } 

  //  {
  //   $event = $messaging_events[i];
  //   $sender = $event['sender']['id'];
  //   if ($event['message'] && $event['message'].text) {
  //     text = event.message.text;
  //     // Handle a text message from this sender
  //     $this->logger->info("Slim-Skeleton '/' route");
  //   }
  // }
  // res.sendStatus(200);
});