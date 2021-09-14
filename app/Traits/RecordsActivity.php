<?php


namespace App\Traits;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait RecordsActivity
{
    protected static function bootRecordsActivity ()
    {
        foreach (self::getRecordableEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($model->getDescription($event));
            });
        }
    }

    protected static function getRecordableEvents () : array
    {
        if (isset(static::$recordableEvents)) {
            return static::$recordableEvents;
        }
        return ['created', 'updated', 'deleted'];
    }

    protected function getDescription (string $event) : string
    {
        return $event . '_' . Str::lower(class_basename($this));
    }

    public function recordActivity (string $type)
    {
        $this->activities()->create([
            'description' => $type,
            'changes' => $this->getActivityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
            'user_id' => auth()->id() ?: ($this->project ?? $this)->owner->id,
        ]);
    }

    protected function getActivityChanges ()
    {
        if ($this->wasChanged()) {
            return [
                'before' => Arr::except(
                    array_diff($this->getRawOriginal(), $this->getAttributes()),
                    ['updated_at']
                ),
                'after' => Arr::except($this->getChanges(), 'updated_at'),
            ];
        }

        return null;
    }
}
