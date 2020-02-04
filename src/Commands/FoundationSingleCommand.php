<?php

namespace Wiltechsteam\FoundationServiceSingle\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Wiltechsteam\FoundationServiceSingle\Events\FoundationInitializationEvent;
use Wiltechsteam\FoundationServiceSingle\LoggerHandler;
use Wiltechsteam\FoundationServiceSingle\Models\Staff;

class FoundationSingleCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'foundation:work';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Foundation Queue Work';

    protected $loggerHandler;

    /**
     * FoundationServiceCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->loggerHandler = new LoggerHandler();
    }

    /**
     * Handle
     *
     */
    public function handle()
    {
        ini_set("memory_limit", "1024M");

        $queue = config('foundation.rabbitmq_queue');

        $consumerTag = 'consumer-' . getmypid();

        $connection = new AMQPStreamConnection(
            config('foundation.rabbitmq_host'),
            config('foundation.rabbitmq_port'),
            config('foundation.rabbitmq_login'),
            config('foundation.rabbitmq_password'),
            '/',
            false,
            'AMQPLAIN',
            null,
            'en_US',
            120,
            120,
            null,
            false,
            60
        );

        $channel = $connection->channel();

        $channel->queue_declare($queue, true, false, true, false);

        $channel->basic_qos(0, 1, false);

        $channel->basic_consume($queue, $consumerTag, false, false, false, false, function ($e) {
            $this->callback($e);
        });

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();

        $connection->close();
    }

    /**
     * 消息处理
     *
     * @param $callback
     */
    private function callback($callback)
    {
        $callback->delivery_info['channel']->basic_ack($callback->delivery_info['delivery_tag']); // 正常拿到消息后对RabbitMQ ack 回复

        $body = $callback->body;

        $bodyData = json_decode($body, true);

        try {
            $fromExchange = $callback->delivery_info['exchange'];

            $this->loggerHandler->messageQueueLog($fromExchange, $bodyData);

            $this->bindEvent($fromExchange, $bodyData);

            $this->info(date('Y-m-d H:i:s') . ' ' . $fromExchange . ' - ' . 'succeed');

        } catch (\Exception $e) {
            $this->loggerHandler->foundationErrorLog($callback->delivery_info['exchange'], $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());

            $this->error(date('Y-m-d H:i:s') . ' ' . $callback->delivery_info['exchange'] . ' - ' . 'error');

            $this->publishError($callback->delivery_info['channel'], $bodyData, $e); // 把错误信息push到错误队列上
        }
    }

    /**
     * 将错误的消息发送的error队列
     * @param $channel
     * @param array $bodyData
     * @param \Exception $error
     */
    private function publishError($channel, array $bodyData, \Exception $error)
    {
        $channel->exchange_declare(config('foundation.rabbitmq_queue_error'), 'direct', false, true, false);

        $channel->queue_bind(config('foundation.rabbitmq_queue_error'), config('foundation.rabbitmq_queue_error'));

        $bodyData["error"] = [
            "code" => $error->getCode(),
            "file" => $error->getFile(),
            "line" => $error->getLine(),
            "trace" => $error->getTraceAsString()
        ];

        $message = new AMQPMessage(json_encode($bodyData), array('content_type' => 'application/json', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));

        $channel->basic_publish($message, config('foundation.rabbitmq_queue_error'));
    }

    /**
     * 绑定事件
     *
     * @param $exchangeName 'HR.Message.Contract.Event:StaffUSAddedEvent'
     * @param $bodyData
     * @return array|null
     * @throws \Exception
     */
    private function bindEvent($exchangeName, $bodyData)
    {
        if (strpos($exchangeName, ':') === false) {
            throw new \Exception('Exchange name is illegality.');
        }

        $exchangeNames = explode(':', $exchangeName);

        $eventClass = config('foundation.events')[$exchangeNames[1]];

        if (!class_exists($eventClass)) {
            throw new \Exception("Event '$eventClass' is not found.");
        }

        return event(new $eventClass($bodyData));
    }

}