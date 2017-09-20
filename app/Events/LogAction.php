<?php

namespace App\Events;

use DB;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class LogAction
{
    use SerializesModels;

    const DO_NOT_LOG = ['id', 'created_at', 'updated_at'];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        try {
            if ($model->getDirty() || $model->wasRecentlyDeleted) {
                DB::table('logs')->insert([
                    'user_id'   => userIdOrSystem(),
                    'row_id'    => $model->id,
                    'data'      => static::_generateData($model),
                    'table'     => $model->getTable(),
                    'type'      => static::_getType($model),
                    'ip'        => @$_SERVER['HTTP_X_REAL_IP'],
                ]);
            }
        } catch (\Exception $e) {
            \Log::info(get_class($this));
            \Log::info('Error: ' . $e->getMessage());
        }
    }

    private static function _generateData($model)
    {
        if ($model->wasRecentlyDeleted) {
            return null;
        }

        $data = [];
        foreach ($model->getDirty() as $field => $new_value) {
            if (! in_array($field, static::DO_NOT_LOG)) {
                $data[$field] = [$model->getOriginal($field), $new_value];
            }
        }
        return json_encode($data);
    }


    /**
     * Get log type
     */
     private static function _getType($model)
     {
         if ($model->wasRecentlyDeleted) {
            return 'delete';
         } else {
            return ($model->wasRecentlyCreated ? 'create' : 'update');
         }
     }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
