<?php

namespace App\Observers;

use Exception;
use App\Models\Document;
use App\Handlers\ProducerHandler;
use Illuminate\Support\Facades\Log;

class DocumentObserver
{
    /**
     * Publish error message
     */
    const PUBLISH_ERROR_MESSAGE = 'Publish message to kafka failed';

    /**
     * Kafka producer
     *
     * @var \App\Handlers\Kafka\ProducerHandler
     */
    protected $producerHandler;

    /**
     * InventoryObserver's constructor
     *
     * @param \App\Handlers\Kafka\ProducerHandler $producerHandler
     */
    public function __construct(ProducerHandler $producerHandler)
    {
        $this->producerHandler = $producerHandler;
    }

    public function created(Document $document)
    {
        $this->pushToKafka($document);
    }

    protected function pushToKafka(Document $document)
    {
        try {
            $this->producerHandler->setTopic($document->isImageTopic() ? 'images' : $document->extension)
                ->send($document->toJson(), $document->id);
        } catch (Exception $e) {
            Log::critical(self::PUBLISH_ERROR_MESSAGE, [
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }
}
